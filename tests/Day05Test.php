<?php

use Bake\AdventOfCode2021\Day05\Day05;

test('day 5 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  0,9 -> 5,9
  8,0 -> 0,8
  9,4 -> 3,4
  2,2 -> 2,1
  7,0 -> 7,4
  6,4 -> 2,0
  0,9 -> 2,9
  3,4 -> 1,4
  0,0 -> 8,8
  5,5 -> 8,2  
  PLAIN);
  $nums = [...Day05::input($handle)];
  expect(Day05::part1($nums))->toBe(5);
  expect(Day05::part2($nums))->toBe(12);
})->group('day5', 'sample');

test('day 5 input', function (): void {
  $handle = fopen('src/Day05/input.txt', 'r+');
  $nums = [...Day05::input($handle)];
  expect(Day05::part1($nums))->toBe(5632);
  expect(Day05::part2($nums))->toBe(22213);
})->group('day5', 'input');
