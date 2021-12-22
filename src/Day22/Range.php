<?php

namespace Bake\AdventOfCode2021\Day22;

class Range
{
  public function __construct(
    public int $min,
    public int $max,
  ) {
  }

  public function each(int|float $min = -INF, int|float $max = INF): iterable
  {
    [$min, $max] = [(int) max($this->min, $min), (int) min($this->max, $max)];
    for ($i = $min; $i <= $max; $i++) {
      yield $i;
    }
  }
}
