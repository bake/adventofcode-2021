<?php

namespace Bake\AdventOfCode2021\Day15;

test('day 15 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  1163751742
  1381373672
  2136511328
  3694931569
  7463417111
  1319128137
  1359912421
  3125421639
  1293138521
  2311944581  
  PLAIN);
  $grid = Day15::input($handle);
  expect(Day15::part1($grid))->toBe(40);
  expect(Day15::part2($grid))->toBe(315);
})->group('day15', 'sample');

test('day 15 input', function (): void {
  $handle = fopen('src/Day15/input.txt', 'r+');
  $grid = Day15::input($handle);
  expect(Day15::part1($grid))->toBe(398);
  expect(Day15::part2($grid))->toBe(2817);
})->group('day15', 'input');
