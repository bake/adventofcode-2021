<?php

enum PacketType: int
{
  case Sum = 0;
  case Product = 1;
  case Maximum = 3;
  case Minimum = 2;
  case Literal = 4;
  case GreaterThan = 5;
  case LessThan = 6;
  case EqualTo = 7;
}

interface Packet
{
  public function calculate(): int;
}

class LiteralPacket implements Packet
{
  public function __construct(
    public readonly int $version,
    public readonly PacketType $type,
    public readonly int $value,
  ) {
  }

  public function calculate(): int
  {
    return $this->value;
  }
}

class OperatorPacket implements Packet
{
  public function __construct(
    public readonly int $version,
    public readonly PacketType $type,
    public readonly array $packets,
  ) {
  }

  public function calculate(): int
  {
    $values = array_map(fn (Packet $p): int => $p->calculate(), $this->packets);
    return match ($this->type) {
      PacketType::Sum => array_sum($values),
      PacketType::Product => array_product($values),
      PacketType::Minimum => min($values),
      PacketType::Maximum => max($values),
      PacketType::GreaterThan => (int) $values[0] > $values[1],
      PacketType::LessThan => (int) $values[0] < $values[1],
      PacketType::EqualTo => (int) $values[0] === $values[1],
    };
  }
}

function input($handle): string
{
  $str = stream_get_contents($handle);
  $str = trim($str);
  $str = str_split($str);
  $str = array_map(fn (string $c): string => base_convert($c, 16, 2), $str);
  $str = array_map(fn (string $c): string => sprintf('%04d', $c), $str);
  $str = implode($str);
  return $str;
}

function read(string $input, int $length): array
{
  return [substr($input, 0, $length), substr($input, $length)];
}

function read_number(string $input, int $length): array
{
  [$number, $input] = read($input, $length);
  return [bindec($number), $input];
}

function parse(?string $input): mixed
{
  if ($input === null || strlen($input) === 0) {
    return [null, $input];
  }
  [$version, $input] = read_number($input, 3);
  [$type, $input] = read_number($input, 3);
  switch ($type) {
    case 4:
      $groups = [];
      do {
        [$end, $input] = read_number($input, 1);
        [$group, $input] = read($input, 4);
        $groups[] = $group;
      } while ($end !== 0);
      $value = bindec(implode($groups));
      return [
        new LiteralPacket($version, PacketType::from($type), $value),
        $input,
      ];

    default:
      [$length_type, $input] = read_number($input, 1);
      switch ($length_type) {
        case 0:
          [$length, $input] = read_number($input, 15);
          [$sub_input, $input] = read($input, $length);
          $packets = [];
          do {
            [$sub_packet, $sub_input] = parse($sub_input);
            $packets[] = $sub_packet;
          } while ($sub_packet !== null);
          $packets = array_filter($packets);
          return [
            new OperatorPacket($version, PacketType::from($type), $packets),
            $input,
          ];
        case 1:
          [$num_packets, $input] = read_number($input, 11);
          $packets = [];
          for ($i = 0; $i < $num_packets; $i++) {
            [$sub_packet, $input] = parse($input);
            $packets[] = $sub_packet;
          }
          $packets = array_filter($packets);
          return [
            new OperatorPacket($version, PacketType::from($type), $packets),
            $input,
          ];
      }
  }
}

function sum_version(Packet $packet): int
{
  $sum = $packet->version;
  foreach ($packet->packets ?? [] as $packet) {
    $sum += sum_version($packet);
  }
  return $sum;
}

function part1(string $input): int
{
  [$packet] = parse($input);
  return sum_version($packet);
}

function part2(string $input): int
{
  [$packet] = parse($input);
  return $packet->calculate();
}

$input = input(STDIN);
echo part1($input) . PHP_EOL;
echo part2($input) . PHP_EOL;
