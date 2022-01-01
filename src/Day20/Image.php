<?php

namespace Bake\AdventOfCode2021\Day20;

class Image
{
  private Point $min;
  private Point $max;
  private array $image;

  public function __construct(
    string $image = '',
    private readonly bool $background = false,
  ) {
    $rows = explode(PHP_EOL, $image);
    $this->min = new Point(0, 0);
    $this->max = new Point(0, 0);
    foreach ($rows as $y => $row) {
      foreach (str_split($row) as $x => $cell) {
        $this->set(new Point($x, $y), $cell === '#');
      }
    }
  }

  public function min(): Point
  {
    return $this->min;
  }

  public function max(): Point
  {
    return $this->max;
  }

  public function at(Point $p): bool
  {
    if ($p->y < $this->min()->y || $p->y > $this->max()->y) return $this->background;
    if ($p->x < $this->min()->x || $p->x > $this->max()->x) return $this->background;
    return $this->image[$p->y][$p->x] ?? false;
  }

  public function set(Point $p, bool $value): void
  {
    $this->min->y = min($this->min->y, $p->y);
    $this->max->y = max($this->max->y, $p->y);
    $this->min->x = min($this->min->x, $p->x);
    $this->max->x = max($this->max->x, $p->x);
    if (!$value && isset($this->image[$p->y][$p->x])) {
      unset($this->image[$p->y][$p->x]);
      return;
    }
    if (!$value) {
      return;
    }
    $this->image[$p->y][$p->x] = true;
  }

  public function neighbours(Point $p): array
  {
    $arr = [];
    for ($y = $p->y - 1; $y <= $p->y + 1; $y++) {
      for ($x = $p->x - 1; $x <= $p->x + 1; $x++) {
        $arr[] = $this->at(new Point($x, $y));
      }
    }
    return $arr;
  }

  /** @return Point[] */
  public function each(int $padding = 0): iterable
  {
    for ($y = $this->min()->y - $padding; $y <= $this->max()->y + $padding; $y++) {
      for ($x = $this->min()->x - $padding; $x <= $this->max()->x + $padding; $x++) {
        yield new Point($x, $y);
      }
    }
  }

  public function enhance(string $algorithm, Image $image): Image
  {
    $tmp = new Image(background: $algorithm[0] === '#' && !$this->background);
    foreach ($this->each(padding: 1) as $p) {
      $tmp->set($p, $this->enhancePixel($algorithm, $image, $p));
    }
    return $tmp;
  }

  private function enhancePixel(string $algorithm, Image $image, Point $p): bool
  {
    $index = 0;
    foreach ($image->neighbours($p) as $v) {
      $index = $index << 1 | $v;
    }
    return $algorithm[$index] === '#';
  }

  public function lit(): int
  {
    return array_sum(array_map(count(...), $this->image));
  }

  public function __toString(): string
  {
    [$str, $y] = ['', $this->min()->y];
    foreach ($this->each() as $p) {
      if ($y < $p->y) $str .= PHP_EOL;
      $y = $p->y;
      $str .= $this->at($p) ? '#' : '.';
    }
    return $str . PHP_EOL;
  }
}
