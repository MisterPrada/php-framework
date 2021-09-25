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

    public function notFound(){
        http_response_code(404);
        echo 'NOT FOUND';
    }
}