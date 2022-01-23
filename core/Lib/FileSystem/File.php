<?php


namespace Core\Lib\FileSystem;


class File
{
    public $content;
    public $dirPath;
    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = realpath($filePath);
        $this->dirPath = dirname($this->filePath);
        $this->content = file_get_contents($filePath);
    }
}