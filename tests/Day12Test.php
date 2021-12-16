<?php

use Bake\AdventOfCode2021\Day12\Day12;

test('day 12 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  start-A
  start-b
  A-c
  A-b
  b-d
  A-end
  b-end
  PLAIN);
  $input = Day12::input($handle);
  expect(Day12::part1($input))->toBe(10);
  expect(Day12::part2($input))->toBe(36);
});

test('day 12 slightly larger sample', function (): void {
  $input = <<<PLAIN
  dc-end
  HN-start
  start-kj
  dc-start
  dc-HN
  LN-dc
  HN-end
  kj-sa
  kj-HN
  kj-dc  
  PLAIN;
  $handle = fopen('php://memory', 'r+');
  fwrite($handle, $input);
  rewind($handle);

  $input = Day12::input($handle);
  expect(Day12::part1($input))->toBe(19);
  expect(Day12::part2($input))->toBe(103);
});

test('day 12 even larger sample', function (): void {
  $input = <<<PLAIN
  fs-end
  he-DX
  fs-he
  start-DX
  pj-DX
  end-zg
  zg-sl
  zg-pj
  pj-he
  RW-he
  fs-DX
  pj-RW
  zg-RW
  start-pj
  he-WI
  zg-he
  pj-fs
  start-RW  
  PLAIN;
  $handle = fopen('php://memory', 'r+');
  fwrite($handle, $input);
  rewind($handle);

  $input = Day12::input($handle);
  expect(Day12::part1($input))->toBe(226);
  expect(Day12::part2($input))->toBe(3509);
});

test('day 12 input', function (): void {
  $handle = fopen('src/Day12/input.txt', 'r+');

  $input = Day12::input($handle);
  expect(Day12::part1($input))->toBe(5178);
  expect(Day12::part2($input))->toBe(130094);
});
