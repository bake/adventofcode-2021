<?php

namespace Bake\AdventOfCode2021\Day19;

class Day19
{
  /** @return Scanner[] */
  public static function input($handle): array
  {
    $scanners = stream_get_contents($handle);
    $scanners = explode("\n\n", trim($scanners));
    return array_map(function (string $scanner): Scanner {
      $beacons = explode(PHP_EOL, $scanner);
      $beacons = array_slice($beacons, 1);
      $beacons = array_map(fn (string $b): Beacon => Beacon::fromString($b), $beacons);
      return new Scanner($beacons);
    }, $scanners);
  }

  /** I hate this. */
  private static function match(
    Scanner $scanner,
    array $fixed,
    int $threshold = 12,
  ): array {
    $transformations = $scanner->transformations();
    foreach ($transformations as $transformation_i => $ts) {
      $diffs = [];
      foreach ($ts as $t) {
        foreach ($fixed as $f) {
          $diffs[] = $f->minus($t);
        }
      }
      $diffs = array_map(fn (Beacon $b): string => $b, $diffs);
      $diffs = array_count_values($diffs);
      arsort($diffs);
      if (array_values($diffs)[0] < $threshold) {
        continue;
      }
      $b = Beacon::fromString(array_keys($diffs)[0]);
      $bs = $transformations[$transformation_i];
      $bs = array_map(fn (Beacon $c): Beacon => $c->plus($b), $bs);
      return [$b, $bs];
    }
    return [null, []];
  }

  public static function part1(Scanner ...$scanners): int
  {
    $fixed = array_shift($scanners)->beacons;
    while ($s = array_shift($scanners)) {
      /** @var Scanner[] $bs */
      [, $bs] = self::match($s, $fixed);
      if (empty($bs)) {
        $scanners[] = $s;
        continue;
      }
      $fixed = [...$fixed, ...$bs];
    }
    return count(array_unique($fixed));
  }

  public static function part2(Scanner ...$scanners): int
  {
    /** @var Beacon[] */
    $known = [];
    $fixed = array_shift($scanners)->beacons;
    while ($s = array_shift($scanners)) {
      [$b, $bs] = self::match($s, $fixed);
      if (empty($bs)) {
        $scanners[] = $s;
        continue;
      }
      $known[] = $b;
      $fixed = [...$fixed, ...$bs];
    }
    $max = 0;
    foreach ($known as $s1) {
      foreach ($known as $s2) {
        $max = max($max, $s1->distance($s2));
      }
    }
    return $max;
  }
}
