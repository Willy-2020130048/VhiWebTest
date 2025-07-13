<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/login', fn() => response('Login required'))->name('login');

require __DIR__.'/auth.php';