<?php

namespace Bake\AdventOfCode2021\Day02;

test('day 2 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  forward 5
  down 5
  forward 8
  up 3
  down 8
  forward 2
  PLAIN);
  $commands = [...Day02::input($handle)];
  expect(Day02::part1($commands))->toBe(150);
  expect(Day02::part2($commands))->toBe(900);
})->group('day2', 'sample');

test('day 2 input', function (): void {
  $handle = fopen('src/Day02/input.txt', 'r+');
  $commands = [...Day02::input($handle)];
  expect(Day02::part1($commands))->toBe(1694130);
  expect(Day02::part2($commands))->toBe(1698850445);
})->group('day2', 'input');
