<?php

namespace Bake\AdventOfCode2021\Day10;

test('day 10 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  [({(<(())[]>[[{[]{<()<>>
  [(()[<>])]({[<{<<[]>>(
  {([(<{}[<>[]}>{[]{[(<()>
  (((({<>}<{<{<>}{[]{[]{}
  [[<[([]))<([[{}[[()]]]
  [{[{({}]{}}([{[{{{}}([]
  {<[[]]>}<{[{[{[]{()[[[]
  [<(<(<(<{}))><([]([]()
  <{([([[(<>()){}]>(<<{{
  <{([{{}}[<[[[<>{}]]]>[]]
  PLAIN);
  $lines = [...Day10::input($handle)];
  expect(Day10::part1($lines))->toBe(26397);
  expect(Day10::part2($lines))->toBe(288957);
})->group('day10', 'sample');

test('day 10 input', function (): void {
  $handle = fopen('src/Day10/input.txt', 'r+');
  $lines = [...Day10::input($handle)];
  expect(Day10::part1($lines))->toBe(392097);
  expect(Day10::part2($lines))->toBe(4263222782);
})->group('day10', 'input');
