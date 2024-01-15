<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\AuthRequest;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request){
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('authToken')->accessToken;
            return response()->json([
                'message' => 'Login exitoso',
                'data' => $user,
                'token' => $token
            ]);
        } else {
            $user = User::where('email', $request->email)->first();
            if(!$user){
                return response()->json(['message' => 'El usuario no existe'], 404);
            }else{
                return response()->json(['message' => 'Contraseña incorrecta'], 401);
            }
        }
    }

    public function logout(Request $request){
        $request->user()->token()->revoke();
        return response()->json(['message' => 'Logout exitoso']);
    }
    
}
