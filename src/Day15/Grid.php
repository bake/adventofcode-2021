<?php

namespace Bake\AdventOfCode2021\Day15;

class Grid
{
  public function __construct(private array $grid)
  {
  }

  public static function ofSize(int $width, int $height, mixed $value): self
  {
    return new self(array_fill(0, $height, array_fill(0, $width, $value)));
  }

  public function width(): int
  {
    return count($this->grid[0]);
  }

  public function height(): int
  {
    return count($this->grid);
  }

  public function set(Point $p, mixed $value): void
  {
    $this->grid[$p->y][$p->x] = $value;
  }

  public function get(Point $p): mixed
  {
    return $this->grid[$p->y][$p->x];
  }

  public function each(): iterable
  {
    foreach (array_keys($this->grid) as $y) {
      foreach (array_keys($this->grid[$y]) as $x) {
        yield new Point($x, $y);
      }
    }
  }

  public function adjacent(Point $p): iterable
  {
    $delta = [[0, -1], [-1, 0], [0, 1], [1, 0]];
    foreach ($delta as [$dx, $dy]) {
      if ($p->y + $dy < 0 || $p->y + $dy >= count($this->grid)) {
        continue;
      }
      if ($p->x + $dx < 0 || $p->x + $dx >= count($this->grid[$p->y])) {
        continue;
      }
      yield new Point($p->x + $dx, $p->y + $dy);
    }
  }

  public function sprintPath(array $path): string
  {
    $str = '';
    foreach ($this->grid as $y => $row) {
      foreach ($row as $x => $value) {
        $light = (int) in_array(new Point($x, $y), $path);
        $fg = 30;
        $str .= sprintf("\e[%d;%dm%d\e[0m", $light, $fg, $value);
      }
      $str .= PHP_EOL;
    }
    return $str;
  }
}
