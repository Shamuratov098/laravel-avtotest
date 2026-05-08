<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\Auth\LoginRequest;
use App\Http\Requests\Web\Auth\RegisterRequest;
use App\Services\Web\AuthService;
use Illuminate\Http\Request;

class WebAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // --- LOGIN QISMI ---
    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(LoginRequest $request)
    {
        if ($this->authService->login($request->validated(), $request->has('remember'))) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Kiritilgan email yoki parol noto\'g\'ri.',
        ])->onlyInput('email');
    }

    // --- REGISTER QISMI ---
    public function showRegisterForm()
    {
        return view('user.register');
    }

    public function register(RegisterRequest $request)
    {
        $this->authService->register($request->validated());

        return redirect()->route('dashboard');
    }

    // --- LOGOUT QISMI ---
    public function logout(Request $request)
    {
        $this->authService->logout();
        return redirect()->route('login');
    }
}