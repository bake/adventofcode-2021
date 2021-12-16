<?php

namespace Bake\AdventOfCode2021\Day15;

use SplPriorityQueue;

class Queue extends SplPriorityQueue
{
  public function compare($a, $b): int
  {
    return $b <=> $a;
  }
}
