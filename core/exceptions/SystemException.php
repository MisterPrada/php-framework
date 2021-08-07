<?php

if(!$config['app']['debug']){
    set_error_handler(function(int $number, string $message) {
        echo 'Error';
        die();
    });
}

