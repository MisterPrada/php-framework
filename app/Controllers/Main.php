<?php


class Main extends Controller
{
    public function home()
    {
        echo config('app.lang');
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

    public function catalog($category, $item)
    {
        echo 'Категория: ' . $category;
        echo '<br>';
        echo 'Итем: ' . $item;
    }
}