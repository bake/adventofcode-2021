<?php

namespace Bake\AdventOfCode2021\Day20;

class Day20
{
  public static function input($handle): array
  {
    $input = stream_get_contents($handle);
    [$algorithm, $image] = explode(PHP_EOL . PHP_EOL, $input);
    return [trim($algorithm), new Image(trim($image))];
  }

  public static function part1(string $algorithm, Image $image): int
  {
    $image = $image->enhance($algorithm, $image);
    $image = $image->enhance($algorithm, $image);
    return $image->lit();
  }

  public static function part2(string $algorithm, Image $image): int
  {
    for ($i = 0; $i < 50; $i++) {
      $image = $image->enhance($algorithm, $image);
    }
    return $image->lit();
  }
}
