<?php

namespace Bake\AdventOfCode2021\Day21;

require __DIR__ . '/../../vendor/autoload.php';

function string_to_stream(string $input)
{
  $handle = fopen('php://memory', 'r+');
  fwrite($handle, $input);
  rewind($handle);
  return $handle;
}

$handle = string_to_stream(<<<PLAIN
Player 1 starting position: 4
Player 2 starting position: 8
PLAIN);
[$p1, $p2] = [...Day21::input($handle)];
$out = Day21::part2($p1, $p2);
echo "$out\n";
echo (int) ($out === 444356092776315) . PHP_EOL;
