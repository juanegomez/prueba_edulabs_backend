<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\RegisterUserResource;
use Illuminate\Http\Request;
use App\Http\Services\Auth\AuthService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Registra un nuevo usuario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
    {
        try {
            $user = $this->authService->register($request->all());

            return response()->json([
                'user' => new RegisterUserResource($user),
                'message' => 'Usuario registrado exitosamente',
                'success' => true,
            ], Response::HTTP_CREATED);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * iniciar sesion.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request)
    {
        try {
            $token = $this->authService->login($request->all());

            return response()->json([
                'token' => $token,
                'success' => true,
            ], Response::HTTP_OK);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Credenciales invalidas.',
            ], Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * cerrar sesion.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout(Request $request)
    {
        try {
            $success = $this->authService->logout($request);

            if ($success) {
                return response()->json([
                    'message' => 'Sesión cerrada correctamente.',
                    'success' => true,
                ], status: Response::HTTP_OK);
            }

            return response()->json([
                'error' => 'Usuario no autenticado.',
            ], Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al cerrar sesión.',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}