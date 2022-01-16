<?php

namespace Core\Lib;

/** Response constructor */
class Response
{
    public static function json(array $data, $code = 200)
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($code);
        return json_encode($data);
    }

    public static function errors(array $data, $code = 400)
    {
        return static::json($data, $code);
    }
}