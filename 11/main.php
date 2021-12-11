<?php

class Grid
{
    public function __construct(private array $grid)
    {
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

    public function add(int $x, int $y, int $n): void
    {
        $this->grid[$y][$x] += $n;
    }

    public function get(int $x, int $y): int
    {
        return $this->grid[$y][$x];
    }

    public function each(): iterable
    {
        foreach ($this->grid as $y => $row) {
            foreach ($row as $x => $value) {
                yield [$x, $y, $value];
            }
        }
    }

    public function adjacent(int $x, int $y): iterable
    {
        for ($dy = -1; $dy <= 1; $dy++) {
            for ($dx = -1; $dx <= 1; $dx++) {
                if ($dy === 0 && $dx === 0) {
                    continue;
                }
                if ($y + $dy < 0 || $y + $dy >= $this->height()) {
                    continue;
                }
                if ($x + $dx < 0 || $x + $dx >= $this->width()) {
                    continue;
                }
                yield [$x + $dx, $y + $dy];
            }
        }
    }

    public function __toString()
    {
        $str = '';
        foreach ($this->grid as $row) {
            foreach ($row as $value) {
                [$light, $fg] = $value === 0 || $value >= 10 ? [0, 37] : [1, 30];
                $str .= sprintf("\e[%d;%dm%d\e[0m", $light, $fg, $value % 100);
            }
            $str .= PHP_EOL;
        }
        return $str;
    }
}

class OctopusGrid extends Grid
{
    private int $flashes;

    public function step(): void
    {
        foreach ($this->each() as [$x, $y]) {
            $this->add($x, $y, 1);
        }
        foreach ($this->each() as [$x, $y]) {
            if ($this->get($x, $y) > 9) {
                $this->flash($x, $y);
            }
        }
    }

    private function flash(int $x, int $y): self
    {
        $this->flashes ??= 0;
        $this->flashes++;
        $this->set($x, $y, 0);
        foreach ($this->adjacent($x, $y) as [$x, $y]) {
            $value = $this->get($x, $y);
            if ($value === 0) {
                continue;
            }
            $this->set($x, $y, $value + 1);
            if ($value + 1 > 9) {
                $this->flash($x, $y);
            }
        }
        return $this;
    }

    public function flashes(): int
    {
        return $this->flashes;
    }

    public function sum(): int
    {
        return array_sum(array_map(fn ($row) => $row[2], [...$this->each()]));
    }
}

function input($handle): OctopusGrid
{
    $grid = [];
    while ($row = fgets($handle)) {
        $grid[] = str_split(trim($row));
    }
    return new OctopusGrid($grid);
}

function part1(OctopusGrid $grid): int
{
    for ($i = 1; $i <= 100; $i++) {
        $grid->step($grid);
    }
    return $grid->flashes();
}

function part2(OctopusGrid $grid): int
{
    for ($i = 0; $grid->sum() !== 0; $i++) {
        $grid->step();
    }
    return $i;
}

$input = input(STDIN);
echo part1(clone $input) . PHP_EOL;
echo part2(clone $input) . PHP_EOL;
