<?php

namespace Bake\AdventOfCode2021\Day17;

class Rectangle
{
  public function __construct(
    public readonly Point $min,
    public readonly Point $max,
  ) {
  }

  public function inside(Point $p): bool
  {
    if ($p->x < $this->min->x || $p->x > $this->max->x) {
      return false;
    }
    if ($p->y < $this->min->y || $p->y > $this->max->y) {
      return false;
    }
    return true;
  }

  public function each(): iterable
  {
    for ($y = $this->min->y; $y < $this->max->y; $y++) {
      for ($x = $this->min->x; $x < $this->max->x; $x++) {
        yield new Point($x, $y);
      }
    }
  }

  public function __toString(): string
  {
    return "({$this->min}),({$this->max})";
  }
}
