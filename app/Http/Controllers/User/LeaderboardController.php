<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Web\LeaderboardService;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    protected $leaderboardService;

    public function __construct(LeaderboardService $leaderboardService)
    {
        $this->leaderboardService = $leaderboardService;
    }

    public function index(Request $request)
    {
        $period = $request->query('period', 'weekly'); 
        
        // Servicedan tayyor hisoblangan va saralangan ma'lumotni olamiz
        $users = $this->leaderboardService->getLeaderboard($period);

        // Blade uchun ma'lumotlarni qismlarga ajratish
        $top1 = $users->get(0);
        $top2 = $users->get(1);
        $top3 = $users->get(2);
        
        $otherUsers = $users->skip(3);

        // Joriy foydalanuvchining o'rni va XP sini aniqlash
        $currentUserId = auth()->id();
        $currentUserRankIndex = $users->search(fn($user) => $user->id === $currentUserId);
        
        $currentUserRank = $currentUserRankIndex !== false ? $currentUserRankIndex + 1 : null;
        
        $currentUserData = $users->where('id', $currentUserId)->first();
        $currentUserXp = $currentUserData ? $currentUserData->period_xp : 0;

        return view('user.leaderboard', compact(
            'period', 
            'top1', 
            'top2', 
            'top3', 
            'otherUsers', 
            'currentUserRank', 
            'currentUserXp'
        ));
    }
}