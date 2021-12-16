<?php

namespace Bake\AdventOfCode2021\Day16;

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
