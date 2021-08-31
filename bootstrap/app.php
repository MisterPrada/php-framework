<?php

session_start();
const __ROOT__ = '../';
const __APP__ = '../app/';
const __CORE__ = '../core/';

try {
    // Get main config
    $config = require_once '../config/config.php';

    // Libraries
    require_once __CORE__ . '/lib/SystemFunctions.php';

    // Connecting the required classes
    require_once __CORE__ . 'database/Connection.php';
    require_once __CORE__ . 'lib/App.php';
    require_once __CORE__ . 'lib/Request.php';
    require_once __CORE__ . '/routes/Route.php';
    require_once __APP__ . '/Controllers/Controller.php';

    // Declaring routes
    require_once __ROOT__ . 'routes/api.php';
    require_once __ROOT__ . 'routes/web.php';

    Route::run();

} catch (Throwable $e) {
    if($config['app']['debug']){
        var_dump($e);
    }else{
        echo "Error";
    }
}


