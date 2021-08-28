<?php


class Main
{
    public function index($id)
    {
        echo route('cat', 20, 50);
        echo '<br>';
        echo 'Успешно запущенный контроллер ' . $id;
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