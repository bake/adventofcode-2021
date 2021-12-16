<?php

namespace Bake\AdventOfCode2021\Day16;

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
