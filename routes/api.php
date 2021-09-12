<?php

use App\Core\Routes\Route;

Route::$groupMiddleware = [];

//Route::get('/api/user/{id}', ['Main', 'index'])->name('api.user');

Route::post('/api/user', ['Api/UserController', 'index'])->name('api.user');