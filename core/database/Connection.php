<?php

class Connection
{
    public static $instance;

    public static function make($config, $section = 'database')
    {
        return self::$instance = new PDO(
            $config[$section]['db_type'] . ':host=' . $config[$section]['connection'] . ';dbname=' . $config[$section]['name'],
            $config[$section]['username'],
            $config[$section]['password'],
            $config[$section]['options']
        );
    }

}