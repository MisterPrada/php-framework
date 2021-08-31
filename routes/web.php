<?php

Route::$groupMiddleware = [];

Route::get('/', ['LanguageController', 'setHomeLang']);
Route::get('/404', ['Main', 'notFound']);

Route::get('/setlang/{language}', ['LanguageController', 'setLang'])->name('lang');

Route::group(['prefix' => Lang::getLang()], function (){
    Route::get('', ['Main', 'home'])->name('home');
});


/*Route::get('/blog/user/{id}', ['Main', 'index'])->name('user');
Route::get('/blog/user/{id}/{cat}', ['Main', 'index'])->name('cat');
Route::post('/blog/user/{id}', ['Main', 'secret'])->name('userasdf');

Route::get('/test/{id}/prada', ['Main', 'index'])->name('prada');
Route::get('/catalog/{$category}/{id}', ['Main', 'catalog'])->name('catalog');*/

