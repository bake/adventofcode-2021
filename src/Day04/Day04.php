<?php

namespace Bake\AdventOfCode2021\Day04;

class Day04
{
  public static function input($handle)
  {
    $input = stream_get_contents($handle);
    [$nums, $boards] = explode(PHP_EOL . PHP_EOL, $input, 2);
    $boards = explode(PHP_EOL . PHP_EOL, trim($boards));

    $nums = explode(',', trim($nums));
    $nums = array_map(fn ($num) => (int) $num, $nums);

    $boards = array_map(fn ($b) => explode(PHP_EOL, $b), $boards);
    $boards = array_map(fn ($b) => array_filter($b), $boards);
    $boards = array_map(fn ($b) => array_map(fn ($r) => str_replace('  ', ' ', trim($r)), $b), $boards);
    $boards = array_map(fn ($b) => array_map(fn ($r) => explode(' ', $r), $b), $boards);
    $boards = array_map(fn ($b) => array_map(fn ($r) => array_map(fn ($c) => (int) $c, $r), $b,), $boards);

    return [$nums, $boards];
  }

  private static function print_board(array $board): void
  {
    foreach ($board as $r) {
      foreach ($r as $c) {
        if ($c === INF) $c = '-';
        echo sprintf(' %2s', $c);
      }
      echo PHP_EOL;
    }
  }

  private static function remove_from_board($num, $board)
  {
    return array_map(fn ($r) => array_map(fn ($c) => $c !== $num ? $c : INF, $r), $board);
  }

  private static function win_board(array $board): bool
  {
    $rs = array_map(fn ($r) => min($r), $board);
    $rs = array_filter($rs, fn ($r) => $r === INF);
    if (!empty($rs)) return true;
    $cs = array_map(fn ($i) => array_column($board, $i), range(0, count($board)));
    $cs = array_filter($cs);
    $cs = array_map(fn ($r) => min($r), $cs);
    $cs = array_filter($cs, fn ($r) => $r === INF);
    if (!empty($cs)) return true;
    return false;
  }

  private static function sum_board(array $board): int
  {
    $sum = array_merge(...$board);
    $sum = array_filter($sum, fn ($c) => $c !== INF);
    $sum = array_sum($sum);
    return $sum;
  }

  public static function part1(array $nums, array $boards): int
  {
    while (count(array_filter($boards, fn (array $b): bool => self::win_board($b))) === 0) {
      $num = array_shift($nums);
      $boards = array_map(fn ($b) => self::remove_from_board($num, $b), $boards);
    }
    $board = array_values(array_filter($boards, fn (array $b): bool => self::win_board($b)))[0];
    $sum = self::sum_board($board);
    return $num * $sum;
  }

  public static function part2(array $nums, array $boards): int
  {
    while (!empty($boards)) {
      $num = array_shift($nums);
      $boards = array_map(fn ($b) => self::remove_from_board($num, $b), $boards);
      $sum = self::sum_board(reset($boards));
      $boards = array_filter($boards, fn ($b) => !self::win_board($b));
    }
    return $num * $sum;
  }
}
