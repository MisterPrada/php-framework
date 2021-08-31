<?php


class Lang
{
    public static function setLang()
    {
        $languages = config('app.languages');

        $raw_locale = $_SESSION['Locale'];
        $cookie_locale = $_COOKIE['Locale'];


        if (in_array($raw_locale, $languages)) {
            $locale = $raw_locale; //Устанавливаем из Session
        } elseif (in_array($cookie_locale, $languages)) {
            $locale = $cookie_locale; # Устанавливаем из Cookie
        } else {
            $locale = config('app.lang'); # Ставим стандартный язык приложения
        }

        $segmentsURI = App::$route_parts; //делим на части по разделителю "/"

        // Изменить язык если в URL стоит префикс
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0], $languages)) {
            $_SESSION['Locale'] = $segmentsURI[0]; # И устанавливаем его в сессии под именем locale
            setcookie( "Locale", $segmentsURI[0], time()+(60*60*24*30), '/' );
            $locale = $segmentsURI[0];
        }

        config('app.lang', $locale); # Устанавливаем локаль приложения
    }


    public static function getLang()
    {
        $segmentsURI = App::$route_parts; //делим на части по разделителю "/"

        //Проверяем метку языка - есть ли она среди доступных языков
        if (!empty($segmentsURI[0]) && in_array($segmentsURI[0],  config('app.languages'))) {
            return $segmentsURI[0];
        } else {
            return config('app.lang');
        }
    }


}