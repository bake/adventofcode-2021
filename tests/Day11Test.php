<?php

use Bake\AdventOfCode2021\Day11\Day11;

test('day 11 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  5483143223
  2745854711
  5264556173
  6141336146
  6357385478
  4167524645
  2176841721
  6882881134
  4846848554
  5283751526
  PLAIN);
  $input = Day11::input($handle);
  expect(Day11::part1(clone $input))->toBe(1656);
  expect(Day11::part2(clone $input))->toBe(195);
})->group('day11', 'sample');

test('day 11 input', function (): void {
  $handle = fopen('src/Day11/input.txt', 'r+');
  $input = Day11::input($handle);
  expect(Day11::part1(clone $input))->toBe(1697);
  expect(Day11::part2(clone $input))->toBe(344);
})->group('day11', 'input');
