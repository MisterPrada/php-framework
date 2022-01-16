<?php

namespace Core\Lib\FileSystem;


class LocalStorage extends FileSystem
{
    public function connector() { }

    public function get($fileName)
    {
        return file_get_contents( $this->getContextDir() . $fileName );
    }

    public function disk($name)
    {
        $this->contextDir = __STORAGE__ . $name;
        return $this;
    }
}