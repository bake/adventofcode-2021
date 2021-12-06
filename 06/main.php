<?php

/** @return []int */
function input($handle): array
{
  $nums = stream_get_contents($handle);
  $nums = explode(',', $nums);
  $nums = array_map(fn ($n) => (int) $n, $nums);
  return $nums;
}

/** @param []int $nums */
function part1(array $nums, int $days): int
{
  for ($i = 0; $i < $days; $i++) {
    foreach ($nums as &$n) {
      if ($n-- === 0) {
        $n = 6;
        $nums[] = 9;
      }
    }
  }
  return count($nums);
}

/** @param []int $nums */
function part2(array $nums, int $days): int
{
  $prev = array_count_values($nums);
  for ($i = 0; $i < $days; $i++) {
    $curr = [];
    foreach ($prev as $d => $n) {
      if ($d === 0) {
        $curr[8] ??= 0;
        $curr[8] += $n;
        $d = 7;
      }
      $curr[$d - 1] ??= 0;
      $curr[$d - 1] += $n;
    }
    $prev = $curr;
  }
  return array_sum($prev);
}

$input = input(STDIN);
echo part1($input, 80) . PHP_EOL;
echo part2($input, 256) . PHP_EOL;
