<?php

namespace Bake\AdventOfCode2021\Day03;

class Day03
{
  public static function input($handle): iterable
  {
    while ($row = fgets($handle)) {
      yield array_map(fn ($col) => (int) $col, str_split(trim($row)));
    }
  }

  public static function part1(array $nums): int
  {
    $filter = function ($cmp, array $nums) {
      for ($i = 0; $i < count(reset($nums)); $i++) {
        yield (int) $cmp(array_sum(array_column($nums, $i)), count($nums) / 2);
      }
    };
    $gam = $filter(fn ($a, $b) => $a >= $b, $nums);
    $gam = bindec(implode('', iterator_to_array($gam)));
    $eps = $filter(fn ($a, $b) => $a < $b, $nums);
    $eps = bindec(implode('', iterator_to_array($eps)));
    return $gam * $eps;
  }

  public static function part2(array $nums): int
  {
    $filter = function ($cmp, array $nums): array {
      for ($i = 0; count($nums) > 1 && $i < count(reset($nums)); $i++) {
        $os = array_sum(array_column($nums, $i));
        $keep = $cmp($os, count($nums) / 2);
        $nums = array_filter($nums, fn ($n) => $n[$i] == $keep);
      }
      return reset($nums);
    };
    $oxy = $filter(fn ($a, $b) => $a >= $b, $nums);
    $co2 = $filter(fn ($a, $b) => $a < $b, $nums);
    return bindec(implode('', $oxy)) * bindec(implode('', $co2));
  }
}
