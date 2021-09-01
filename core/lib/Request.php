<?php


class Request
{
    private static $instances = [];
    public $headers;
    public $body = [];
    public $content = null;
    public $files;

    protected function __construct()
    {
        $this->headers = getallheaders();
        $this->files = $_FILES;
        $request = $_REQUEST;
        array_shift($request);
        $this->body = $request;

        $this->content = file_get_contents('php://input');

        $this->body = array_merge($this->body, (array)json_decode($this->content));
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Request
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
    }

    public function all()
    {
        return $this->body;
    }

    public function get($field)
    {
        return $this->body[$field];
    }

    public function has($field)
    {
        return isset($this->body[$field]);
    }

    public function hasHeader($header)
    {
        return isset($this->headers[$header]);
    }

    public function hasFile($name)
    {
        return isset($this->files[$name]);
    }
}

App::getInstance();
