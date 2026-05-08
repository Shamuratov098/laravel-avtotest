<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\ProfileUpdateRequest;
use App\Services\Web\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        return view('user.profile');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $this->profileService->updateProfile(
            Auth::user(), 
            $request->validated(), 
            $request->file('avatar')
        );

        return back()->with('success', 'Profil muvaffaqiyatli yangilandi.');
    }
}