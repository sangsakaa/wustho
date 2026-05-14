<?php

namespace App\Helpers;


class AppVersion
{
  public static function get()
  {
    return trim(shell_exec('git describe --tags --always')) ?? 'dev';
  }
}