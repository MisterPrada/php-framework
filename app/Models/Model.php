<?php

namespace App\Models;

use Core\Database\Db;
use PDO;

class Model
{
    public $scheme;
    public $collection;

    public function __construct() {}

    public function __set($name, $value)
    {
        if(!$this->scheme) { $this->scheme = (object)[]; }

        $this->scheme->$name = $value;
    }

    public function __get($key)
    {
        if($this->scheme->{$key}){
            return $this->scheme->{$key};
        }

        return null;
    }

    public function raw($query)
    {
        $this->collection = Db::$connection->query($query, PDO::FETCH_CLASS, static::class)->fetchAll();
        return $this;
    }

    public function get()
    {
        return $this->collection ?? [] ;
    }

    public function first()
    {
        if($this->collection){
            return $this->collection[0];
        }

        return null;
    }

    public function save()
    {
        if($this->id){
            $scheme = (array)$this->scheme;
            unset( $scheme['created_at'], $scheme['updated_at'] );

            static::update($scheme, [['id', '=', $this->id]]);
        }

        return false;
    }


    /** Relations */

    public function belongsTo($class, $foreign_key, $local_key)
    {
        $relation_table = $class::table;
        $table = static::table;
        $currentId = $this->id;

        $query = "
            SELECT `{$relation_table}`.* FROM `{$table}`
            LEFT JOIN `{$relation_table}` ON `{$table}`.`{$local_key}` = `{$relation_table}`.`{$foreign_key}`
            WHERE `{$table}`.`id` = '{$currentId}'
            ";

        return (new $class)->raw($query)->first();
    }

    public function hasMany($class, $foreign_key, $local_key)
    {
        $relation_table = $class::table;
        $table = static::table;
        $currentId = $this->id;

        $query = "
            SELECT `{$relation_table}`.* FROM `{$table}`
            LEFT JOIN `{$relation_table}` ON `{$table}`.`{$local_key}` = `{$relation_table}`.`{$foreign_key}`
            WHERE `{$table}`.`id` = '{$currentId}'
            ";

        return (new $class)->raw($query)->get();
    }


    /** Static methods **/

    public static function all()
    {
        $query = " 
            SELECT * FROM ". static::table ."
        ";

        return (new static)->raw($query);
    }

    public static function find(int $id)
    {
        $query = "
            SELECT * FROM ". static::table ."
            WHERE id = {$id}
            ";

        return (new static)->raw($query)->first();
    }

    public static function where(array $condition)
    {
        $where = static::conditionToString($condition);

        $query = "
            SELECT * FROM ". static::table ."
            WHERE {$where}
            ";

        return (new static)->raw($query);
    }

    public static function create(array $data)
    {
        $values = [];

        foreach ($data as $record){
            $values[] = '(' . implode(",", array_map('wrapInQuote' , array_values($record))) . ')';
        }

        $columns = implode(",", array_map('wrapInBackQuote', array_keys($data[0])));
        $values = implode(',', $values);

        $table = static::table;

        $query = " 
            INSERT INTO {$table} ({$columns})
            VALUES {$values}
        ";

        return Db::$connection->query($query)->rowCount();
    }

    public static function update(array $data, array $condition)
    {
        $set = static::dataToString($data);
        $where = static::conditionToString($condition);

        $query = "
            UPDATE ". static::table ."
            SET {$set}
            WHERE {$where}
        ";

        return Db::$connection->query($query)->rowCount();
    }

    public static function delete(array $condition)
    {
        $where = static::conditionToString($condition);

        $query = "
            DELETE FROM ". static::table ."
            WHERE {$where}
        ";

        return Db::$connection->query($query)->rowCount();
    }


    /** methods without logic **/

    private static function conditionToString($condition){
        $where = [];

        foreach ($condition as $item) {

            $operator = ' AND ';
            $item[2] = addslashes($item[2]); //

            switch (count($item)){
                case 2:
                    $where[] = wrapInBackQuote($item[0]) . " = " . wrapInQuote($item[1]);
                    break;
                case 3:
                    if(is_array($item[2])){
                        $item[2] = "(" . implode(',', array_map(function($item) {
                            return "'{$item}'";
                        }, $item[2])) . ")";

                        $where[] = wrapInBackQuote($item[0]) . " {$item[1]} " . $item[2];
                        break;
                    }

                    $where[] = wrapInBackQuote($item[0]) . " {$item[1]} " . wrapInQuote($item[2]);
                    break;
                case 4:
                    $operator = " {$item[3]} ";

                    if(is_array($item[2])){
                        $item[2] = "(" . implode(',', array_map(function($item) {
                                return "'{$item}'";
                            }, $item[2])) . ")";

                        $where[] = wrapInBackQuote($item[0]) . " {$item[1]} " . $item[2];
                        break;
                    }

                    $where[] = wrapInBackQuote($item[0]) . " {$item[1]} " . wrapInQuote($item[2]);
                    break;
            }

            $where = [implode($operator, $where)];

        }

        return $where[0];
    }

    private static function dataToString($data)
    {
        foreach ($data as $name => $value){
            $set[] = wrapInBackQuote($name) . ' = ' . wrapInQuote($value);
        }

        return implode(',' , $set);
    }

}


/* Примеры

---Insert On Duplicate Key (Поле по котоому должно быть on duplicate key должно быть UNIQUE)---
INSERT INTO users (`name`, `email`)
VALUES ('Sashka','test@gmail.com'),('Vlad','vlad@gmail.com')
ON DUPLICATE KEY UPDATE `email` = VALUES(`email`)

---Добавить запись---
INSERT INTO users (`name`, `email`)
VALUES ('Sashka','test@gmail.com'),('Vlad','vlad@gmail.com')

---Обновить запись---
UPDATE users
SET `email` = 'sashka@gmail.com'
WHERE `name` = 'Sashka'

 */