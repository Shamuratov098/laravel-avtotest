<?php

namespace App\Services;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(RegisterRequest $request): array
    {
        $validated = $request->validated();
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();
        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function me(Request $request): JsonResponse
    {
        return response()->json($request->user());
    }
}
