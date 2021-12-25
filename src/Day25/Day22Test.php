<?php

namespace Bake\AdventOfCode2021\Day25;

test('day 25 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  v...>>.vv>
  .vv>>.vv..
  >>.>v>...v
  >>v>>.>.v.
  v>v.vv.v..
  >.>>..v...
  .vv..>.>v.
  v.v..>>v.v
  ....v..v.>
  PLAIN);
  $grid = Day25::input($handle);
  expect(Day25::part1($grid))->toBe(58);
})->group('day25', 'sample');

test('day 25 input', function (): void {
  $handle = fopen('src/Day25/input.txt', 'r+');
  $grid = Day25::input($handle);
  expect(Day25::part1($grid))->toBe(582);
})->group('day25', 'input');
