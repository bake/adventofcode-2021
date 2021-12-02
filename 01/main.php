<?php

$nums = [];
while ($num = fgets(STDIN)) {
  array_push($nums, intval($num));
}

function part1(array $nums): int
{
  $as = array_slice($nums, 0, count($nums) - 1);
  $bs = array_slice($nums, 1, count($nums) - 1);
  $cs = array_map(fn ($a, $b) => $a - $b < 0, $as, $bs);
  $cs = array_filter($cs);
  return count($cs);
}

function part2(array $nums): int
{
  $prev = INF;
  $inc = 0;
  for ($i = 0; $i < count($nums); $i++) {
    $num = array_sum(array_slice($nums, $i + 0, 3));
    if ($num > $prev) {
      $inc++;
    }
    $prev = $num;
  }
  return $inc;
}

echo part1($nums) . PHP_EOL;
echo part2($nums) . PHP_EOL;
