<?php 
namespace App\Helpers;

class AppVersion
{
public static function get()
{
$version = trim(shell_exec('git describe --tags --abbrev=0 2>/dev/null'));

return $version ?: 'dev';
}
}