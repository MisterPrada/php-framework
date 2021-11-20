<?php

namespace App\Controllers;

use App\Models\User;
use Core\Lib\Request;

class Main extends Controller
{
    public function home()
    {
        return view('pages/home');
    }

    public function user(Request $request)
    {
        require_once __APP__. 'Models/User.php';
        $user = new User();

        $name = 'Mister&Prada';
        $userName = $user->getById(1)->name;
        return view('user', ['name' => $name, 'userName' => $userName]);
    }

    public function index($id)
    {
        echo "test";
    }

    public function lang()
    {
        echo '<a href="https://framework/setlang/en" target="_blank">link</a>' . config('app.lang');
    }

    public function secret($id)
    {
        echo 'Успешно запущенный СЕКРЕТНЫЙ контроллер ' . $id;
    }

    public function catalog($name)
    {
        echo 'catalog + ' . $name;
    }

    public function observer()
    {

//        $user = User::update(['name' => 'God DyLad'], [
//            ['id', '=', '67']
//        ]);

        $users = User::create([
            [
                'name' => 'Test4',
                'email' => 'testtrhewwed@gmail.com',
                'password' => password_hash('456', PASSWORD_DEFAULT)
            ]
        ]);

//        $user = User::find(67);
//
//        var_dump($user); die();

//        $user->name = 'best Friend timo asd';
//        $user->save();

        var_dump('Main End');
        die();

        var_dump($user);
    }

    public function notFound(){
        http_response_code(404);
        echo 'NOT FOUND';
    }

    public function translateTest(){
        echo __('name', ['name' => "Jon", 'firstname' => 'Carter']);
    }
}