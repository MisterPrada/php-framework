<?php

namespace Core\Database;

use PDO;

class Db
{
    public static $connection;

    public static function make($config, $section = 'database')
    {
        return self::$connection = new PDO(
            $config[$section]['db_type'] . ':host=' . $config[$section]['connection'] . ';dbname=' . $config[$section]['name'],
            $config[$section]['username'],
            $config[$section]['password'],
            $config[$section]['options']
        );
    }

}

Db::make($config);
