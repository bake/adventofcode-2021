<?php

/**
 * I started the day with a grid which was pretty slow and required a lot
 * memory. It was later rewritten to work directly on the given poitns without
 * creating a big nearly empty array.
 */

namespace Bake\AdventOfCode2021\Day13;

class Day13
{
  public static function input($handle): array
  {
    [$points, $folds] = explode(PHP_EOL . PHP_EOL, stream_get_contents($handle));

    $points = explode(PHP_EOL, trim($points));
    $points = array_map(fn (string $p): array => sscanf($p, '%d,%d'), $points);

    $folds = explode(PHP_EOL, trim($folds));
    $folds = array_map(fn (string $f): array => sscanf($f, 'fold along %c=%d'), $folds);

    return [$points, $folds];
  }

  private static function fold_points(array $points, string $direction, int $index): array
  {
    $tmp = [];
    foreach ($points as [$x, $y]) {
      [$x, $y] = match ($direction) {
        'x' => [$index - abs($x - $index), $y],
        'y' => [$x, $index - abs($y - $index)],
      };
      $tmp["$x,$y"] = [$x, $y];
    }
    return array_values($tmp);
  }

  private static function sprint_points(array $points): string
  {
    $str = '';
    for ($y = 0; $y <= max(array_column($points, 1)); $y++) {
      for ($x = 0; $x <= max(array_column($points, 0)); $x++) {
        $str .= in_array([$x, $y], $points) ? '##' : '  ';
      }
      $str .= PHP_EOL;
    }
    return $str;
  }

  public static function part1(array $points, array $folds): int
  {
    [$direction, $index] = array_shift($folds);
    $points = self::fold_points($points, $direction, $index);
    return count($points);
  }

  public static function part2(array $points, array $folds): string
  {
    foreach ($folds as [$direction, $index]) {
      $points = self::fold_points($points, $direction, $index);
    }
    return self::sprint_points($points);
  }
}
