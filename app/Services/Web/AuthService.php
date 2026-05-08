<?php

namespace App\Services\Web;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * Yangi foydalanuvchini ro'yxatdan o'tkazish
     */
    public function register(array $request): User
    {
        $user=User::create([
            'name' => $request['name'],
            'phone' => $request['phone'], // Saqlash
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ]);

        // Ro'yxatdan o'tgach darhol tizimga kiritamiz
        Auth::login($user);

        return $user;
    }

    /**
     * Tizimga kirish (Login)
     */
    public function login(array $credentials, bool $remember = false): bool
    {
        if (Auth::attempt($credentials, $remember)) {
            session()->regenerate();
            return true;
        }

        return false;
    }

    /**
     * Tizimdan chiqish (Logout)
     */
    public function logout(): void
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }
}