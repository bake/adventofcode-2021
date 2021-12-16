<?php

namespace Bake\AdventOfCode2021\Day01;

class Day01
{
  public static function input($handle): iterable
  {
    while ($num = fgets($handle)) {
      yield (int) $num;
    }
  }

  public static function part1(array $nums): int
  {
    $as = array_slice($nums, 0, count($nums) - 1);
    $bs = array_slice($nums, 1, count($nums) - 1);
    $cs = array_map(fn ($a, $b) => $a - $b < 0, $as, $bs);
    $cs = array_filter($cs);
    return count($cs);
  }

  public static function part2(array $nums): int
  {
    $prev = INF;
    $inc = 0;
    for ($i = 0; $i < count($nums); $i++) {
      $num = array_sum(array_slice($nums, $i + 0, 3));
      if ($num > $prev) {
        $inc++;
      }
      $prev = $num;
    }
    return $inc;
  }
}
