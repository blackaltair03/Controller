<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Registro de usuario
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'roll' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roll' => $request->roll,
            'status' => 'alta'
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Usuario registrado con éxito',
            'data' => [
                'access_token' => $token,
                'user' => $user
            ]
        ], 201);
    }

    /**
     * Login de usuario
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Errores de validación',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Usuario no registrado',
                'error' => [
                    'http_code' => 404
                ]
            ], 404);
        }

        if ($user->status !== 'alta') {
            return response()->json([
                'success' => false,
                'message' => 'Usuario en estado de baja',
                'error' => [
                    'http_code' => 403
                ]
            ], 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'El password es incorrecto',
                'error' => [
                    'http_code' => 401
                ]
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => '¡Usuario logueado exitosamente!',
            'data' => [
                'access_token' => $token,
                'name' => $user->name
            ]
        ]);
    }

    /**
     * Logout de usuario
     */
    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Sesión finalizada',
        ]);
    }
}
