<?php

if (!function_exists('storage_url')) {
  /**
   * Return the file storage url of the file path
   *
   * @param  string $file_path - The storage file path
   * @return string The file url
   */
  function storage_url(string $file_path)
  {
    return url('/storage/' . $file_path);
  }
}
