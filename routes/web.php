<?php

use App\Core\Routes\Route;
use Core\Lib\Lang;

Route::$groupMiddleware = [];

Route::get('/', ['LanguageController', 'setHomeLang']);
Route::get('/404', ['Main', 'notFound']);

Route::get('/setlang/{language}', ['LanguageController', 'setLang'])->name('lang');

Route::group(['prefix' => Lang::getLang()], function (){
    Route::get('', ['Main', 'home'])->name('home');

    Route::get('/user', ['Main', 'user'])->name('user');
    Route::post('/user', ['Main', 'user'])->name('user.post');
});


Route::get('/login', ['Auth/AuthController', 'login'])->name('auth.login');


// where переменная может быть только одна и в конце роута
//Route::get('/catalog/{name}', ['Main', 'catalog'])->where(['name' => '^[a-zA-Z0-9\/_-]+$']);



/*Route::get('/blog/user/{id}', ['Main', 'index'])->name('user');
Route::get('/blog/user/{id}/{cat}', ['Main', 'index'])->name('cat');
Route::post('/blog/user/{id}', ['Main', 'secret'])->name('userasdf');

Route::get('/test/{id}/prada', ['Main', 'index'])->name('prada');
Route::get('/catalog/{$category}/{id}', ['Main', 'catalog'])->name('catalog');*/

