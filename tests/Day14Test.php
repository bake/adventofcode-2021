<?php

use Bake\AdventOfCode2021\Day14\Day14;

test('day 14 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  NNCB

  CH -> B
  HH -> N
  CB -> H
  NH -> C
  HB -> C
  HC -> B
  HN -> C
  NN -> C
  BH -> H
  NC -> B
  NB -> B
  BN -> B
  BB -> N
  BC -> B
  CC -> N
  CN -> C  
  PLAIN);
  [$pairs, $rules] = Day14::input($handle);
  expect(Day14::part1($pairs, $rules))->toBe(1588);
  expect(Day14::part2($pairs, $rules))->toBe(2188189693529);
})->group('day14', 'sample');

test('day 14 input', function (): void {
  $handle = fopen('src/Day14/input.txt', 'r+');
  [$pairs, $rules] = Day14::input($handle);
  expect(Day14::part1($pairs, $rules))->toBe(3408);
  expect(Day14::part2($pairs, $rules))->toBe(3724343376942);
})->group('day14', 'input');
