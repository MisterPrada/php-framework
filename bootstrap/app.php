<?php

const __ROOT__ = '../';
const __APP__ = '../app/';
const __CORE__ = '../core/';

try {
    // Get main config
    $config = require_once '../config/app.php';

    // Libraries
    require_once __CORE__ . '/lib/SystemFunctions.php';

    // Connecting the required classes
    require_once __CORE__ . 'database/Connection.php';
    require_once __CORE__ . 'lib/App.php';
    require_once __CORE__ . '/routes/Route.php';

    // Declaring routes
    require_once __ROOT__ . 'routes/api.php';
    require_once __ROOT__ . 'routes/web.php';

    App::getInstance();
    Connection::make($config);
    Route::run();

} catch (Throwable $e) {
    if($config['app']['debug']){
        var_dump($e);
    }else{
        echo "Error";
    }
}


