<?php

namespace App\Controllers;

use Core\Lib\Lang;

class LanguageController extends Controller
{
    public function setLang($language){
        $languages = config('app.languages');

        if (in_array($language, $languages)) {   # Проверяем, что у пользователя выбран доступный язык
            $referer = $_SERVER['HTTP_REFERER'];; //URL предыдущей страницы
            $parse_url = parse_url($referer, PHP_URL_PATH); //URI предыдущей страницы

            //разбиваем на массив по разделителю
            $segments = explode('/', $parse_url);

            //Если URL (где нажали на переключение языка) содержал корректную метку языка
            if (in_array($segments[1], $languages)) {
                unset($segments[1]); //удаляем метку
            }

            //Добавляем метку языка в URL (если выбран не язык по-умолчанию)
            array_splice($segments, 1, 0, $language);

            //формируем полный URL
            $url = implode("/", $segments);

            //если были еще GET-параметры - добавляем их
            if(parse_url($referer, PHP_URL_QUERY)){
                $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
            }

            $_SESSION['Lang'] = $language; # И устанавливаем его в сессии под именем locale
            setcookie( "Locale", $language, time()+(60*60*24*30), '/' );
            header("Location: $url");
        }
        else{
            header("Location: /");
        }
    }

    public function setHomeLang()
    {
        header("Location: /" . Lang::getLang());
        exit;
    }
}