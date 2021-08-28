<?php


Route::get('/blog/user/{id}', ['Main', 'index'])->name('user');
Route::get('/blog/user/{id}/{cat}', ['Main', 'index'])->name('cat');
Route::post('/blog/user/{id}', ['Main', 'secret'])->name('userasdf');

Route::get('/test/{id}/prada', ['Main', 'index'])->name('prada');
Route::get('/catalog/{$category}/{id}', ['Main', 'catalog'])->name('catalog');

