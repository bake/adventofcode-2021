<?php

namespace Bake\AdventOfCode2021\Day15;

use SplPriorityQueue;

class Day15
{
  public static function input($handle): Grid
  {
    $grid = [];
    while ($row = fgets($handle)) {
      $grid[] = str_split(trim($row));
    }
    return new Grid($grid);
  }

  private static function dijkstra(Grid $grid, Point $src, Point $dst): int
  {
    $queue = new Queue;
    $queue->setExtractFlags(SplPriorityQueue::EXTR_BOTH);
    $queue->insert($src, 0);
    $dists = Grid::ofSize($grid->width(), $grid->height(), INF);
    $dists->set($src, 0);
    while (!$queue->isEmpty()) {
      ['data' => $p, 'priority' => $dist] = $queue->extract();
      foreach ($grid->adjacent($p) as $q) {
        $d = $dist + $grid->get($q);
        if ($d >= $dists->get($q)) {
          continue;
        }
        $dists->set($q, $d);
        $queue->insert($q, $d);
      }
    }
    return $dists->get($dst);
  }

  public static function part1(Grid $grid): int
  {
    $src = new Point(0, 0);
    $dst = new Point($grid->width() - 1, $grid->height() - 1);
    return self::dijkstra($grid, $src, $dst);
  }

  public static function part2(Grid $grid, $scale = 5): int
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
    return self::part1($tmp);
  }
}
