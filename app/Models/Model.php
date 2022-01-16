<?php

namespace App\Models;

use Core\Database\Db;
use Core\Lib\Observer;
use PDO;

/** Model for a single table in a database */
class Model
{
    use Observer;

    public $scheme;
    public $collection;
    private static $observerClasses = []; // All observer classes for the current model

    public function __construct()
    {
        // Attach all observers for the current model
        foreach ($this::$observerClasses as $observerClass) {
            $this->attach(new $observerClass());
        }
    }

    public function __set($name, $value)
    {
        if (!$this->scheme) {
            $this->scheme = (object)[];
        }

        $this->scheme->$name = $value;
    }

    public function __get($key)
    {
        if ($this->scheme->{$key}) {
            return $this->scheme->{$key};
        }

        return null;
    }

    /** Custom raw sql query string */
    public function raw($query)
    {
        $this->collection = Db::$connection->query($query, PDO::FETCH_CLASS, static::class)->fetchAll();
        return $this;
    }

    public function get()
    {
        return $this->collection ?? [];
    }

    /** Get the first row from the collection */
    public function first()
    {
        if ($this->collection) {
            return $this->collection[0];
        }

        return null;
    }

    /** Save active record */
    public function save()
    {
        if ($this->id) {
            $scheme = (array)$this->scheme;
            unset($scheme['created_at'], $scheme['updated_at']);

            static::update($scheme, [['id', '=', $this->id]]);
        }

        return false;
    }

    /** Remove active record */
    public function remove()
    {
        if ($this->id) {
            static::delete([['id', '=', $this->id]]);
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

    /** Get all rows from model */
    public static function all()
    {
        $query = " 
            SELECT * FROM " . static::table . "
        ";

        return (new static)->raw($query);
    }

    /** Find by id row form model */
    public static function find(int $id)
    {
        $query = "
            SELECT * FROM " . static::table . "
            WHERE id = {$id}
            ";

        return (new static)->raw($query)->first();
    }

    /** Condition on active record */
    public static function where(array $condition)
    {
        $where = static::conditionToString($condition);

        $query = "
            SELECT * FROM " . static::table . "
            WHERE {$where}
            ";

        return (new static)->raw($query);
    }

    /** Create record in database */
    public static function create(array $data)
    {
        $values = [];

        foreach ($data as $record) {
            $values[] = '(' . implode(",", array_map('wrapInQuote', array_values($record))) . ')';
        }

        $columns = implode(",", array_map('wrapInBackQuote', array_keys($data[0])));
        $values = implode(',', $values);

        $table = static::table;

        $query = " 
            INSERT INTO {$table} ({$columns})
            VALUES {$values}
        ";

        $rowCount = Db::$connection->query($query)->rowCount();

        if ($rowCount > 0) {
            (new static)->notify('create', $data); // emit observer event
        }

        return $rowCount;
    }

    /** Update records with conditions */
    public static function update(array $data, array $condition)
    {
        $set = static::dataToString($data);
        $where = static::conditionToString($condition);

        $query = "
            UPDATE " . static::table . "
            SET {$set}
            WHERE {$where}
        ";

        $rowCount = Db::$connection->query($query)->rowCount();

        if ($rowCount > 0) {
            (new static)->notify('update', $data); // emit observer event
        }

        return $rowCount;
    }

    /** Delete records with conditions */
    public static function delete(array $condition)
    {
        $where = static::conditionToString($condition);

        $query = "
            DELETE FROM " . static::table . "
            WHERE {$where}
        ";

        $rowCount = Db::$connection->query($query)->rowCount();

        if ($rowCount > 0) {
            (new static)->notify('delete', $condition); // emit observer event
        }

        return $rowCount;
    }


    /** methods without logic **/

    /** Turns a condition into a sql string */
    private static function conditionToString($condition)
    {
        $where = [];

        foreach ($condition as $item) {

            $operator = ' AND ';
            $item[2] = addslashes($item[2]); //

            switch (count($item)) {
                case 2:
                    $where[] = wrapInBackQuote($item[0]) . " = " . wrapInQuote($item[1]);
                    break;
                case 3:
                    if (is_array($item[2])) {
                        $item[2] = "(" . implode(',', array_map(function ($item) {
                                return "'{$item}'";
                            }, $item[2])) . ")";

                        $where[] = wrapInBackQuote($item[0]) . " {$item[1]} " . $item[2];
                        break;
                    }

                    $where[] = wrapInBackQuote($item[0]) . " {$item[1]} " . wrapInQuote($item[2]);
                    break;
                case 4:
                    $operator = " {$item[3]} ";

                    if (is_array($item[2])) {
                        $item[2] = "(" . implode(',', array_map(function ($item) {
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

    /** Turns a data into a sql string */
    private static function dataToString($data)
    {
        foreach ($data as $name => $value) {
            $set[] = wrapInBackQuote($name) . ' = ' . wrapInQuote($value);
        }

        return implode(',', $set);
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