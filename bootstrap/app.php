<?php

session_start();
const __ROOT__ = '../';
const __APP__ = '../app/';
const __CORE__ = '../core/';
const __RESOURCES__ = '../resources/';
const __VIEWS__ = '../resources/views/';

try {
    // Get main config
    $config = require_once '../config/config.php';

    // Libraries
    require_once __CORE__ . 'Lib/SystemFunctions.php';

    // Connecting the required classes
    require_once __CORE__ . 'Database/Db.php';
    require_once __CORE__ . 'Lib/App.php';
    require_once __CORE__ . 'Lib/Request.php';
    require_once __CORE__ . 'Lib/Response.php';
    require_once __CORE__ . 'Routes/Route.php';

    require_once __APP__ . 'Models/Model.php';
    require_once __APP__ . 'Controllers/Controller.php';
    require_once __APP__ . 'Controllers/Api/ApiController.php';

    require_once __APP__ . 'Kernel.php';
    require_once __CORE__ . 'Lib/Auth.php';

    // Declaring routes
    require_once __ROOT__ . 'routes/api.php';
    require_once __ROOT__ . 'routes/web.php';

    \App\Kernel::run();
    \App\Core\Routes\Route::run();

} catch (Throwable $e) {
    if($config['app']['debug']){
        var_dump($e);
    }else{
        echo "Error";
    }
}


