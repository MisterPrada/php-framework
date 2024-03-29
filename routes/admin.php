<?php

use App\Core\Routes\Route;

require_once 'admin_api.php';

Route::group(['prefix' => config('app.admin_panel_url')], function (){
    Route::get('', ['Admin/MainController', 'index'])->name('admin.home');

    Route::get('/options', ['Admin/OptionsController', 'index'])->name('admin.options');

    Route::get('/{name}',['Admin/MainController', 'index'])->where(['name' => '^[a-zA-Z0-9\/_-]+$']);
});


