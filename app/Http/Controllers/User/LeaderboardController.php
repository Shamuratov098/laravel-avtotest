<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class LeaderboardController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->query('period', 'weekly'); 
        
        $query = User::query();
        
        // 1. Bazadan to'g'ri javoblarni yig'ish
        if ($period === 'daily') {
            $query->withSum(['testSessions' => function($q) {
                $q->whereDate('created_at', today());
            }], 'correct_count');
        } elseif ($period === 'monthly') {
            $query->withSum(['testSessions' => function($q) {
                $q->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
            }], 'correct_count');
        } elseif ($period === 'weekly') {
            $query->withSum(['testSessions' => function($q) {
                $q->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            }], 'correct_count');
        }

        // 2. XP hisoblash va saralash
        $users = $query->get()->map(function ($user) use ($period) {
            if ($period === 'all') {
                $user->period_xp = $user->xp;
            } else {
                $user->period_xp = ($user->test_sessions_sum_correct_count ?? 0) * 10;
            }
            return $user;
        })
        ->sortByDesc('period_xp')
        ->filter(function ($user) {
            return $user->period_xp > 0;
        })
        ->values() 
        ->take(50); 

        // ==========================================
        // 3. BLADE UCHUN MA'LUMOTLARNI TAYYORLASH (Yangi qism)
        // ==========================================
        
        // Shohsupa uchun Top 3 talik
        $top1 = $users->get(0);
        $top2 = $users->get(1);
        $top3 = $users->get(2);
        
        // Qolgan ishtirokchilar (4-o'rindan boshlab)
        $otherUsers = $users->skip(3);

        // Joriy foydalanuvchining o'rni va XP sini aniqlash
        $currentUserId = auth()->id();
        $currentUserRankIndex = $users->search(fn($user) => $user->id === $currentUserId);
        
        $currentUserRank = $currentUserRankIndex !== false ? $currentUserRankIndex + 1 : null;
        
        $currentUserData = $users->where('id', $currentUserId)->first();
        $currentUserXp = $currentUserData ? $currentUserData->period_xp : 0;

        // Barcha tayyor o'zgaruvchilarni View'ga uzatamiz
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