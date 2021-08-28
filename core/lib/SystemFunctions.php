<?php

// Convenient use of configuration
function config($path)
{
    global $config;
    $out = null;
    $parts = explode('.', $path);

    foreach ($parts as $part) {
        if ($out == null && isset($config[$part])) {
            $out = $config[$part];
        } else {
            $out = $out[$part];
        }
    }

    return $out;
}

// get link by route name
function route($name, ...$args)
{
    foreach (Route::$routeList as $method_route => $obj) {
        if($obj->name == $name){
            $method_route = explode(':', $method_route);
            $route = $method_route[1];
            $parts = array_filter(explode('/', $route));


            foreach ($parts as $key => $part){
                if($part[0] == '{'){
                    $parts[$key] = array_shift($args);
                }
            }

            return '/' . implode('/', $parts);
        }
    }

    return '/';
}