<?php

class Grid
{
    public function __construct(private array $grid)
    {
    }

    // Draw a colorful grid.
    public function __toString()
    {
        $color = function (string $str, int $color): string {
            $bg = 41 + ($color % 6);
            return sprintf("\e[0;30;%dm%s\e[0m", $bg, $str);
        };
        $str = '';
        foreach ($this->grid as $row) {
            foreach ($row as $value) {
                if ($value === 0) {
                    $str .= '  ';
                    continue;
                }
                $str .= $color('  ', $value);
            }
            $str .= PHP_EOL;
        }
        return $str;
    }

    public function width(): int
    {
        return count($this->grid[0]);
    }

    public function height(): int
    {
        return count($this->grid);
    }

    public function set(int $x, int $y, int $value): void
    {
        $this->grid[$y][$x] = $value;
    }

    public function get(int $x, int $y): int
    {
        return $this->grid[$y][$x];
    }

    public function values(): iterable
    {
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $value) {
                yield [$x, $y, $value];
            }
        }
    }

    public function adjacent(int $x, int $y): iterable
    {
        $delta = [[0, -1], [-1, 0], [0, 1], [1, 0]];
        foreach ($delta as [$dx, $dy]) {
            if ($y + $dy < 0 || $y + $dy >= count($this->grid)) {
                continue;
            }
            if ($x + $dx < 0 || $x + $dx >= count($this->grid[$y])) {
                continue;
            }
            yield $this->grid[$y + $dy][$x + $dx];
        }
    }
}

function input($handle): Grid
{
    $grid = [];
    while ($row = fgets($handle)) {
        $grid[] = str_split(trim($row));
    }
    return new Grid($grid);
}

function part1(Grid $grid): int
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

function part2(Grid $grid): int
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

    // echo $connected . PHP_EOL;

    return array_product(array_slice($labels, 1, 3));
}

$input = input(STDIN);
echo part1($input) . PHP_EOL;
echo part2($input) . PHP_EOL;
