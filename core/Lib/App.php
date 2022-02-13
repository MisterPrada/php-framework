<?php

namespace Core\Lib;

require_once __CORE__ . '/lib/Lang.php';

/** Main App class | Pattern singleton */
class App
{
    public static $base_url; // Route URL host
    public static $route_url; // Route URL without host
    public static $route_parts; // Route Parts delimiter '/'
    public static $view_varibles = []; // Temp variables
    private static $instances = [];

    protected function __construct() {
        static::$base_url = baseUrl();
        static::$route_url = explode("?", $_SERVER['REQUEST_URI'] ?? '/')[0];
        static::$route_parts = array_values(array_filter(explode('/', static::$route_url)));
        static::csrfToken();
        Lang::setLang();
        Lang::$translate[config('app.lang')]['default'] = require_once __RESOURCES__ . 'lang/' . config('app.lang') . '.php' ;
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

    /** set CSRF token */
    public static function csrfToken()
    {
        if(!isset($_SESSION['csrf_token'])){
            $_SESSION['csrf_token'] = bin2hex(random_bytes(35));
        }
    }
}

App::getInstance();
