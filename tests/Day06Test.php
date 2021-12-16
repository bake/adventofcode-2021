<?php

use Bake\AdventOfCode2021\Day06\Day06;

test('day 6 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  3,4,3,1,2
  PLAIN);
  $nums = [...Day06::input($handle)];
  expect(Day06::part1($nums))->toBe(5934);
  expect(Day06::part2($nums))->toBe(26984457539);
});

test('day 6 input', function (): void {
  $handle = fopen('src/Day06/input.txt', 'r+');
  $nums = [...Day06::input($handle)];
  expect(Day06::part1($nums))->toBe(359999);
  expect(Day06::part2($nums))->toBe(1631647919273);
});
