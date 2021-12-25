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

  public function move(Point $p): Point
  {
    return match ($this) {
      self::Empty => clone $p,
      self::East => $p->plus(new Point(1, 0)),
      self::South => $p->plus(new Point(0, 1)),
    };
  }
}
