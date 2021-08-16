<?php

class Connection
{
    public static $instance;

    public static function make($config, $section = 'database')
    {
        try {
            return self::$instance = new PDO(
                $config[$section]['db_type'] . ':host=' . $config[$section]['connection'] . ';dbname=' . $config[$section]['name'],
                $config[$section]['username'],
                $config[$section]['password'],
                $config[$section]['options']
            );
        } catch (PDOException $e) {
            if ($config['app']['debug']) {
                die($e->getMessage());
            }

            die('Error Database Connection');
        }
    }

}