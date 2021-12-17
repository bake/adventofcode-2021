<?php

namespace Bake\AdventOfCode2021\Day17;

class Probe
{
  public function __construct(
    private Point $position,
    private Point $velocity,
  ) {
  }

  public function step(): void
  {
    $this->position->x += $this->velocity->x;
    $this->position->y += $this->velocity->y;
    $this->velocity->x += 0 <=> $this->velocity->x;
    $this->velocity->y -= 1;
  }

  public function position(): Point
  {
    return $this->position;
  }

  public function __toString(): string
  {
    return "({$this->position}) -> {$this->velocity}";
  }
}
