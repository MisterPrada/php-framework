<?php

namespace App\Middleware;

use Core\Lib\Auth;
use Core\Lib\Response;

class AuthApi
{
    public function handle()
    {
        if(!Auth::loginBraerer()){
            echo Response::json(['error' => 'Auth']);
            die;
        }
    }
}