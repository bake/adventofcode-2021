<?php

namespace Bake\AdventOfCode2021\Day17;

class Point
{
  public function __construct(
    public int $x,
    public int $y,
  ) {
  }

  public static function zero(): self
  {
    return new self(0, 0);
  }

  public function __toString(): string
  {
    return "{$this->x},{$this->y}";
  }
}
