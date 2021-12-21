<?php

namespace Bake\AdventOfCode2021\Day17;

test('day 17 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  target area: x=20..30, y=-10..-5
  PLAIN);
  $points = Day17::input($handle);
  expect(Day17::part1($points))->toBe(45);
  expect(Day17::part2($points))->toBe(112);
})->group('day17', 'sample');

test('day 17 input', function (): void {
  $handle = fopen('src/Day17/input.txt', 'r+');
  $points = Day17::input($handle);
  expect(Day17::part1($points))->toBe(4656);
  expect(Day17::part2($points))->toBe(1908);
})->group('day17', 'input');
