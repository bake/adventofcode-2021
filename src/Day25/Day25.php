<?php

namespace Bake\AdventOfCode2021\Day25;

class Day25
{
  public static function input($handle): Grid
  {
    return new Grid(stream_get_contents($handle));
  }

  private static function step(Grid $grid): Grid
  {
    $tmp = clone $grid;

    foreach ($grid->each() as [$p, $cell]) {
      if ($cell !== Cell::East) continue;
      $q = $p->move($cell);
      if ($grid->at($q) !== Cell::Empty) continue;
      $tmp->set($p, Cell::Empty);
      $tmp->set($q, $cell);
    }
    $grid = clone $tmp;

    foreach ($grid->each() as [$p, $cell]) {
      if ($cell !== Cell::South) continue;
      $q = $p->move($cell);
      if ($grid->at($q) !== Cell::Empty) continue;
      $tmp->set($p, Cell::Empty);
      $tmp->set($q, $cell);
    }
    return $tmp;
  }

  public static function part1(Grid $grid): int
  {
    $prev = '';
    for ($i = 0; $prev !== (string) $grid; $i++) {
      $prev = (string) $grid;
      $grid = self::step($grid);
    }
    return $i;
  }

  public static function part2(Grid $grid): int
  {
    return 0;
  }
}
