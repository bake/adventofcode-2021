<?php

namespace Bake\AdventOfCode2021\Day21;

test('day 21 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  Player 1 starting position: 4
  Player 2 starting position: 8
  PLAIN);
  [$p1, $p2] = [...Day21::input($handle)];
  expect(Day21::part1(clone $p1, clone $p2))->toBe(739785);
  expect(Day21::part2(clone $p1, clone $p2))->toBe(444356092776315);
})->group('day21', 'sample');

test('day 21 input', function (): void {
  $handle = fopen('src/Day21/input.txt', 'r+');
  [$p1, $p2] = [...Day21::input($handle)];
  expect(Day21::part1(clone $p1, clone $p2))->toBe(913560);
  expect(Day21::part2(clone $p1, clone $p2))->toBe(110271560863819);
})->group('day21', 'input');
