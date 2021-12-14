<?php

function input($handle): array
{
  [$template, $rules] = explode(PHP_EOL . PHP_EOL, stream_get_contents($handle));

  $template = str_split($template);

  $rules = explode(PHP_EOL, trim($rules));
  $rules = array_map(fn (string $r): array => sscanf($r, '%s -> %s'), $rules);
  $rules = array_combine(array_column($rules, 0), array_column($rules, 1));

  $pairs = [];
  for ($i = 0; $i < count($template) - 1; $i++) {
    $p = $template[$i] . $template[$i + 1];
    $pairs[$p] ??= 0;
    $pairs[$p]++;
  }

  return [$pairs, $rules];
}

function step(array $pairs, array $rules): array
{
  $tmp = [];
  foreach ($pairs as $p => $num) {
    [$a, $b] = str_split($p);
    $r = $rules[$p];
    $tmp["{$a}{$r}"] ??= 0;
    $tmp["{$a}{$r}"] += $num;
    $tmp["{$r}{$b}"] ??= 0;
    $tmp["{$r}{$b}"] += $num;
  }
  return $tmp;
}

function quantities(array $pairs): array
{
  $dst = [];
  foreach ($pairs as $p => $num) {
    $dst[$p[1]] ??= 0;
    $dst[$p[1]] += $num;
  }
  $dst[array_keys($pairs)[0][0]]++;
  asort($dst);
  return $dst;
}

function part1(array $pairs, array $rules): int
{
  for ($i = 0; $i < 10; $i++) {
    $pairs = step($pairs, $rules);
  }
  $quantities = quantities($pairs);
  return end($quantities) - reset($quantities);
}

function part2(array $pairs, array $rules): int
{
  for ($i = 0; $i < 40; $i++) {
    $pairs = step($pairs, $rules);
  }
  $qs = quantities($pairs);
  return end($qs) - reset($qs);
}

[$pairs, $rules] = input(STDIN);
echo part1($pairs, $rules) . PHP_EOL;
echo part2($pairs, $rules) . PHP_EOL;
