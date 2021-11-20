<?php

namespace App\Controllers\Auth;

require_once __APP__ . '/Requests/AuthRequest.php';

use App\Models\Role;
use App\Requests\AuthRequest;
use Core\Lib\Auth;
use Core\Lib\Request;
use App\Models\User;

class AuthController
{
    public function login(Request $request)
    {

        var_dump($request->email);

//$users = (new User())->all()->get();
        //$up = User::update([ 'name' => 'Glad' ],[ ['password', '=' , '11'] ]);

//        $users = User::create([
//            [
//                'name' => 'Test3',
//                'email' => 'testtrheww@gmail.com',
//                'password' => '222'
//            ]
//        ]);

//        $users = User::create([
//            [
//                'name' => 'Test4',
//                'email' => 'testtrhewwed@gmail.com',
//                'password' => password_hash('456', PASSWORD_DEFAULT)
//            ]
//        ]);

        //var_dump(addslashes('lesha.skorpion@gmail.com\'select * from users'));
        //die();

        //$login = Auth::login('lesha.skorpion@gmail.com\'select * from users', '123');

        //$login = Auth::login('lesha.skorpion@gmail.com', '123');
        //var_dump(uniqid());
        //var_dump();

        //var_dump( $_SERVER['PHP_AUTH_USER'] );
        //var_dump( $_SERVER['PHP_AUTH_PW'] );

        //Auth::login($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);


        //var_dump(Auth::$user);

        //credential

        //$users = User::all();
        //$users = User::find(67);

        //var_dump($users);

        var_dump('Дошло до самого конца');
    }
}