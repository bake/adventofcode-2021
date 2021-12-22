<?php

namespace Bake\AdventOfCode2021\Day22;

class Cuboid
{
  public function __construct(
    public readonly State $state,
    public readonly Range $xs,
    public readonly Range $ys,
    public readonly Range $zs,
  ) {
  }

  public function intersect(Cuboid $c): bool
  {
    if ($c->xs->min > $this->xs->max || $this->xs->min > $c->xs->max) {
      return false;
    }
    if ($c->xs->max < $this->xs->min || $this->xs->min > $c->xs->max) {
      return false;
    }
    if ($c->ys->min > $this->ys->max || $this->ys->min > $c->ys->max) {
      return false;
    }
    if ($c->zs->min > $this->zs->max || $this->zs->min > $c->zs->max) {
      return false;
    }
    return true;
  }

  public function overlap(Cuboid $c): Cuboid
  {
    return new Cuboid(
      $c->state->toggle(),
      new Range(
        max($this->xs->min, $c->xs->min),
        min($this->xs->max, $c->xs->max),
      ),
      new Range(
        max($this->ys->min, $c->ys->min),
        min($this->ys->max, $c->ys->max),
      ),
      new Range(
        max($this->zs->min, $c->zs->min),
        min($this->zs->max, $c->zs->max),
      ),
    );
  }

  public function volume(): int
  {
    return array_product([
      $this->xs->max - $this->xs->min + 1,
      $this->ys->max - $this->ys->min + 1,
      $this->zs->max - $this->zs->min + 1,
    ]);
  }

  public function each(int|float $min = -INF, int|float $max = INF): iterable
  {
    foreach ($this->xs->each($min, $max) as $x) {
      foreach ($this->ys->each($min, $max) as $y) {
        foreach ($this->zs->each($min, $max) as $z) {
          yield new Point($x, $y, $z);
        }
      }
    }
  }
}
