<?php

namespace App\Models;

use Core\Database\Db;
use PDO;

class Model
{
    public static $connection;

    protected $table;

    public $schema;
    public $collection;

    public function __construct() {}

    public function __set($name, $value)
    {
        if(!$this->schema) { $this->schema = (object)[]; }

        $camelCaseName = $this->underscoreToCamelCase($name);

        $this->schema->$camelCaseName = $value;
    }

    public function __get($key)
    {
        if($this->schema->{$key}){
            return $this->schema->{$key};
        }

        return null;
    }

    public static function setConnection()
    {
        self::$connection = Db::$connection[0]; // Set first config connections
    }

    public function all()
    {
        $query = " 
            SELECT * FROM {$this->table}
        ";

        return $this->raw($query);
    }

    public function raw($query)
    {
        $this->collection = self::$connection->query($query, PDO::FETCH_CLASS, static::class)->fetchAll();
        return $this;
    }

    public function first()
    {
        if($this->collection){
            return $this->collection[0];
        }

        return null;
    }

    public function find(int $id)
    {
        $query = "
            SELECT * FROM {$this->table}
            WHERE id = {$id}
            ";

        return $this->raw($query)->first();
    }

    public function where($col, $val)
    {
        $query = "
            SELECT * FROM {$this->table}
            WHERE {$col} = '{$val}'
            ";

        return $this->raw($query);
    }

    public function create(array $data)
    {
        $values = [];

        foreach ($data as $record){

            $values[] = '(' . implode(",", array_map('wrapInQuote' , array_values($record))) . ')';
        }

        $columns = implode(",", array_map('wrapInBackQuote', array_keys($data[0])));
        $values = implode(',', $values);

        $query = " 
            INSERT INTO {$this->table} ({$columns})
            VALUES {$values}
        ";

        return self::$connection->query($query)->rowCount();
    }

    public function get()
    {
        return $this->collection ?? [] ;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }
}

Model::setConnection();

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