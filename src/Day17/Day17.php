<?php

namespace Bake\AdventOfCode2021\Day17;

class Day17
{
  public static function input($handle): Rectangle
  {
    [$x1, $x2, $y1, $y2] = fscanf($handle, 'target area: x=%d..%d, y=%d..%d');
    return new Rectangle(new Point($x1, $y1), new Point($x2, $y2));
  }

  public static function part1(Rectangle $target): int
  {
    $max_y = 0;
    for ($vy = 1; $vy < 100; $vy++) {
      for ($vx = 1; $vx < 100; $vx++) {
        $probe = new Probe(Point::zero(), new Point($vx, $vy));
        $local_max_y = $probe->position()->y;
        while (true) {
          $probe->step();
          if ($probe->position()->y < $target->min->y) {
            break;
          }
          if ($target->inside($probe->position())) {
            $max_y = max($max_y, $local_max_y);
            break;
          }
          $local_max_y = max($local_max_y, $probe->position()->y);
        }
      }
    }
    return $max_y;
  }

  /**
   * This is pretty slow.
   */
  public static function part2(Rectangle $target): int
  {
    $num = 0;
    $range = new Rectangle(
      new Point(
        1,
        min($target->min->y, $target->max->y) - 1
      ),
      new Point(
        $target->max->x + 1,
        max(abs($target->min->y), abs($target->max->y)) + 1,
      ),
    );
    foreach ($range->each() as $p) {
      $probe = new Probe(Point::zero(), $p);
      for ($i = 0; $i < 2 * $target->max->x; $i++) {
        $probe->step();
        if ($target->inside($probe->position())) {
          $num++;
          break;
        }
      }
    }
    return $num;
  }
}
