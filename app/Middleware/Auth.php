<?php

namespace App\Middleware;

class Auth
{
    public function handle()
    {
        echo 'Закрыт доступ';
        die();
    }
}