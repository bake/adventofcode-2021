<?php

namespace Bake\AdventOfCode2021\Day15;

class Point
{
  public function __construct(public readonly int $x, public readonly int $y)
  {
  }

  public function subtract(self $q): self
  {
    return new Point($this->x - $q->x, $this->y - $q->y);
  }

  public function __toString()
  {
    return "{$this->x},{$this->y}";
  }
}
