<?php

class Connection
{
    /**
     * Create a new PDO connection.
     *
     * @param array $config
     * @param string $section
     */
    public static function make($config, $section = 'database')
    {
        try {
            return new PDO(
                $config[$section]['db_type'] . ':host=' . $config[$section]['connection'] . ';dbname=' . $config[$section]['name'],
                $config[$section]['username'],
                $config[$section]['password'],
                $config[$section]['options']
            );
        } catch (PDOException $e) {
            if($config['app']['debug']){
                die($e->getMessage());
            }

            die('Error');
        }
    }
}