<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/projetos', [ProjectController::class, 'store'])->middleware('honeypot');

Route::middleware(['auth', 'verified'])->group(function () {
    // Rotas protegidas por login
    Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');
});