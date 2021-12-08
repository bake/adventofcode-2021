<?php

function input($handle): iterable
{
    while ($line = fgets($handle)) {
        $line = explode(' | ', $line);
        $signal = array_map('trim', explode(' ', $line[0]));
        $output = array_map('trim', explode(' ', $line[1]));
        yield [$signal, $output];
    }
}

function part1(array $entries): int
{
    return array_sum(array_map(fn ($e) => count(array_filter($e[1], fn ($o) => in_array(strlen($o), [2, 3, 4, 7]),)), $entries,));
}

// This has to be refactored.
function part2(array $entries): int
{
    $length_segment = [
        2 => 1,
        3 => 7,
        4 => 4,
        7 => 8,
    ];
    $sum = 0;
    foreach ($entries as [$signal, $output]) {
        $signal = array_map(function (string $num): string {
            $num = str_split($num);
            sort($num);
            return implode('', $num);
        }, $signal);
        $output = array_map(function (string $num): string {
            $num = str_split($num);
            sort($num);
            return implode('', $num);
        }, $output);

        $test = [];
        foreach ($signal as $num) {
            if (!isset($length_segment[strlen($num)])) {
                continue;
            }
            $test[$length_segment[strlen($num)]] = $num;
        }

        while (count($test) < 10) {
            foreach ($signal as $num) {
                if (isset($length_segment[strlen($num)])) {
                    continue;
                }
                switch (strlen($num)) {
                    case 5:
                        if (isset($test[4]) && count(array_intersect(str_split($num), str_split($test[4]))) === 2) {
                            $test[2] = $num;
                        }
                        if (isset($test[1]) && count(array_intersect(str_split($num), str_split($test[1]))) === 2) {
                            $test[3] = $num;
                        }
                        if (isset($test[2]) && $test[2] !== $num && isset($test[3]) && $test[3] !== $num) {
                            $test[5] = $num;
                        }
                        break;
                    case 6:
                        if (isset($test[1]) && count(array_intersect(str_split($num), str_split($test[1]))) === 1) {
                            $test[6] = $num;
                        }
                        if (isset($test[3]) && count(array_intersect(str_split($num), str_split($test[3]))) === 5) {
                            $test[9] = $num;
                        }
                        if (isset($test[6]) && $test[6] !== $num && isset($test[9]) && $test[9] !== $num) {
                            $test[0] = $num;
                        }
                        break;
                }
            }
        }

        $test = array_flip($test);
        $output = array_map(fn ($num) => $test[$num], $output);
        $sum += (int) implode('', $output);
    }

    return $sum;
}

$input = iterator_to_array(input(STDIN));
echo part1($input) . PHP_EOL;
echo part2($input) . PHP_EOL;
