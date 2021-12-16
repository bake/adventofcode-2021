<?php

use Bake\AdventOfCode2021\Day09\Day09;

test('day 9 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  2199943210
  3987894921
  9856789892
  8767896789
  9899965678  
  PLAIN);
  $grid = Day09::input($handle);
  expect(Day09::part1($grid))->toBe(15);
  expect(Day09::part2($grid))->toBe(1134);
});

test('day 9 input', function (): void {
  $handle = fopen('src/Day09/input.txt', 'r+');
  $grid = Day09::input($handle);
  expect(Day09::part1($grid))->toBe(468);
  expect(Day09::part2($grid))->toBe(1280496);
});
