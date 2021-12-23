<?php

namespace Bake\AdventOfCode2021\Day19;

class Beacon
{
  public function __construct(
    public readonly int $x,
    public readonly int $y,
    public readonly int $z,
  ) {
  }

  public static function fromString(string $str): self
  {
    return new self(...explode(',', $str));
  }

  public function plus(Beacon $beacon): Beacon
  {
    return new Beacon(
      $this->x + $beacon->x,
      $this->y + $beacon->y,
      $this->z + $beacon->z,
    );
  }

  public function minus(Beacon $beacon): Beacon
  {
    return new Beacon(
      $this->x - $beacon->x,
      $this->y - $beacon->y,
      $this->z - $beacon->z,
    );
  }

  public function distance(Beacon $beacon): int
  {
    return array_sum([
      abs($this->x - $beacon->x),
      abs($this->y - $beacon->y),
      abs($this->z - $beacon->z),
    ]);
  }

  /** @return Beacon[] */
  public function transformations(): iterable
  {
    return [
      new Beacon($this->x, $this->y, $this->z),
      new Beacon($this->x, $this->z, -$this->y),
      new Beacon($this->x, -$this->y, -$this->z),
      new Beacon($this->x, -$this->z, $this->y),
      new Beacon($this->y, $this->x, -$this->z),
      new Beacon($this->y, $this->z, $this->x),
      new Beacon($this->y, -$this->x, $this->z),
      new Beacon($this->y, -$this->z, -$this->x),
      new Beacon($this->z, $this->x, $this->y),
      new Beacon($this->z, $this->y, -$this->x),
      new Beacon($this->z, -$this->x, -$this->y),
      new Beacon($this->z, -$this->y, $this->x),
      new Beacon(-$this->x, $this->y, -$this->z),
      new Beacon(-$this->x, $this->z, $this->y),
      new Beacon(-$this->x, -$this->y, $this->z),
      new Beacon(-$this->x, -$this->z, -$this->y),
      new Beacon(-$this->y, $this->x, $this->z),
      new Beacon(-$this->y, $this->z, -$this->x),
      new Beacon(-$this->y, -$this->x, -$this->z),
      new Beacon(-$this->y, -$this->z, $this->x),
      new Beacon(-$this->z, $this->x, -$this->y),
      new Beacon(-$this->z, $this->y, $this->x),
      new Beacon(-$this->z, -$this->x, $this->y),
      new Beacon(-$this->z, -$this->y, -$this->x),
    ];
  }

  public function __toString(): string
  {
    return "{$this->x},{$this->y},{$this->z}";
  }
}
