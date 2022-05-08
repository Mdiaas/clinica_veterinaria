<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        $token = auth('api')->attempt($credentials);
        if ($token)
            return response()->json(['token' => $token]);
        return response()->json(['erro' => 'usuário ou senha inválido'], 403);
    }
    public function logout()
    {
        auth('api')->logout();
        return response()->json(['msg' => 'logout realizado com sucesso']);
    }
    public function refresh()
    {
        $token = auth('api')->refresh();
        return response()->json(['token' => $token]);
    }
    public function me()
    {
        return response()->json(auth()->user());
    }
}
