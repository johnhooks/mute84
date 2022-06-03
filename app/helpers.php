<?php

if (!function_exists('storage_url')) {
  /**
   * Determine if the given post can be deleted by the user.
   *
   * @param  string  $file_path - The storage file path
   * @return string
   */
  function storage_url(string $file_path)
  {
    return url('/storage/' . $file_path);
  }
}
