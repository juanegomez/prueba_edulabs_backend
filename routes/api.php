<?php
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']); // Ruta para registrar a un usuario
Route::post('/login', [AuthController::class, 'login'])->name('login'); // Ruta para iniciar sesión

// Rutas protegidas
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Ruta para cerrar sesión
});