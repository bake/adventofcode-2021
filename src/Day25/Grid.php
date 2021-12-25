<?php

namespace Bake\AdventOfCode2021\Day25;

class Grid
{
  /** @var Cell[][] */
  private array $grid;

  public function __construct(string $grid)
  {
    $this->grid = explode(PHP_EOL, trim($grid));
    $this->grid = array_map(str_split(...), $this->grid);
    $this->grid = array_map(
      fn (array $row) => array_map(Cell::from(...), $row),
      $this->grid,
    );
  }

  public function at(Point $p): Cell
  {
    $p = $p->modulo($this->size());
    return $this->grid[$p->y][$p->x];
  }

  public function set(Point $p, Cell $cell): void
  {
    $p = $p->modulo($this->size());
    $this->grid[$p->y][$p->x] = $cell;
  }

  public function size(): Point
  {
    return new Point(count($this->grid[0]), count($this->grid));
  }

  public function each(): iterable
  {
    foreach ($this->grid as $y => $row) {
      foreach ($row as $x => $cell) {
        yield [new Point($x, $y), $cell];
      }
    }
  }

  public function __toString(): string
  {
    [$str, $y] = ['', 0];
    foreach ($this->each() as [$p, $cell]) {
      if ($p->y !== $y) $str .= PHP_EOL;
      $y = $p->y;
      $str .= $cell->string();
    }
    return $str;
  }
}
