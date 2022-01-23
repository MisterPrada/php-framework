<?php

namespace Core\Lib\FileSystem;

abstract class FileSystem
{
    public $contextDir;

    public function __construct() {}

    /**
     * Adapter (driver FileSystem)
     */
    abstract public function connector();

    /**
     * Get File
     */
    abstract public function getFile($fileName);

    /**
     * Put file in storage
     */
    abstract public function putFile($fileName, $fileContent);

    /**
     * Removing file
     */
    abstract public function removeFile($fileName);

    abstract public function disk($name);

    public function getContextDir()
    {
        return $this->contextDir ?? __ROOT__;
    }

    public function clearContextDir()
    {
        $this->contextDir = null;
    }

    public function clearContext()
    {
        $this->clearContextDir();
    }

}