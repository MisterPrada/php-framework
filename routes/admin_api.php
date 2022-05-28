<?php

use App\Core\Routes\Route;

Route::$groupMiddleware = [];


Route::group(['prefix' => config('app.admin_panel_url') . '/api/'], function (){

    Route::group(['middleware' => ['AuthApi']], function (){
        Route::post('dashboard', ['Admin/Api/MainController', 'index'])->name('admin.api.home');

        /** Users **/
        Route::get('users/list', ['Admin/Api/MainController', 'index'])->name('admin.api.users.list');
    });

    Route::post('login', ['Admin/Api/MainController', 'login'])->name('admin.api.login');
});

