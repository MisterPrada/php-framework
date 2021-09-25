<?php

namespace Core\Lib;

use App\Models\User;

require_once __APP__ . '/Models/User.php';
require_once __APP__ . '/Models/Role.php';


class Auth
{
    public static $user; // current user
    public static $authorize = false; // is auth
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

        if($_SESSION['auth'])
        {
            static::$authorize = true;
            static::$user = User::find($_SESSION['auth']);
        }

        return self::$instances[$cls];
    }

    /**
     * Authenticate user
     */
    public static function login($email, $password)
    {
        if($user = User::where([ ['email', '=', $email] ])->first() )
        {
            if(password_verify($password, $user->password))
            {
                $_SESSION['auth'] = $user->id;
                static::$user = $user;
                static::$authorize = true;
                return true;
            }
        }

        return false;
    }

    public static function logout()
    {
        static::$user = null;
        static::$authorize = false;
        unset($_SESSION['auth']);
    }


    /** basic authenticate user */
    public static function basicAuth()
    {
        if( isset($_SERVER['PHP_AUTH_USER']) ){
            static::login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
        }
    }

}

Auth::getInstance();
