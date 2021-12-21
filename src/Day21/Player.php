<?php

namespace Bake\AdventOfCode2021\Day21;

class Player
{
  public int $score = 0;

  public function __construct(
    public int $position,
    public readonly int $max_position = 10,
  ) {
    $this->position %= $this->max_position;
  }

  public function move(int $steps): void
  {
    $this->position += $steps;
    $this->position %= $this->max_position;
    $this->score += $this->position + 1;
  }

  public function score(): int
  {
    return $this->score;
  }

  public function __toString(): string
  {
    return sprintf('(pos=%s,score=%s)', $this->position + 1, $this->score);
  }
}
