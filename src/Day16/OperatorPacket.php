<?php

namespace Bake\AdventOfCode2021\Day16;

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
