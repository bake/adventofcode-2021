<?php

namespace Bake\AdventOfCode2021\Day22;

class Point
{
  public function __construct(
    public readonly int $x,
    public readonly int $y,
    public readonly int $z,
  ) {
  }

  public function __toString(): string
  {
    return "({$this->x},{$this->y},{$this->z})";
  }
}
