<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index() {
        return view('user.profile', ['user' => auth()->user()]);
    }

    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'avatar' => 'nullable|image|mimes:jpg,png|max:2048' // Max 2MB rasm
        ]);

        if ($request->hasFile('avatar')) {
            // 1. Eski rasmni o'chiramiz (agar u default bo'lmasa)
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // 2. Yangi rasmni storage/app/public/avatars papkasiga saqlaymiz
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $request->name;
        $user->save();

        return back()->with('success', 'Profil yangilandi!');
    }
}
