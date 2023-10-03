<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        // Валидация данных
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string'
        ]);

        // Поиск пользователя по login
        $user = User::where('login', $request->get('login'))->first();
        if ($user){
            if (Hash::check($request->get('password'), $user->password)){
                // Генерирует токен
                $token = $user->createToken('user-auth');
                // Отправляет токен
                return response()->json(['message' => 'User logged in', 'token' => $token->plainTextToken], 200);
            }
            // Если пароль неверный отправяет ошибку
            return response()->json(['message' => 'Invalid password'], 400);
        }
        // Если пользователь не найден отправяет ошибку
        return response()->json(['message' => 'User not found'], 400);
    }

    public function auth_with_token(Request $request, $token)
    {
        // Поиск пользователя по token
        $user = User::where('api_token', $token)->first();
        if ($user){
            // Авторизация пользователя
            Auth::login($user);
            $token = Auth::user()->createToken('user-auth');
            // Отправляет токен
            return response()->json(['message' => 'User logged in', 'token' => $token->plainTextToken], 200);
        }
        // Если пользователь не найден отправяет ошибку
        return response()->json(['message' => 'User not found'], 400);
    }
}
