<?php

namespace App\Controllers\Auth;
use Core\Lib\Request;
use App\Models\User;

class AuthController
{
    public function login(Request $request)
    {
        //$user = (new User())->findByEmail($request->get('email'));
        $users = (new User())->create([
            [
                'name' => 'Test1',
                'email' => 'testing@gmail.com',
                'password' => '123'
            ],
            [
                'name' => 'Test2',
                'email' => 'testtwo@gmail.com',
                'password' => '123'
            ]
        ]);

        var_dump($users);
    }
}