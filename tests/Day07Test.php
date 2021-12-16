<?php

use Bake\AdventOfCode2021\Day07\Day07;

test('day 7 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  16,1,2,0,4,2,7,1,2,14
  PLAIN);
  $nums = [...Day07::input($handle)];
  expect(Day07::part1($nums))->toBe(37);
  expect(Day07::part2($nums))->toBe(168);
});

test('day 7 input', function (): void {
  $handle = fopen('src/Day07/input.txt', 'r+');
  $nums = [...Day07::input($handle)];
  expect(Day07::part1($nums))->toBe(355592);
  expect(Day07::part2($nums))->toBe(101618069);
});
