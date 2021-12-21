<?php

namespace Bake\AdventOfCode2021\Day20;

class Point
{
  public function __construct(public int $x, public int $y)
  {
  }

  public function __toString(): string
  {
    return "{$this->x},{$this->y}";
  }
}
