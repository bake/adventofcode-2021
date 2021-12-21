<?php

namespace Bake\AdventOfCode2021\Day21;

class DeterministicDice
{
  private int $position = -1;

  public function __construct(
    private readonly int $max = 100,
  ) {
  }

  public function roll(): int
  {
    $this->position += 1;
    return $this->position % $this->max + 1;
  }

  public function rolled(): int
  {
    return $this->position + 1;
  }
}
