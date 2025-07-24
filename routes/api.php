<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;


use App\Http\Controllers\ProfileController;


//Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'update']);
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProfile']);

use Laravel\Sanctum\SanctumServiceProvider;



Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'update']);



Route::get('/recent-books', [BookController::class, 'getRecentBooks']);
Route::get('/recommended-books', [BookController::class, 'getRecommendedBooks']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf' => true]);
});