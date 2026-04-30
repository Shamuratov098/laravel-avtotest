<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Services\Admin\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(Request $request): View
    {
        $users = $this->userService->getAllUsers($request->input('search'));
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $stats = $this->userService->getUserStats($user);
        $sessions = $this->userService->getUserSessions($user);
        return view('admin.users.show', compact('user', 'stats', 'sessions'));
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->userService->deleteUser($user);
        return $this->success('admin.users.index', 'Foydalanuvchi muvaffaqiyatli o\'chirildi!');
    }
}
