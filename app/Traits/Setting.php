<?php
namespace App\Traits;

trait Setting
{
    # Poperties
    public static $appUrl = 'http://localhost/laravel/edds/';
    # Methods 
    public static function appUrl()
    {
        return self::$appUrl;
    }
}
