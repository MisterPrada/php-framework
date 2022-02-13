<?php

session_start();

/** Dir constants  */
define('__ROOT__', dirname(__FILE__) . '/../');
define('__APP__', __ROOT__ . 'app/');
define('__CORE__', __ROOT__ . 'core/');
define('__RESOURCES__', __ROOT__ . 'resources/');
define('__VIEWS__', __ROOT__ . 'resources/views/');
define('__STORAGE__', __ROOT__ . 'storage/');
define('__PUBLIC__', __ROOT__ . 'public/');

try {
    // Get main config
    $config = require_once __ROOT__ . '/config/config.php';

    // Libraries
    require_once __CORE__ . 'Lib/SystemFunctions.php';

    // Connecting the required classes
    require_once __CORE__ . 'Database/Db.php'; // Database connection
    require_once __CORE__ . 'Lib/App.php'; // Main App class
    require_once __CORE__ . 'Lib/Request.php'; // Global request state
    require_once __CORE__ . 'Lib/Response.php'; // Response constructor
    require_once __CORE__ . 'Lib/Observer.php'; // Observer pattern for class controller
    require_once __CORE__ . 'Routes/Route.php'; // The general class is used to register routes in the system
    require_once __CORE__ . 'Lib/FileSystem/Storage.php'; // Storage system

    require_once __APP__ . 'Models/Model.php'; // Model for a single table in a database
    require_once __APP__ . 'Controllers/Controller.php'; //
    require_once __APP__ . 'Controllers/Api/ApiController.php';

    require_once __APP__ . 'Kernel.php';
    require_once __CORE__ . 'Lib/Auth.php';

    // Declaring routes
    require_once __ROOT__ . 'routes/api.php';
    require_once __ROOT__ . 'routes/web.php';

    \App\Kernel::run();
    \App\Core\Routes\Route::run();

} catch (Throwable $e) {
    /** Catch all errors */

    if ($config['app']['debug']) {
        var_dump($e);
    } else {
        echo "Error";
    }
}


