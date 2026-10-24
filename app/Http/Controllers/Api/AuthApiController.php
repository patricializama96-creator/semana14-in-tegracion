<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    public function login(Request $request)
    {
        $datos = $request->validate([
            'email'       => ['required', 'email'],
            'password'    => ['required'],
            'dispositivo' => ['required', 'max:100'],
        ]);

        $user = User::where('email', $datos['email'])->first();

        if (! $user || ! Hash::check($datos['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Las credenciales no coinciden.',
            ]);
        }

        $token = $user->createToken($datos['dispositivo']);

        return response()->json([
            'token' => $token->plainTextToken,
            'tipo'  => 'Bearer',
        ], 201);
    }

    public function yo(Request $request)
    {
        return $request->user()->only('id', 'name', 'email');
    }

    // Lab 8: borra solo el token con el que se hizo esta petición
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->noContent(); // 204
    }

    // Reto: lista los dispositivos con sesión abierta (sin exponer el hash)
    public function tokens(Request $request)
    {
        return $request->user()->tokens()
            ->select('id', 'name', 'created_at', 'last_used_at')
            ->get();
    }

    // Reto extra: cierra la sesión de un dispositivo concreto
    public function borrarToken(Request $request, $id)
    {
        // Busca solo entre los tokens del usuario: un id ajeno da 404
        $request->user()->tokens()->where('id', $id)->firstOrFail()->delete();

        return response()->noContent(); // 204
    }
}
