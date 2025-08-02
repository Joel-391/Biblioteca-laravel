<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\AdminController;
//Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProfile']);
//Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'updateProfile']);


Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'update']);

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
Route::get('/libros/buscar', [BookController::class, 'buscarLibros']);
Route::get('/libros/{id}', [BookController::class, 'show']);

Route::get('/libros/{id}/comentarios', [ComentarioController::class, 'index']);
Route::post('/libros/{id}/comentarios', [ComentarioController::class, 'store'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (\Illuminate\Http\Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/sanciones', [AdminController::class, 'misSanciones']);
Route::get('/categorias', [AdminController::class, 'getCategorias']);

