<?php

namespace Bake\AdventOfCode2021\Day18;

/**
 * Using a tree would be the boring solution.
 */
class Day18
{
  /** @return string[] */
  public static function input($handle): array
  {
    return explode(PHP_EOL, trim(stream_get_contents($handle)));
  }

  public static function add(string $a, string $b): string
  {
    $num = "[{$a},{$b}]";
    $prev = null;
    while ($num !== $prev) {
      $prev = $num;
      while (self::canExplode($num)) {
        $num = self::explode($num);
      }
      if (self::canSplit($num)) {
        $num = self::split($num);
      }
    }
    return $num;
  }

  public static function sum(string ...$nums): string
  {
    $num = array_shift($nums);
    while (!empty($nums)) {
      $num = self::add($num, array_shift($nums));
    }
    return $num;
  }

  private static function canExplode(string $num): bool
  {
    $depth = 0;
    foreach (str_split($num) as $c) {
      $depth += match ($c) {
        '[' => 1,
        ']' => -1,
        default => 0,
      };
      if ($depth >= 5) {
        return true;
      }
    }
    return false;
  }

  public static function explode(string $num): string
  {
    $depth = 0;
    $explode = [INF, -INF];
    foreach (str_split($num) as $i => $c) {
      if ($depth >= 5) {
        $explode[0] = min($explode[0], $i);
        $explode[1] = max($explode[1], $i + 1);
      }
      if ($depth < 5 && $explode[0] < INF && $explode[1] > -INF) {
        $mid = substr($num, $explode[0], $explode[1] - $explode[0]);
        [$a, $b] = explode(',', $mid);
        [$a, $b] = [(int) $a, (int) $b];
        $left = substr($num, 0, $explode[0] - 1);
        $left = self::addToLastNumber($left, $a);
        $right = substr($num, $explode[1]);
        $right = self::addToFirstNumber($right, $b);
        return "{$left}0{$right}";
      }
      $depth += match ($c) {
        '[' => 1,
        ']' => -1,
        default => 0,
      };
    }
    return $num;
  }

  private static function string_reverse(string $str): string
  {
    return implode(array_reverse(str_split($str)));
  }

  private static function addToLastNumber(string $num, int $n): string
  {
    $num = self::string_reverse($num);
    if (preg_match('/\d+/', $num, $match)) {
      $search = reset($match);
      $replace = self::string_reverse($n + (int) self::string_reverse($search));
      $num = preg_replace("/{$search}/", $replace, $num, 1);
      return self::string_reverse($num);
    }
    return $num;
  }

  private static function addToFirstNumber(string $num, int $n): string
  {
    if (preg_match('/\d+/', $num, $match)) {
      $search = reset($match);
      $replace = $n + (int) $search;
      return preg_replace("/{$search}/", $replace, $num, 1);
    }
    return $num;
  }

  private static function canSplit(string $num): bool
  {
    return (bool) preg_match('/\d{2,}/', $num);
  }

  public static function split(string $num): string
  {
    if (preg_match('/\d{2,}/', $num, $match)) {
      $search = reset($match);
      $a = (int) floor(((int) $search) / 2);
      $b = (int) ceil(((int) $search) / 2);
      return preg_replace("/{$search}/", "[{$a},{$b}]", $num, 1);
    }
    return $num;
  }

  public static function magnitude(string|int $num): int
  {
    if (is_numeric($num)) {
      return $num;
    }
    $num = json_decode($num);
    return 3 * self::magnitude(json_encode($num[0])) + 2 * self::magnitude(json_encode($num[1]));
  }

  /** @param string[] $nums */
  public static function part1(array $nums): int
  {
    return self::magnitude(self::sum(...$nums));
  }

  /** @param string[] $nums */
  public static function part2(array $nums): int
  {
    $max = 0;
    foreach ($nums as $a) {
      foreach ($nums as $b) {
        $max = max($max, self::magnitude(self::add($a, $b)));
      }
    }
    return $max;
  }
}
