<?php


class Main
{
    public function index($id)
    {
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