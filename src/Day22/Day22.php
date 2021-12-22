<?php

namespace Bake\AdventOfCode2021\Day22;

class Day22
{
  public static function input($handle): iterable
  {
    while ($vals = fscanf($handle, '%s x=%d..%d,y=%d..%d,z=%d..%d')) {
      [$state, $min_x, $max_x, $min_y, $max_y, $min_z, $max_z] = $vals;
      yield new Cuboid(
        State::from($state),
        new Range($min_x, $max_x),
        new Range($min_y, $max_y),
        new Range($min_z, $max_z),
      );
    }
  }

  public static function part1(Cuboid ...$cuboids): int
  {
    $cubes = [];
    foreach ($cuboids as $cuboid) {
      foreach ($cuboid->each(-50, 50) as $point) {
        $cubes["{$point}"] = match ($cuboid->state) {
          State::On => 1,
          State::Off => 0,
        };
      }
    }
    return array_sum($cubes);
  }

  public static function part2(Cuboid ...$cuboids): int
  {
    $cs = [];
    foreach ($cuboids as $cuboid) {
      foreach ($cs as $c) {
        if (!$cuboid->intersect($c)) continue;
        $cs[] = $cuboid->overlap($c);
      }
      if ($cuboid->state == State::On) {
        $cs[] = $cuboid;
      }
    }
    return array_sum(array_map(fn (Cuboid $c): int => match ($c->state) {
      State::On => $c->volume(),
      State::Off => -$c->volume(),
    }, $cs));
  }
}
