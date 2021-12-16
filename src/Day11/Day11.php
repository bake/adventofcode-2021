<?php

namespace Bake\AdventOfCode2021\Day11;

class Day11
{
  public static function input($handle): OctopusGrid
  {
    $grid = [];
    while ($row = fgets($handle)) {
      $grid[] = str_split(trim($row));
    }
    return new OctopusGrid($grid);
  }

  public static function part1(OctopusGrid $grid): int
  {
    for ($i = 1; $i <= 100; $i++) {
      $grid->step($grid);
    }
    return $grid->flashes();
  }

  public static function part2(OctopusGrid $grid): int
  {
    for ($i = 0; $grid->sum() !== 0; $i++) {
      $grid->step();
    }
    return $i;
  }
}
