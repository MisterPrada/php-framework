<?php


class Main extends Controller
{
    public function home()
    {
        return view('pages/home');
    }

    public function user($id, Request $request)
    {
        $name = 'Mister&Prada';

        echo route('user', 20) . '<br>';

        return view('user', ['name' => $name]);
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
        echo 'NOT FOUND';
    }
}