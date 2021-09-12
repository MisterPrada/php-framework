<?php

namespace Core\Lib;

require_once __APP__ . '/Models/User.php';


class Auth
{
    public static $user;
    private static $instances = [];

    protected function __construct() {

    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Auth
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
}

Auth::getInstance();
