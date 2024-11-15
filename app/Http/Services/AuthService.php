<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Registra un nuevo usuario en la aplicación.
     *
     * @param array $userData Datos del usuario a registrar
     * @return \App\Models\User El usuario creado.
     */
    public function register(array $userData)
    {
        // Validar los datos del usuario
        $validator = Validator::make($userData, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-zA-Z0-9]/',
            ],
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Crear el usuario
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => Hash::make($userData['password']),
        ]);

        return $user;
    }
}