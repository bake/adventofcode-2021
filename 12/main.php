<?php

function input($handle): array
{
  $graph = [];
  while ($row = fgets($handle)) {
    [$a, $b] = explode('-', trim($row));
    $graph[$a] ??= [];
    $graph[$a][] = $b;
    $graph[$b] ??= [];
    $graph[$b][] = $a;
  }
  return $graph;
}

function count_paths(array $graph, string $start, string $end, array $visited = []): int
{
  if ($start === $end) {
    return 1;
  }
  if (ctype_lower($start)) {
    $visited[] = $start;
  }
  $nodes = $graph[$start];
  $nodes = array_filter($nodes, fn (string $n): bool => !in_array($n, $visited));
  $nodes = array_map(fn (string $n): int => count_paths($graph, $n, $end, $visited), $nodes);
  return array_sum($nodes);
}

function part1(array $graph): int
{
  return count_paths($graph, 'start', 'end');
}

function count_paths_2(array $graph, string $start, string $end, array $visited = []): int
{
  if ($start === $end) {
    return 1;
  }
  if (ctype_lower($start)) {
    $visited[$start] ??= 0;
    $visited[$start]++;
  }
  $nodes = $graph[$start];
  $nodes = array_filter($nodes, fn (string $n): bool => $n !== 'start');
  $nodes = array_filter($nodes, fn (string $n): bool => ($visited[$n] ?? 0) < 1 || max(array_values($visited)) <= 1);
  $nodes = array_map(fn (string $n): int => count_paths_2($graph, $n, $end, $visited), $nodes);
  return array_sum($nodes);
}

function part2(array $graph): int
{
  return count_paths_2($graph, 'start', 'end');
}

$input = input(STDIN);
echo part1($input) . PHP_EOL;
echo part2($input) . PHP_EOL;
