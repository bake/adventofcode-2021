<?php

namespace Bake\AdventOfCode2021\Day07;

class Day07
{
  /** @return int[] */
  public static function input($handle): array
  {
    $nums = stream_get_contents($handle);
    $nums = explode(',', $nums);
    $nums = array_map(fn ($n) => (int) $n, $nums);
    return $nums;
  }

  /** @param int[] $nums */
  public static function part1(array $nums): int
  {
    [$min, $max] = [min($nums), max($nums)];
    $diffs = [];
    $nums = array_count_values($nums);
    for ($i = $min; $i < $max; $i++) {
      $diffs[$i] = 0;
      foreach ($nums as $x => $n) {
        $diffs[$i] += $n * abs($i - $x);
      }
    }
    return min($diffs);
  }

  /** @param int[] $nums */
  public static function part2(array $nums): int
  {
    [$min, $max] = [min($nums), max($nums)];
    [$diffs, $dists] = [[], []];
    $nums = array_count_values($nums);
    for ($i = $min; $i < $max; $i++) {
      $diffs[$i] = 0;
      foreach ($nums as $x => $n) {
        $dist = abs($i - $x);
        $dists[$dist] ??= array_sum(range(1, $dist));
        $diffs[$i] += $n * $dists[$dist];
      }
    }
    return min($diffs);
  }
}
