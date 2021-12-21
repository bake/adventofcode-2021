<?php

namespace Bake\AdventOfCode2021\Day03;

test('day 3 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  00100
  11110
  10110
  10111
  10101
  01111
  00111
  11100
  10000
  11001
  00010
  01010
  PLAIN);
  $nums = [...Day03::input($handle)];
  expect(Day03::part1($nums))->toBe(198);
  expect(Day03::part2($nums))->toBe(230);
})->group('day3', 'sample');

test('day 3 input', function (): void {
  $handle = fopen('src/Day03/input.txt', 'r+');
  $nums = [...Day03::input($handle)];
  expect(Day03::part1($nums))->toBe(3847100);
  expect(Day03::part2($nums))->toBe(4105235);
})->group('day3', 'input');
