<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    )
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $result = $this->authService->register($request);
        return response()->json([
            'user' => $result['user'],
            'token' => $result['token']
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->authService->login($request);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->authService->me($request);
    }
}
