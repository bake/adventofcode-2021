<?php

namespace Bake\AdventOfCode2021\Day08;

class Day08
{
  public static function input($handle): iterable
  {
    while ($line = fgets($handle)) {
      $nums = explode(' ', $line);
      $nums = array_map(trim(...), $nums);
      $nums = array_map(str_split(...), $nums);
      array_walk($nums, fn (&$num) => sort($num));
      $signal = array_slice($nums, 0, 10);
      $output = array_slice($nums, 11, 4);
      yield [$signal, $output];
    }
  }

  public static function part1(array $entries): int
  {
    return array_sum(array_map(fn ($e) => count(array_filter($e[1], fn ($o) => in_array(count($o), [2, 3, 4, 7]),)), $entries,));
  }

  private static function array_find(array $array, callable $callback): mixed
  {
    return array_values(array_filter($array, $callback))[0] ?? null;
  }

  private static function number_intersect(array $a, array $b): int
  {
    return count(array_intersect($a, $b));
  }

  public static function part2(array $entries): int
  {
    $sum = 0;
    foreach ($entries as [$signal, $output]) {
      $test = [
        1 => self::array_find($signal, fn ($num) => count($num) === 2),
        4 => self::array_find($signal, fn ($num) => count($num) === 4),
        7 => self::array_find($signal, fn ($num) => count($num) === 3),
        8 => self::array_find($signal, fn ($num) => count($num) === 7),
      ];

      while (count($test) < 10) {
        foreach ($signal as $num) {
          switch (count($num)) {
            case 5:
              if (self::number_intersect($num, $test[4] ?? []) === 2) {
                $test[2] = $num;
              } else if (self::number_intersect($num, $test[1] ?? []) === 2) {
                $test[3] = $num;
              } else {
                $test[5] = $num;
              }
              break;
            case 6:
              if (self::number_intersect($num, $test[1] ?? []) === 1) {
                $test[6] = $num;
              } else if (self::number_intersect($num, $test[3] ?? []) === 5) {
                $test[9] = $num;
              } else {
                $test[0] = $num;
              }
              break;
          }
        }
      }

      $test = array_map(implode(...), $test);
      $output = array_map(implode(...), $output);
      $test = array_flip($test);
      $output = array_map(fn ($num) => $test[$num], $output);
      $sum += (int) implode('', $output);
    }

    return $sum;
  }
}
