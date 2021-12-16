<?php

namespace Bake\AdventOfCode2021\Day05;

class Line
{
  public function __construct(
    public readonly Point $p1,
    public readonly Point $p2,
  ) {
  }

  public function __toString()
  {
    return "{$this->p1} -> {$this->p2}";
  }

  /** @return []Point */
  public function points(): iterable
  {
    [$p1, $p2] = [$this->p1, $this->p2];
    yield $p1;
    while ("{$p1}" !== "{$p2}") {
      yield $p1 = new Point(
        $p1->x - ($p1->x <=> $p2->x),
        $p1->y - ($p1->y <=> $p2->y),
      );
    }
  }
}
