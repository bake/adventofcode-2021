<?php

namespace Bake\AdventOfCode2021\Day05;

class Point
{
  public function __construct(
    public readonly int $x,
    public readonly int $y,
  ) {
  }

  public function __toString()
  {
    return "{$this->x},{$this->y}";
  }
}
