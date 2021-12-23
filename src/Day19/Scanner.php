<?php

namespace Bake\AdventOfCode2021\Day19;

class Scanner
{
  /** @param Beacon[] $beacons */
  public function __construct(
    public readonly array $beacons,
  ) {
  }

  public function __toString(): string
  {
    return implode(PHP_EOL, $this->beacons) . PHP_EOL;
  }

  /** @return Beacon[][] */
  public function transformations(): array
  {
    $beacons = [];
    foreach ($this->beacons as $b) {
      foreach ($b->transformations() as $i => $t) {
        $beacons[$i][] = $t;
      }
    }
    return $beacons;
  }
}
