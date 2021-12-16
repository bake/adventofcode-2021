<?php

namespace Bake\AdventOfCode2021\Day09;

class Day09
{
  public static function input($handle): Grid
  {
    $grid = [];
    while ($row = fgets($handle)) {
      $grid[] = str_split(trim($row));
    }
    return new Grid($grid);
  }

  public static function part1(Grid $grid): int
  {
    $risk = 0;
    foreach ($grid->values() as [$x, $y, $height]) {
      $adj = [...$grid->adjacent($x, $y)];
      $higher = array_filter($adj, fn ($h) => $h > $height);
      if (count($higher) !== count($adj)) {
        continue;
      }
      $risk += 1 + $height;
    }
    return $risk;
  }

  public static function part2(Grid $grid): int
  {
    $is_foreground = fn ($height) => $height < 9;
    $connected = new Grid(array_fill(0, $grid->height(), array_fill(0, $grid->width(), 0)));

    // Label all the cells.
    $label = 1;
    $connections = [];
    foreach ($grid->values() as [$x, $y, $height]) {
      if (!$is_foreground($grid->get($x, $y))) {
        $label++;
        continue;
      }
      $connected_labels = array_filter([...$connected->adjacent($x, $y), $label]);
      foreach ($connected_labels as $connected_label) {
        $connections[$connected_label] = array_merge(
          $connections[$connected_label] ?? [],
          $connected_labels,
        );
      }
      $connected->set($x, $y, min($connected_labels));
      $label++;
    }

    // Update connected cells.
    $min_label = function (array $labels, int $label): int {
      while (($l = min($labels[$label])) !== $label) {
        $label = $l;
      };
      return $l;
    };
    foreach ($connected->values() as [$x, $y, $label]) {
      if (empty($connections[$label])) {
        continue;
      }
      $connected->set($x, $y, $min_label($connections, $label));
    }

    $labels = [];
    foreach ($connected->values() as [,, $label]) {
      $labels[] = $label;
    }
    $labels = array_count_values($labels);
    arsort($labels);

    return array_product(array_slice($labels, 1, 3));
  }
}
