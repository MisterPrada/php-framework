<?php

namespace Core\Lib\FileSystem;


require_once __CORE__ . '/Lib/FileSystem/FileSystem.php';
require_once __CORE__ . '/Lib/FileSystem/LocalStorage.php';

class Storage
{
    private static $instances = [];

    public static $defaultFileSystem = 'local';
    public static $fileSystems = [];

    public function __construct()
    {
        self::$fileSystems[self::$defaultFileSystem] = new LocalStorage();
    }

    public static function __callStatic($method, $args)
    {
        $fileSystem = self::$fileSystems[self::$defaultFileSystem];
        $fileSystem->clearContext();
        return $fileSystem->{$method}(...$args);
    }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Storage
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

}

Storage::getInstance();