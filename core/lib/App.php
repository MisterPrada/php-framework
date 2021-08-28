<?php


class App
{
    public static $route_url;
    public static $route_parts;
    private static $instances = [];

    protected function __construct() {
        static::$route_url = explode("?", $_SERVER['REQUEST_URI'])[0];
        static::$route_parts = array_filter(explode('/', static::$route_url));
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): App
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }
}
