<?php

use Bake\AdventOfCode2021\Day20\Day20;

test('day 17 sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  ..#.#..#####.#.#.#.###.##.....###.##.#..###.####..#####..#....#..#..##..###..######.###...####..#..#####..##..#.#####...##.#.#..#.##..#.#......#.###.######.###.####...#.##.##..#..#..#####.....#.#....###..#.##......#.....#..#..#..##..#...##.######.####.####.#.#...#.......#..#.#.#...####.##.#......#..#...##.#.##..#...##.#.##..###.#......#.#.......#.#.#.####.###.##...#.....####.#..#..#.##.#....##..#.####....##...##..#...#......#.#.......#.......##..####..#...#.#.#...##..#.#..###..#####........#..####......#..#
  
  #..#.
  #....
  ##..#
  ..#..
  ..###  
  PLAIN);
  [$algorithm, $image] = Day20::input($handle);
  expect(Day20::part1($algorithm, $image))->toBe(35);
  expect(Day20::part2($algorithm, $image))->toBe(3351);
})->group('day20', 'sample');

test('day 17 input', function (): void {
  $handle = fopen('src/Day20/input.txt', 'r+');
  [$algorithm, $image] = Day20::input($handle);
  expect(Day20::part1($algorithm, $image))->toBe(4917);
  expect(Day20::part2($algorithm, $image))->toBe(16389);
})->group('day20', 'input');
