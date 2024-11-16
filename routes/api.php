<?php
use App\Http\Controllers\Posts\PostsController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']); // Ruta para registrar a un usuario
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Ruta para iniciar sesión

// Rutas protegidas
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Ruta para cerrar sesión
    Route::post('/posts', [PostsController::class, 'create']); // Ruta para crear un post
    Route::get('/posts/{categoryid}', [PostsController::class, 'getPostByCategoryAndUserId']); // Ruta para obtener posts por categoria
});