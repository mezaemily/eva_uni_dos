<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        try {
            $token = JWTAuth::fromUser($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        $user = User::find(Auth::user()->id);
       
        return response()->json([
            'token' => $token,
            'user' => $user,
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
        ]);
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function getUser()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }
            return response()->json($user);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Failed to fetch user profile'], 500);
        }
    }

public function updateUser(Request $request)
{
    try {
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'No se encontró el usuario. El Token no es válido o no se envió.'], 401);
        }

        $user->update($request->only(['name', 'email']));
        return response()->json([
            'message' => 'Usuario actualizado con éxito',
            'user' => $user
        ]);
    } catch (\Exception $e) { 
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
/**
     * GET /api/usuarios-sistema
     * Devuelve la lista de todos los usuarios registrados.
     */
    public function usuariosSistema()
    {
        // Traemos todos los usuarios con sus campos básicos
        $usuarios = \App\Models\User::select('id', 'name', 'email', 'balance', 'role')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'total' => $usuarios->count(),
            'usuarios' => $usuarios
        ]);
    }
}