<?php

namespace App;

use Core\Lib\App;

class Kernel
{
    static public function run()
    {
       self::includeAdminPanel();
    }

    static public function includeAdminPanel() {
        if( isset(App::$route_parts[0]) ){
            if(config('app.admin_panel_url') == App::$route_parts[0] || config('app.admin_panel_url') == (App::$route_parts[1] ?? null)){
                require_once __ROOT__ . 'routes/admin.php';
                require_once __APP__ . 'Controllers/Admin/Api/ApiController.php';
                require_once __APP__ . 'Controllers/Admin/Controller.php';
                return;
            }
        }
    }
}