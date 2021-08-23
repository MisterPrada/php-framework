<?php

/**
 * Class Route
 * Общий класс служит для регистрации роутов в системе
 */
class Route
{
    public $name;
    public $controller = [];
    public $routeUri;
    static public $routeList = [];

    static public function get(string $route, array $controller): Route
    {
        $routeObj = new static();
        $routeObj->routeUri = $route;
        $routeObj->controller = $controller;

        return self::$routeList[$route] = $routeObj;
    }

    /**
     * @param string $routeName
     * @return Route
     * Устанавливаем имя роуту для последующего обращения к нему
     */
    public function name(string $routeName): Route
    {
        $this->name = $routeName;

        return $this;
    }
}