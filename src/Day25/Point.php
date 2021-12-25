<?php

namespace Bake\AdventOfCode2021\Day25;

class Point
{
  public function __construct(
    public readonly int $x,
    public readonly int $y,
  ) {
  }

  public function move(Cell $cell): Point
  {
    return match ($cell) {
      Cell::Empty => clone $this,
      Cell::East => new Point($this->x + 1, $this->y),
      Cell::South => new Point($this->x, $this->y + 1),
    };
  }

  public function plus(Point $p): Point
  {
    return new Point($this->x + $p->x, $this->y + $p->y);
  }

  public function modulo(Point $p): Point
  {
    return new Point($this->x % $p->x, $this->y % $p->y);
  }
}
