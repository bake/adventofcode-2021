<?php

namespace Bake\AdventOfCode2021\Day21;

class Day21
{
  public static function input($handle): iterable
  {
    while ([, $position] = fscanf($handle, 'Player %d starting position: %d')) {
      yield new Player($position - 1);
    }
  }

  public static function part1(Player $p1, Player $p2): int
  {
    $d = new DeterministicDice;
    while (true) {
      foreach ([$p1, $p2] as $i => &$p) {
        $p->move($d->roll() + $d->roll() + $d->roll());
        if ($p->score() >= 1000) {
          return $d->rolled() * [$p1, $p2][$i + 1 % 2]->score();
        }
      }
    }
    return -1;
  }

  private static function play(Player $p1, Player $p2, array &$cache = [])
  {
    $cache_key = "$p1,$p2";
    if (isset($cache[$cache_key])) {
      return $cache[$cache_key];
    }

    if ($p1->score >= 21) return [1, 0];
    if ($p2->score >= 21) return [0, 1];
    $wins1 = $wins2 = 0;

    for ($i = 1; $i <= 3; $i++) {
      for ($j = 1; $j <= 3; $j++) {
        for ($k = 1; $k <= 3; $k++) {
          $roll = $i + $j + $k;
          $rolls[] = $i + $j + $k;
          $p3 = new Player($p1->position + $roll);
          $p3->score = $p1->score + $p3->position + 1;
          [$w2, $w1] = self::play($p2, $p3, $cache);
          $wins1 += $w1;
          $wins2 += $w2;
        }
      }
    }

    return $cache[$cache_key] = [$wins1, $wins2];
  }

  public static function part2(Player $p1, Player $p2): int
  {
    return max(self::play($p1, $p2));
  }
}
