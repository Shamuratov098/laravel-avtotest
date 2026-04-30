<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebAuthController extends Controller
{
    // ==========================================
    // 1. LOGIN QISMI
    // ==========================================

    public function showLoginForm()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Login yoki parol noto\'g\'ri.',
        ])->onlyInput('email');
    }

    // ==========================================
    // 2. REGISTER QISMI
    // ==========================================

    public function showRegisterForm()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    // ==========================================
    // 3. PROFIL VA TAHRIRLASH (Sessiya orqali)
    // ==========================================

    /**
     * Foydalanuvchi profilini ko'rsatish
     */
    public function dashboard()
{
    // Auth::user() orqali sessiyadagi user-ni olamiz
    $user = Auth::user();
    
    // view() funksiyasi blade tizimini ishga tushiradi
    return view('user.dashboard', compact('user'));
}

    /**
     * Ma'lumotlarni tahrirlash sahifasi
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user.edit', compact('user'));
    }

    /**
     * Ma'lumotlarni bazada yangilash
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($validated);

        return redirect()->route('dashboard')->with('success', 'Ma’lumotlar muvaffaqiyatli yangilandi!');
    }

    // ==========================================
    // 4. TIZIMDAN CHIQISH
    // ==========================================

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}