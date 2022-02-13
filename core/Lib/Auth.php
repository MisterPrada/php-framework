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

        if(isset($_SESSION['auth']))
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

    /**
     * Authenticate braerer token user
     */
    public static function loginBraerer()
    {
        $token = static::getBearerToken();

        if($token && $user = User::where([ ['token', '=', $token] ])->first() )
        {
            static::$user = $user;
            static::$authorize = true;
            return true;
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
            if(static::login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])){
                Auth::$user->token = createApiToken();
                Auth::$user->save();
                return Auth::$user->token;
            }
        }

        return false;
    }

    /**
     * Get header Authorization
     * */
    public static function getAuthorizationHeader(){
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        }
        else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    /**
     * get access token from header
     * */
    public static function getBearerToken() {
        $headers = static::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

}

Auth::getInstance();
