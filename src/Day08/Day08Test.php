<?php

namespace Bake\AdventOfCode2021\Day08;

test('day 8 larger sample', function (): void {
  $handle = string_to_stream(<<<PLAIN
  be cfbegad cbdgef fgaecd cgeb fdcge agebfd fecdb fabcd edb | fdgacbe cefdb cefbgd gcbe
  edbfga begcd cbg gc gcadebf fbgde acbgfd abcde gfcbed gfec | fcgedb cgb dgebacf gc
  fgaebd cg bdaec gdafb agbcfd gdcbef bgcad gfac gcb cdgabef | cg cg fdcagb cbg
  fbegcd cbd adcefb dageb afcb bc aefdc ecdab fgdeca fcdbega | efabcd cedba gadfec cb
  aecbfdg fbg gf bafeg dbefa fcge gcbea fcaegb dgceab fcbdga | gecf egdcabf bgf bfgea
  fgeab ca afcebg bdacfeg cfaedg gcfdb baec bfadeg bafgc acf | gebdcfa ecba ca fadegcb
  dbcfg fgd bdegcaf fgec aegbdf ecdfab fbedc dacgb gdcebf gf | cefg dcbef fcge gbcadfe
  bdfegc cbegaf gecbf dfcage bdacg ed bedf ced adcbefg gebcd | ed bcgafe cdgba cbgef
  egadfb cdbfeg cegd fecab cgb gbdefca cg fgcdab egfdb bfceg | gbdfcae bgc cg cgb
  gcafb gcf dcaebfg ecagb gf abcdeg gaef cafbge fdbac fegbdc | fgae cfgab fg bagce
  PLAIN);
  $nums = [...Day08::input($handle)];
  expect(Day08::part1($nums))->toBe(26);
  expect(Day08::part2($nums))->toBe(61229);
})->group('day8', 'sample');

test('day 8 input', function (): void {
  $handle = fopen('src/Day08/input.txt', 'r+');
  $nums = [...Day08::input($handle)];
  expect(Day08::part1($nums))->toBe(294);
  expect(Day08::part2($nums))->toBe(973292);
})->group('day8', 'input');
