<?php

namespace Bake\AdventOfCode2021\Day10;

class Day10
{
  public static function input($handle): iterable
  {
    while ($line = fgets($handle)) {
      yield str_split(trim($line));
    }
  }

  private static function interprete(array $line): array
  {
    $pairs = ['<' => '>', '(' => ')', '[' => ']', '{' => '}'];
    for ($i = 0; !empty($line); $i++) {
      $brace = array_shift($line);
      if (in_array($brace, ['<', '(', '[', '{'])) {
        $stack[] = $brace;
        continue;
      }
      $stack_brace = array_pop($stack);
      if ($brace !== $pairs[$stack_brace]) {
        return [$i, $stack, InterpretionError::UNECPECTED_BRACE];
      }
    }
    if (!empty($stack)) {
      return [$i, $stack, InterpretionError::UNEXPECTED_EOF];
    }
    return [$i, $stack, null];
  }

  public static function part1(array $lines): int
  {
    $points = [')' => 3, ']' => 57, '}' => 1197, '>' => 25137];
    $sum = 0;
    foreach ($lines as $line) {
      [$n,, $error] = self::interprete($line);
      if ($error !== InterpretionError::UNECPECTED_BRACE) {
        continue;
      }
      $brace = $line[$n];
      $sum += $points[$brace];
    }
    return $sum;
  }

  public static function part2(array $lines): int
  {
    $points = [')' => 1, ']' => 2, '}' => 3, '>' => 4];
    $pairs = ['<' => '>', '(' => ')', '[' => ']', '{' => '}'];
    $scores = [];
    foreach ($lines as $line) {
      [, $stack, $error] = self::interprete($line);
      if ($error !== InterpretionError::UNEXPECTED_EOF) {
        continue;
      }
      $stack = array_reverse($stack);
      $stack = array_map(fn ($brace) => $pairs[$brace], $stack);
      $sum = 0;
      foreach ($stack as $brace) {
        $sum *= 5;
        $sum += $points[$brace];
      }
      $scores[] = $sum;
    }
    sort($scores);
    return $scores[(int) (count($scores) / 2)];
  }
}
