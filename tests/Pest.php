<?php

/**
 * Tests are located alongside each days solution.
 */

function string_to_stream(string $input)
{
  $handle = fopen('php://memory', 'r+');
  fwrite($handle, $input);
  rewind($handle);
  return $handle;
}
