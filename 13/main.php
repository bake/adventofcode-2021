<?php

/**
 * Today is a slow day. You need to give the program at least 2GB ram and a few
 * seconds to run.
 *
 * $ php -d memory_limit=2G main.php < input.txt
 *
 * Good enough.
 */

function input($handle): array
{
  [$points, $folds] = explode(PHP_EOL . PHP_EOL, stream_get_contents($handle));

  $points = explode(PHP_EOL, trim($points));
  $points = array_map(fn (string $p): array => sscanf($p, '%d,%d'), $points);

  $folds = explode(PHP_EOL, trim($folds));
  $folds = array_map(fn (string $f): array => sscanf($f, 'fold along %c=%d'), $folds);

  $width = max(array_column($points, 0));
  $height = max(array_column($points, 1));
  $grid = [];
  for ($y = 0; $y <= $height; $y++) {
    $grid[$y] ??= [];
    for ($x = 0; $x <= $width; $x++) {
      $grid[$y][$x] ??= [];
      $grid[$y][$x] = in_array([$x, $y], $points);
    }
  }

  return [$grid, $folds];
}

function sprint_grid(array $grid): string
{
  $str = '';
  for ($y = 0; $y < count($grid); $y++) {
    for ($x = 0; $x < count($grid[$y]); $x++) {
      $str .= $grid[$y][$x] ? '##' : '..';
    }
    $str .= PHP_EOL;
  }
  return $str;
}

enum Direction
{
  case Clockwise;
  case Counterclockwise;
}

function rotate(array $matrix, Direction $direction): array
{
  $matrix = match ($direction) {
    Direction::Clockwise => $matrix,
    Direction::Counterclockwise => array_map('array_reverse', $matrix),
  };
  return call_user_func_array('array_map', [-1 => null] + $matrix);
}

function fold(array $grid, string $direction, int $index): array
{
  $grid = match ($direction) {
    'x' => rotate($grid, Direction::Counterclockwise),
    'y' => $grid,
  };

  $a = array_slice($grid, 0, $index);
  $b = array_slice($grid, $index + 1, count($grid) - $index - 1);
  $b = array_reverse($b);

  foreach (array_keys($a) as $y) {
    foreach (array_keys($a[$y]) as $x) {
      $a[$y][$x] = (bool) max($a[$y][$x], $b[$y][$x]);
    }
  }

  return match ($direction) {
    'x' => rotate($a, Direction::Clockwise),
    'y' => $a,
  };
}

function part1(array $grid, array $folds): int
{
  [$direction, $index] = array_shift($folds);
  $grid = fold($grid, $direction, $index);
  return array_sum(array_map(fn (array $row) => array_sum($row), $grid));
}

function part2(array $grid, array $folds): string
{
  foreach ($folds as [$direction, $index]) {
    $grid = fold($grid, $direction, $index);
  }
  return sprint_grid($grid);
}

[$grid, $folds] = input(STDIN);
echo part1($grid, $folds) . PHP_EOL;
echo part2($grid, $folds) . PHP_EOL;
