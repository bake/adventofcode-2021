<?php

namespace Bake\AdventOfCode2021\Day11;

class Grid
{
  public function __construct(private array $grid)
  {
  }

  public function width(): int
  {
    return count($this->grid[0]);
  }

  public function height(): int
  {
    return count($this->grid);
  }

  public function set(int $x, int $y, int $value): void
  {
    $this->grid[$y][$x] = $value;
  }

  public function add(int $x, int $y, int $n): void
  {
    $this->grid[$y][$x] += $n;
  }

  public function get(int $x, int $y): int
  {
    return $this->grid[$y][$x];
  }

  public function each(): iterable
  {
    foreach ($this->grid as $y => $row) {
      foreach ($row as $x => $value) {
        yield [$x, $y, $value];
      }
    }
  }

  public function adjacent(int $x, int $y): iterable
  {
    for ($dy = -1; $dy <= 1; $dy++) {
      for ($dx = -1; $dx <= 1; $dx++) {
        if ($dy === 0 && $dx === 0) {
          continue;
        }
        if ($y + $dy < 0 || $y + $dy >= $this->height()) {
          continue;
        }
        if ($x + $dx < 0 || $x + $dx >= $this->width()) {
          continue;
        }
        yield [$x + $dx, $y + $dy];
      }
    }
  }

  public function __toString()
  {
    $str = '';
    foreach ($this->grid as $row) {
      foreach ($row as $value) {
        [$light, $fg] = $value === 0 || $value >= 10 ? [0, 37] : [1, 30];
        $str .= sprintf("\e[%d;%dm%d\e[0m", $light, $fg, $value % 10);
      }
      $str .= PHP_EOL;
    }
    return $str;
  }
}
