<?php

namespace Bake\AdventOfCode2021\Day05;

class Day05
{
  /** @return []Line */
  public static function input($handle): iterable
  {
    while ($vals = fscanf($handle, "%d,%d -> %d,%d")) {
      [$x1, $y1, $x2, $y2] = $vals;
      yield new Line(new Point($x1, $y1), new Point($x2, $y2));
    }
  }

  /** @param []Line $lines */
  public static function part1(array $lines): int
  {
    $lines = [
      ...array_filter($lines, fn ($l) => $l->p1->x === $l->p2->x),
      ...array_filter($lines, fn ($l) => $l->p1->y === $l->p2->y),
    ];
    $overlaps = [];
    foreach ($lines as $l) {
      foreach ($l->points() as $p) {
        $overlaps["{$p}"] ??= 0;
        $overlaps["{$p}"]++;
      }
    }
    $overlaps = array_filter($overlaps, fn ($n) => $n > 1);
    $overlaps = count($overlaps);
    return $overlaps;
  }

  /** @param []Line $lines */
  public static function part2(array $lines): int
  {
    $overlaps = [];
    foreach ($lines as $l) {
      foreach ($l->points() as $p) {
        $overlaps["{$p}"] ??= 0;
        $overlaps["{$p}"]++;
      }
    }
    $overlaps = array_filter($overlaps, fn ($n) => $n > 1);
    $overlaps = count($overlaps);
    return $overlaps;
  }
}
