<?php

enum Direction: string {
  case Forward = 'forward';
  case Up = 'up';
  case Down = 'down';
}

class Command {
  public function __construct(
    public readonly Direction $direction,
    public readonly int $units,
  )
  {}
}

function input($handle): array
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

function part1(array $commands): int
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

function part2(array $commands): int
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

$input = input(STDIN);
echo part1($input) . PHP_EOL;
echo part2($input) . PHP_EOL;
