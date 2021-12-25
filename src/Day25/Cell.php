<?php

namespace Bake\AdventOfCode2021\Day25;

enum Cell: string
{
  case Empty = '.';
  case East = '>';
  case South = 'v';

  public function string(): string
  {
    return match ($this) {
      self::Empty => '.',
      self::East => '>',
      self::South => 'v',
    };
  }
}
