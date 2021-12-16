<?php

use Bake\AdventOfCode2021\Day01\Day01;

test('day 1 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  199
  200
  208
  210
  200
  207
  240
  269
  260
  263
  PLAIN);
  $nums = [...Day01::input($handle)];
  expect(Day01::part1($nums))->toBe(7);
  expect(Day01::part2($nums))->toBe(5);
});

test('day 1 input', function (): void {
  $handle = fopen('src/Day01/input.txt', 'r+');
  $nums = [...Day01::input($handle)];
  expect(Day01::part1($nums))->toBe(1548);
  expect(Day01::part2($nums))->toBe(1589);
});
