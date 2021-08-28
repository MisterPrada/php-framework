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
    public $method;
    static public $routeList = [];

    static public function get(string $route, array $controller): Route
    {
        $routeObj = new static();
        $routeObj->method = 'GET';
        $routeObj->routeUri = $route;
        $routeObj->controller = $controller;

        return self::$routeList[$routeObj->method . ':' . $route] = $routeObj;
    }

    static public function post(string $route, array $controller): Route
    {
        $routeObj = new static();
        $routeObj->method = 'POST';
        $routeObj->routeUri = $route;
        $routeObj->controller = $controller;

        return self::$routeList[$routeObj->method . ':' . $route] = $routeObj;
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

    static public function run()
    {
        foreach (static::$routeList as $method_route => $obj) {
            $method_route = explode(':', $method_route);
            $method = $method_route[0];
            $route = $method_route[1];

            if ($method == $_SERVER['REQUEST_METHOD']) {
                $parts = array_filter(explode('/', $route));

                if (count($parts) == count(App::$route_parts)) {
                    $args = []; // Аргументы, которые передаются в контроллер
                    $break = null;

                    foreach ($parts as $key => $part){
                        if($part[0] == '{'){
                            $args[] = App::$route_parts[$key];
                        }elseif ($part !== App::$route_parts[$key]) {
                            $break = true;
                            break;
                        }
                    }

                    if($break) continue;

                    // т.к. прошло соответствие маршруту, подключаем необходимый контроллер
                    require_once __APP__ . '/Controllers/' . $obj->controller[0] . '.php';
                    $controller = new $obj->controller[0];
                    $controller->{$obj->controller[1]}(...$args);
                    die();
                }
            }
        }
    }

}