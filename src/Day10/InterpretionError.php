<?php

namespace Bake\AdventOfCode2021\Day10;

enum InterpretionError: string
{
  case UNECPECTED_BRACE = 'Unexpected brace';
  case UNEXPECTED_EOF = 'Unexpected EOF';
}
