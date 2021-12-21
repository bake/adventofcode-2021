<?php

namespace Bake\AdventOfCode2021\Day16;

test('day 16 sample version 1', function (): void {
  $input = Day16::hexbin('8A004A801A8002F478');
  expect(Day16::part1($input))->toBe(16);
})->group('day16', 'sample');

test('day 16 sample version 2', function (): void {
  $input = Day16::hexbin('620080001611562C8802118E34');
  expect(Day16::part1($input))->toBe(12);
})->group('day16', 'sample');

test('day 16 sample version 3', function (): void {
  $input = Day16::hexbin('C0015000016115A2E0802F182340');
  expect(Day16::part1($input))->toBe(23);
})->group('day16', 'sample');

test('day 16 sample version 4', function (): void {
  $input = Day16::hexbin('A0016C880162017C3686B18A3D4780');
  expect(Day16::part1($input))->toBe(31);
})->group('day16', 'sample');

test('day 16 sample calculate 1', function (): void {
  $input = Day16::hexbin('C200B40A82');
  expect(Day16::part2($input))->toBe(3);
})->group('day16', 'sample');

test('day 16 sample calculate 2', function (): void {
  $input = Day16::hexbin('04005AC33890');
  expect(Day16::part2($input))->toBe(54);
})->group('day16', 'sample');

test('day 16 sample calculate 3', function (): void {
  $input = Day16::hexbin('880086C3E88112');
  expect(Day16::part2($input))->toBe(7);
})->group('day16', 'sample');

test('day 16 sample calculate 4', function (): void {
  $input = Day16::hexbin('CE00C43D881120');
  expect(Day16::part2($input))->toBe(9);
})->group('day16', 'sample');

test('day 16 sample calculate 5', function (): void {
  $input = Day16::hexbin('D8005AC2A8F0');
  expect(Day16::part2($input))->toBe(1);
})->group('day16', 'sample');

test('day 16 sample calculate 6', function (): void {
  $input = Day16::hexbin('F600BC2D8F');
  expect(Day16::part2($input))->toBe(0);
})->group('day16', 'sample');

test('day 16 sample calculate 7', function (): void {
  $input = Day16::hexbin('9C005AC2F8F0');
  expect(Day16::part2($input))->toBe(0);
})->group('day16', 'sample');

test('day 16 sample calculate 8', function (): void {
  $input = Day16::hexbin('9C0141080250320F1802104A08');
  expect(Day16::part2($input))->toBe(1);
})->group('day16', 'sample');

test('day 16 input', function (): void {
  $handle = fopen('src/Day16/input.txt', 'r+');
  $input = Day16::input($handle);
  expect(Day16::part1($input))->toBe(866);
  expect(Day16::part2($input))->toBe(1392637195518);
})->group('day16', 'input');
