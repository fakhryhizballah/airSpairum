<?php

namespace App\Libraries;

class SetStatic
{

    private static $arr_cookie_options = null;

    public static function cookie_options()
    {
        if (self::$arr_cookie_options == null) {
            self::$arr_cookie_options = array(
                'expires' => time() + 60 * 60 * 24 * 360,
                'path' => '/',
                'domain' => "", // leading dot for compatibility or use subdomain
                'secure' => true,     // or false
                'httponly' => false,    // or false
                'samesite' => 'None' // None || Lax  || Strict

            );
        }
        return self::$arr_cookie_options;
    }
}
