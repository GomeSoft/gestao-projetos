<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/projetos', [ProjectController::class, 'store'])->middleware('honeypot');
