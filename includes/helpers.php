<?php

/**
 * Formatting dump results
 *
 * @param mixed $data
 */
if (!function_exists('dump')) {
  function dump($data): void
  {
    if (is_array($data)) {
      array_walk_recursive($data, 'htmlspecialchars');
    } else {
      $data = htmlspecialchars($data);
    }

    echo '<pre>', var_dump($data), '</pre>';
  }
}

/**
 * Dump & die
 *
 * @param mixed $data
 */
if (!function_exists('dd')) {
  function dd($data): void
  {
    dump($data);
    die;
  }
}
