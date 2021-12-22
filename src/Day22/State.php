<?php

namespace Bake\AdventOfCode2021\Day22;

enum State: string
{
  case On = "on";
  case Off = "off";

  public function toggle(): self
  {
    return match ($this) {
      State::On => State::Off,
      State::Off => State::On,
    };
  }
}
