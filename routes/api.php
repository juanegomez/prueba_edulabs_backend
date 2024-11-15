<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

//Ruta para registrar a un usuario
Route::post('/register', [AuthController::class, 'register']);

