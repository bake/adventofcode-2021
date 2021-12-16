<?php

namespace Bake\AdventOfCode2021\Day02;

class Command
{
  public function __construct(
    public readonly Direction $direction,
    public readonly int $units,
  ) {
  }
}
