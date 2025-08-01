<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EjemplarController;
use App\Http\Controllers\AlquilerController;

Route::get('/libros/{libro}/ejemplares-disponibles', [EjemplarController::class, 'disponibles']);
Route::middleware('auth:sanctum')->get('/alquileres', [AlquilerController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/alquileres', [AlquilerController::class, 'store']);
});


// O si quieres puedes crear rutas separadas para usuarios, libros y categorías


// routes/api.php


Route::middleware('auth:sanctum')->group(function () {
    // Obtener todos
    Route::get('/admin/users',        [AdminController::class, 'getUsers']);
    Route::get('/admin/libros',       [AdminController::class, 'getLibros']);
    Route::get('/admin/categorias',   [AdminController::class, 'getCategorias']);
    Route::get('/admin/alquileres',   [AdminController::class, 'getAlquileres']);
    Route::get('/admin/comentarios',  [AdminController::class, 'getComentarios']);
    Route::get('/admin/ejemplares',   [AdminController::class, 'getEjemplares']);
    Route::get('/admin/sanciones',    [AdminController::class, 'getSanciones']);

    // Crear
    Route::post('/admin/users',       [AdminController::class, 'storeUser']);
    Route::post('/admin/libros',      [AdminController::class, 'storeLibro']);
    Route::post('/admin/categorias',  [AdminController::class, 'storeCategoria']);
    Route::post('/admin/alquileres',  [AdminController::class, 'storeAlquiler']);
    Route::post('/admin/comentarios', [AdminController::class, 'storeComentario']);
    Route::post('/admin/ejemplares',  [AdminController::class, 'storeEjemplar']);
    Route::post('/admin/sanciones',   [AdminController::class, 'storeSancion']);

    // Actualizar
    Route::put('/admin/users/{id}',       [AdminController::class, 'updateUser']);
    Route::put('/admin/libros/{id}',      [AdminController::class, 'updateLibro']);
    Route::put('/admin/categorias/{id}',  [AdminController::class, 'updateCategoria']);
    Route::put('/admin/alquileres/{id}',  [AdminController::class, 'updateAlquiler']);
    Route::put('/admin/comentarios/{id}', [AdminController::class, 'updateComentario']);
    Route::put('/admin/ejemplares/{id}',  [AdminController::class, 'updateEjemplar']);
    Route::put('/admin/sanciones/{id}',   [AdminController::class, 'updateSancion']);

    // Eliminar
    Route::delete('/admin/users/{id}',       [AdminController::class, 'deleteUser']);
    Route::delete('/admin/libros/{id}',      [AdminController::class, 'deleteLibro']);
    Route::delete('/admin/categorias/{id}',  [AdminController::class, 'deleteCategoria']);
    Route::delete('/admin/alquileres/{id}',  [AdminController::class, 'deleteAlquiler']);
    Route::delete('/admin/comentarios/{id}', [AdminController::class, 'deleteComentario']);
    Route::delete('/admin/ejemplares/{id}',  [AdminController::class, 'deleteEjemplar']);
    Route::delete('/admin/sanciones/{id}',   [AdminController::class, 'deleteSancion']);
});






Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

//Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'update']);
Route::middleware('auth:sanctum')->get('/profile', [ProfileController::class, 'getProfile']);

use Laravel\Sanctum\SanctumServiceProvider;



Route::middleware('auth:sanctum')->put('/profile', [ProfileController::class, 'update']);



Route::get('/recent-books', [BookController::class, 'getRecentBooks']);
Route::get('/recommended-books', [BookController::class, 'getRecommendedBooks']);
Route::get('/libros/buscar', [BookController::class, 'buscarLibros']);
Route::get('/libros/{id}', [BookController::class, 'show']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/sanctum/csrf-cookie', function () {
    return response()->json(['csrf' => true]);
});
