<?php

namespace Bake\AdventOfCode2021\Day16;

class Day16
{
  public static function input($handle): string
  {
    $str = stream_get_contents($handle);
    return self::hexbin($str);
  }

  public static function hexbin(string $str): string
  {
    $str = trim($str);
    $str = str_split($str);
    $str = array_map(fn (string $c): string => base_convert($c, 16, 2), $str);
    $str = array_map(fn (string $c): string => sprintf('%04d', $c), $str);
    $str = implode($str);
    return $str;
  }

  public static function read(string $input, int $length): array
  {
    return [substr($input, 0, $length), substr($input, $length)];
  }

  public static function read_number(string $input, int $length): array
  {
    [$number, $input] = self::read($input, $length);
    return [bindec($number), $input];
  }

  public static function parse(?string $input): mixed
  {
    if ($input === null || strlen($input) === 0) {
      return [null, $input];
    }
    [$version, $input] = self::read_number($input, 3);
    [$type, $input] = self::read_number($input, 3);
    switch ($type) {
      case 4:
        $groups = [];
        do {
          [$end, $input] = self::read_number($input, 1);
          [$group, $input] = self::read($input, 4);
          $groups[] = $group;
        } while ($end !== 0);
        $value = bindec(implode($groups));
        return [
          new LiteralPacket($version, PacketType::from($type), $value),
          $input,
        ];

      default:
        [$length_type, $input] = self::read_number($input, 1);
        switch ($length_type) {
          case 0:
            [$length, $input] = self::read_number($input, 15);
            [$sub_input, $input] = self::read($input, $length);
            $packets = [];
            do {
              [$sub_packet, $sub_input] = self::parse($sub_input);
              $packets[] = $sub_packet;
            } while ($sub_packet !== null);
            $packets = array_filter($packets);
            return [
              new OperatorPacket($version, PacketType::from($type), $packets),
              $input,
            ];
          case 1:
            [$num_packets, $input] = self::read_number($input, 11);
            $packets = [];
            for ($i = 0; $i < $num_packets; $i++) {
              [$sub_packet, $input] = self::parse($input);
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

  public static function sum_version(Packet $packet): int
  {
    $sum = $packet->version;
    foreach ($packet->packets ?? [] as $packet) {
      $sum += self::sum_version($packet);
    }
    return $sum;
  }

  public static function part1(string $input): int
  {
    [$packet] = self::parse($input);
    return self::sum_version($packet);
  }

  public static function part2(string $input): int
  {
    [$packet] = self::parse($input);
    return $packet->calculate();
  }
}
