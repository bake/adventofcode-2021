<?php

class Point
{
  public function __construct(
    public readonly int $x,
    public readonly int $y,
  ) {
  }

  public function __toString()
  {
    return "{$this->x},{$this->y}";
  }
}

class Line
{
  public function __construct(
    public readonly Point $p1,
    public readonly Point $p2,
  ) {
  }

  public function __toString()
  {
    return "{$this->p1} -> {$this->p2}";
  }

  /** @return []Point */
  public function points(): iterable
  {
    [$p1, $p2] = [$this->p1, $this->p2];
    yield $p1;
    while ("{$p1}" !== "{$p2}") {
      yield $p1 = new Point(
        $p1->x - ($p1->x <=> $p2->x),
        $p1->y - ($p1->y <=> $p2->y),
      );
    }
  }
}

/** @return []Line */
function input($handle): iterable
{
  while ($vals = fscanf($handle, "%d,%d -> %d,%d")) {
    [$x1, $y1, $x2, $y2] = $vals;
    yield new Line(new Point($x1, $y1), new Point($x2, $y2));
  }
}

/** @param []Line $lines */
function part1(array $lines): int
{
  $lines = [
    ...array_filter($lines, fn ($l) => $l->p1->x === $l->p2->x),
    ...array_filter($lines, fn ($l) => $l->p1->y === $l->p2->y),
  ];
  $overlaps = [];
  foreach ($lines as $l) {
    foreach ($l->points() as $p) {
      $overlaps["{$p}"] ??= 0;
      $overlaps["{$p}"]++;
    }
  }
  $overlaps = array_filter($overlaps, fn ($n) => $n > 1);
  $overlaps = count($overlaps);
  return $overlaps;
}

/** @param []Line $lines */
function part2(array $lines): int
{
  $overlaps = [];
  foreach ($lines as $l) {
    foreach ($l->points() as $p) {
      $overlaps["{$p}"] ??= 0;
      $overlaps["{$p}"]++;
    }
  }
  $overlaps = array_filter($overlaps, fn ($n) => $n > 1);
  $overlaps = count($overlaps);
  return $overlaps;
}

$input = iterator_to_array(input(STDIN));
echo part1($input) . PHP_EOL;
echo part2($input) . PHP_EOL;
