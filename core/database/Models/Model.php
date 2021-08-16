<?php


class Model
{
    public static $connection;

    protected $table;

    public function __construct()
    {
        $this::$connection = Connection::$instance;
    }

    public function all()
    {
        return self::$connection->query("SELECT * FROM {$this->table}")->fetchAll();
    }
}