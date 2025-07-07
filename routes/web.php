<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

//Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProfile']);
//Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'updateProfile']);


Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'update']);

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
