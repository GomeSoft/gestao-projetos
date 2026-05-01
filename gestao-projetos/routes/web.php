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

use App\Http\Controllers\AuthController;

Route::middleware('auth:sanctum')->group(function () {
    // Logout protegido contra ataques de força bruta
    Route::post('/logout', [AuthController::class, 'logout'])
        ->middleware('throttle:5,1'); 
});