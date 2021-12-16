<?php

function string_to_stream(string $input)
{
  $handle = fopen('php://memory', 'r+');
  fwrite($handle, $input);
  rewind($handle);
  return $handle;
}
