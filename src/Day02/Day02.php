<?php

namespace Bake\AdventOfCode2021\Day02;

class Day02
{
  public static function input($handle): array
  {
    $commands = [];
    while ($vals = fscanf($handle, "%s %d")) {
      list($direction, $units) = $vals;
      array_push($commands, new Command(
        Direction::from($direction),
        $units,
      ));
    }
    return $commands;
  }

  public static function part1(array $commands): int
  {
    [$x, $y] = [0, 0];
    foreach ($commands as $command) {
      $x += match ($command->direction) {
        Direction::Forward => $command->units,
        default => 0,
      };
      $y += match ($command->direction) {
        Direction::Up => -$command->units,
        Direction::Down => $command->units,
        default => 0,
      };
    }
    return $x * $y;
  }

  public static function part2(array $commands): int
  {
    [$x, $y, $aim] = [0, 0, 0];
    foreach ($commands as $command) {
      $x += match ($command->direction) {
        Direction::Forward => $command->units,
        default => 0,
      };
      $y += match ($command->direction) {
        Direction::Forward => $aim * $command->units,
        default => 0,
      };
      $aim += match ($command->direction) {
        Direction::Up => -$command->units,
        Direction::Down => $command->units,
        default => 0,
      };
    }
    return $x * $y;
  }
}
