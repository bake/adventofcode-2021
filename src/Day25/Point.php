<?php

namespace Bake\AdventOfCode2021\Day25;

class Point
{
  public function __construct(
    public readonly int $x,
    public readonly int $y,
  ) {
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
