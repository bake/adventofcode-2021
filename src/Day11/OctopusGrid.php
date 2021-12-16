<?php

namespace Bake\AdventOfCode2021\Day11;

class OctopusGrid extends Grid
{
  private int $flashes = 0;

  public function step(): void
  {
    foreach ($this->each() as [$x, $y]) {
      $this->add($x, $y, 1);
    }
    foreach ($this->each() as [$x, $y]) {
      if ($this->get($x, $y) > 9) {
        $this->flash($x, $y);
      }
    }
  }

  private function flash(int $x, int $y): self
  {
    $this->flashes++;
    $this->set($x, $y, 0);
    foreach ($this->adjacent($x, $y) as [$x, $y]) {
      $value = $this->get($x, $y);
      if ($value === 0) {
        continue;
      }
      $this->set($x, $y, $value + 1);
      if ($value + 1 > 9) {
        $this->flash($x, $y);
      }
    }
    return $this;
  }

  public function flashes(): int
  {
    return $this->flashes;
  }

  public function sum(): int
  {
    return array_sum(array_map(fn ($row) => $row[2], [...$this->each()]));
  }
}
