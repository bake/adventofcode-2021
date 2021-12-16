<?php

use Bake\AdventOfCode2021\Day13\Day13;

test('day 13 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  6,10
  0,14
  9,10
  0,3
  10,4
  4,11
  6,0
  6,12
  4,1
  0,13
  10,12
  3,4
  3,0
  8,4
  1,10
  2,14
  8,10
  9,0
  
  fold along y=7
  fold along x=5
  PLAIN);
  [$points, $folds] = Day13::input($handle);
  expect(Day13::part1($points, $folds))->toBe(17);
  expect(Day13::part2($points, $folds))->toBe(<<<TEXT
  ##########
  ##      ##
  ##      ##
  ##      ##
  ##########

  TEXT);
});

test('day 13 input', function (): void {
  $handle = fopen('src/Day13/input.txt', 'r+');
  [$points, $folds] = Day13::input($handle);
  expect(Day13::part1($points, $folds))->toBe(716);
  expect(Day13::part2($points, $folds))->toBe(<<<TEXT
  ######    ######      ####    ##    ##  ########  ######    ##        ######  
  ##    ##  ##    ##  ##    ##  ##  ##    ##        ##    ##  ##        ##    ##
  ##    ##  ##    ##  ##        ####      ######    ######    ##        ##    ##
  ######    ######    ##        ##  ##    ##        ##    ##  ##        ######  
  ##  ##    ##        ##    ##  ##  ##    ##        ##    ##  ##        ##  ##  
  ##    ##  ##          ####    ##    ##  ##        ######    ########  ##    ##

  TEXT);
});
