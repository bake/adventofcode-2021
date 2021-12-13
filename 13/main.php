<?php

/**
 * I started the day with a grid which was pretty slow and required a lot
 * memory. It was later rewritten to work directly on the given poitns without
 * creating a big nearly empty array.
 */

function input($handle): array
{
  [$points, $folds] = explode(PHP_EOL . PHP_EOL, stream_get_contents($handle));

  $points = explode(PHP_EOL, trim($points));
  $points = array_map(fn (string $p): array => sscanf($p, '%d,%d'), $points);

  $folds = explode(PHP_EOL, trim($folds));
  $folds = array_map(fn (string $f): array => sscanf($f, 'fold along %c=%d'), $folds);

  return [$points, $folds];
}

function fold_points(array $points, string $direction, int $index): array
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

function sprint_points(array $points): string
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

function part1(array $points, array $folds): int
{
  [$direction, $index] = array_shift($folds);
  $points = fold_points($points, $direction, $index);
  return count($points);
}

function part2(array $points, array $folds): string
{
  foreach ($folds as [$direction, $index]) {
    $points = fold_points($points, $direction, $index);
  }
  return sprint_points($points);
}

[$points, $folds] = input(STDIN);
echo part1($points, $folds) . PHP_EOL;
echo part2($points, $folds) . PHP_EOL;

// function sprint_grid(array $grid): string
// {
//   $str = '';
//   for ($y = 0; $y < count($grid); $y++) {
//     for ($x = 0; $x < count($grid[$y]); $x++) {
//       $str .= $grid[$y][$x] ? '##' : '  ';
//     }
//     $str .= PHP_EOL;
//   }
//   return $str;
// }

// function points_to_grid(array $points): array
// {
//   $grid = [];
//   for ($y = 0; $y <= max(array_column($points, 1)); $y++) {
//     $grid[$y] ??= [];
//     for ($x = 0; $x <= max(array_column($points, 0)); $x++) {
//       $grid[$y][$x] ??= [];
//       $grid[$y][$x] = in_array([$x, $y], $points);
//     }
//   }
//   return $grid;
// }

// enum Direction
// {
//   case Clockwise;
//   case Counterclockwise;
// }

// function rotate_grid(array $matrix, Direction $direction): array
// {
//   $matrix = match ($direction) {
//     Direction::Clockwise => $matrix,
//     Direction::Counterclockwise => array_map('array_reverse', $matrix),
//   };
//   return call_user_func_array('array_map', [-1 => null] + $matrix);
// }

// function fold_grid(array $grid, string $direction, int $index): array
// {
//   $grid = match ($direction) {
//     'x' => rotate_grid($grid, Direction::Counterclockwise),
//     'y' => $grid,
//   };

//   $a = array_slice($grid, 0, $index);
//   $b = array_slice($grid, $index + 1, count($grid) - $index - 1);
//   $b = array_reverse($b);

//   foreach (array_keys($a) as $y) {
//     foreach (array_keys($a[$y]) as $x) {
//       $a[$y][$x] = (bool) max($a[$y][$x], $b[$y][$x]);
//     }
//   }

//   return match ($direction) {
//     'x' => rotate_grid($a, Direction::Clockwise),
//     'y' => $a,
//   };
// }
