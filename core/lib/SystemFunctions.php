<?php

// Convenient use of configuration
function config($path) {
    global $config;
    $out = null;
    $parts = explode('.', $path);

    foreach ($parts as $part){
        if($out == null && isset($config[$part])){
            $out = $config[$part];
        }else{
            $out = $out[$part];
        }
    }

    return $out;
}