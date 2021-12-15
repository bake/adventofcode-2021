<?php

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

class Point
{
  public function __construct(public readonly int $x, public readonly int $y)
  {
  }

  public function subtract(self $q): self
  {
    return new Point($this->x - $q->x, $this->y - $q->y);
  }

  public function __toString()
  {
    return "{$this->x},{$this->y}";
  }
}

function input($handle): Grid
{
  $grid = [];
  while ($row = fgets($handle)) {
    $grid[] = str_split(trim($row));
  }
  return new Grid($grid);
}

/** @return Grid[] */
function dijkstra(Grid $grid, Point $src, Point $dst): array
{
  $ps = [$src];
  $dists = Grid::ofSize($grid->width(), $grid->height(), INF);
  $dists->set($src, 0);
  $prevs = Grid::ofSize($grid->width(), $grid->height(), null);
  while ($p = array_shift($ps)) {
    // asort($ps);
    foreach ($grid->adjacent($p) as $q) {
      $dist = $dists->get($p) + $grid->get($q);
      if ($dist >= $dists->get($q)) {
        continue;
      }
      $dists->set($q, $dist);
      $prevs->set($q, $p);
      $ps[] = $q;
    }
  }
  return [$dists, $prevs];
}

function part1(Grid $grid): int
{
  $src = new Point(0, 0);
  $dst = new Point($grid->width() - 1, $grid->height() - 1);
  [$dists] = dijkstra($grid, $src, $dst);
  return $dists->get($dst);
}

function part2(Grid $grid, $scale = 5): int
{
  // This isn't elegant but it works for now.
  $tmp = Grid::ofSize($grid->width() * $scale, $grid->height() * $scale, 0);
  foreach ($grid->each() as $p) {
    $tmp->set($p, $grid->get($p));
  }
  for ($y = $grid->height(); $y < $grid->height() * $scale; $y++) {
    for ($x = 0; $x < $grid->width(); $x++) {
      $p = new Point($x, $y);
      $q = new Point(0, $grid->height());
      $v = $tmp->get($p->subtract($q)) + 1;
      if ($v > 9) $v = 1;
      $tmp->set(new Point($x, $y), $v);
    }
  }
  for ($y = 0; $y < $grid->height() * $scale; $y++) {
    for ($x = $grid->width(); $x < $grid->width() * $scale; $x++) {
      $p = new Point($x, $y);
      $q = new Point($grid->width(), 0);
      $v = $tmp->get($p->subtract($q)) + 1;
      if ($v > 9) $v = 1;
      $tmp->set(new Point($x, $y), $v);
    }
  }
  return part1($tmp);
}

$grid = input(STDIN);
echo part1($grid) . PHP_EOL;
echo part2($grid) . PHP_EOL;
