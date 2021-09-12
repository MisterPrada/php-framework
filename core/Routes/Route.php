<?php

namespace App\Core\Routes;

use Core\Lib\App;

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
    public $middleware = [];
    public $condition = [];
    static public $groupMiddleware = [];
    static public $prefix;
    static public $routeList = [];

    static public function get(string $route, array $controller): Route
    {
        return static::createRoute($route, $controller, 'GET');
    }

    static public function post(string $route, array $controller): Route
    {
        return static::createRoute($route, $controller, 'POST');
    }

    static public function createRoute(string $route, array $controller, $method)
    {
        $routeObj = new static();
        $routeObj->method = $method;
        $routeObj->middleware = static::$groupMiddleware;

        if (static::$prefix) {
            $routeObj->routeUri = static::$prefix . $route;
        } else {
            $routeObj->routeUri = $route;
        }

        $routeObj->controller = $controller;

        return self::$routeList[$routeObj->method . ':' . $routeObj->routeUri] = $routeObj;
    }

    static public function group(array $params, $groupFunction)
    {
        if(isset($params['middleware'])){
            static::$groupMiddleware = array_merge(static::$groupMiddleware, $params['middleware']);
        }

        if(isset($params['prefix'])){
            static::$prefix .= '/'.$params['prefix'];
        }

        $groupFunction(); //recursive group routs call

        if(isset($params['prefix'])){
            static::$prefix = str_replace('/'. $params['prefix'], "", static::$prefix);
        }

        if(isset($params['middleware'])){
            static::$groupMiddleware = array_diff(static::$groupMiddleware, $params['middleware']);
        }
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

    public function where(array $nameRegex){
        $this->condition = $nameRegex;

        return $this;
    }

    public function middleware(array $classes)
    {
        $this->middleware = array_merge($this->middleware, $classes);

        return $this;
    }

    static public function run()
    {
        foreach (static::$routeList as $method_route => $obj) {
            $method_route = explode(':', $method_route);
            $method = $method_route[0];
            $route = $method_route[1];

            if ($method == $_SERVER['REQUEST_METHOD']) {
                 $parts = array_values(array_filter(explode('/', $route)));

                // что количество частей совпадает с количеством чаетй роута или есть специфическое условие where
                if (count($parts) == count(App::$route_parts) || $obj->condition) {
                    $args = []; // Аргументы, которые передаются в контроллер
                    $break = null;

                    foreach ($parts as $key => $part) {
                        if ($part[0] == '{') {

                            foreach ($obj->condition as $nameCondition => $condition){
                                if($part == '{'. $nameCondition . '}'){
                                    $url = strstr(App::$route_url, App::$route_parts[$key]); // url после переменной включая её

                                    if(preg_match('/'. $condition .'/', $url, $matches)){
                                        $args[] = $url;
                                        continue;
                                    }

                                    $break = true;
                                    break;
                                }
                            }

                            $args[] = App::$route_parts[$key];
                        } elseif ($part !== App::$route_parts[$key]) {
                            $break = true;
                            break;
                        }
                    }

                    if ($break) continue;

                    // Run Middleware
                    foreach ($obj->middleware as $middleware) {
                        require_once __APP__ . '/Middleware/' . $middleware . '.php';
                        $middlewareClass = 'App\\Middleware\\' . str_replace("/", "\\", $middleware); // Название контроллера для Namespace
                        (new $middlewareClass())->handle();
                    }

                    // т.к. прошло соответствие маршруту, подключаем необходимый контроллер
                    require_once __APP__ . '/Controllers/' . $obj->controller[0] . '.php';

                    $controllerClass = 'App\\Controllers\\' . str_replace("/", "\\", $obj->controller[0]); // Название контроллера для Namespace
                    $controllerObject = new $controllerClass(); // Создание объекта контроллера


                    // Рефлектим параметры вызываемого метода для того чтобы передать объект запрашеваемого класса
                    $actionArgs = new \ReflectionMethod($controllerClass, $obj->controller[1]);
                    $param = end($actionArgs->getParameters());

                    if( $param && $param = $param->getClass() ){
                        $args[] = new $param->name;
                    }

                    echo $controllerObject->{$obj->controller[1]}(...$args);
                    die();
                }
            }
        }

        if(isset(App::$route_parts[0]) && App::$route_parts[0] != '404'){
            header('Location: /404'); // if not found controller redirect to 404 page
        }
    }

}