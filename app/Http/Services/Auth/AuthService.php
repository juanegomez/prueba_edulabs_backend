<?php

namespace App\Http\Services\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    /**
     * Registra un nuevo usuario en la aplicación.
     *
     * @param array $userData
     * @return \App\Models\User
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

    /**
     * Inicia sesión de un usuario y devuelve un token.
     *
     * @param array $credentials
     * @return string
     */
    public function login(array $credentials)
    {
        // Validar las credenciales
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        // Validar credenciales del usuario
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('Basic Token')->plainTextToken;

            return $token;
        }

        throw new Exception("Credenciales invalidas.");

    }

    /**
     * Cierra la sesión del usuario y revoca el token.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    public function logout($request): bool
    {
        $user = $request->user();

        if ($user) {
            // Revocar el token actual
            $user->currentAccessToken()->delete();
            return true;
        }

        return false;
    }
}