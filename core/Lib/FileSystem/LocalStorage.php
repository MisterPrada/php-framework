<?php

namespace Core\Lib\FileSystem;


class LocalStorage extends FileSystem
{
    public function connector() { }

    public function disk($name)
    {
        $this->contextDir = __STORAGE__ . $name . '/';
        return $this;
    }

    public function getFile($fileName)
    {
        return new File( $this->getContextDir() . $fileName );
    }

    public function putFile($fileName, $fileContent)
    {
        $fileFullName = $this->getContextDir() . $fileName;

        if ( !is_dir($dir = dirname($fileFullName)) ) {
            mkdir($dir, 0664, true);
        }

        file_put_contents($fileFullName, $fileContent);
    }

    public function removeFile($fileName)
    {
        @unlink($this->getContextDir() . $fileName);
    }
}
