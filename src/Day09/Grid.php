<?php

namespace Bake\AdventOfCode2021\Day09;

class Grid
{
  public function __construct(private array $grid)
  {
  }

  // Draw a colorful grid.
  public function __toString()
  {
    $color = function (string $str, int $color): string {
      $bg = 41 + ($color % 6);
      return sprintf("\e[0;30;%dm%s\e[0m", $bg, $str);
    };
    $str = '';
    foreach ($this->grid as $row) {
      foreach ($row as $value) {
        if ($value === 0) {
          $str .= '  ';
          continue;
        }
        $str .= $color('  ', $value);
      }
      $str .= PHP_EOL;
    }
    return $str;
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

  public function get(int $x, int $y): int
  {
    return $this->grid[$y][$x];
  }

  public function values(): iterable
  {
    foreach ($this->grid as $y => $row) {
      foreach ($row as $x => $value) {
        yield [$x, $y, $value];
      }
    }
  }

  public function adjacent(int $x, int $y): iterable
  {
    $delta = [[0, -1], [-1, 0], [0, 1], [1, 0]];
    foreach ($delta as [$dx, $dy]) {
      if ($y + $dy < 0 || $y + $dy >= count($this->grid)) {
        continue;
      }
      if ($x + $dx < 0 || $x + $dx >= count($this->grid[$y])) {
        continue;
      }
      yield $this->grid[$y + $dy][$x + $dx];
    }
  }
}
