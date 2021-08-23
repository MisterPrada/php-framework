<?php

require_once __CORE__ . '/routes/Route.php';

require_once __APP__ . '/Controllers/Main.php';

Route::get('/user/{id}', [Main::class, 'index'])->name('user');
Route::get('/blog', [Main::class, 'blog'])->name('blog');


var_dump(Route::$routeList);

