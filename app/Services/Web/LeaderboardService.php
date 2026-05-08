<?php

namespace App\Services\Web;

use App\Models\User;
use Carbon\Carbon;

class LeaderboardService
{
    public function getLeaderboard(string $period = 'weekly')
    {
        $query = User::query();

        $query->withSum(['testSessions' => function ($q) use ($period) {
            // Faqat to'liq tugatilgan testlar hisobga olinadi
            $q->where('status', 'completed');

            // Vaqt bo'yicha qat'iy filtr
            if ($period === 'weekly') {
                $q->whereBetween('completed_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($period === 'monthly') {
                $q->whereMonth('completed_at', Carbon::now()->month)
                  ->whereYear('completed_at', Carbon::now()->year);
            }
            // 'all' (jami) bo'lsa vaqt filtri qilinmaydi, bazadagi barcha completed testlar olinadi
        }], 'correct_count');

        // Barcha foydalanuvchilarni saralash
        $users = $query->get()->map(function ($user) use ($period) {
            if ($period === 'all') {
                // Jami reytingda foydalanuvchining bazadagi o'z XP si olinadi
                $user->period_xp = $user->xp;
            } else {
                // Haftalik va oylik reytingda o'sha vaqtdagi to'g'ri javoblar orqali XP hisoblanadi
                $user->period_xp = ($user->test_sessions_sum_correct_count ?? 0) * 5;
            }
            return $user;
        })
        ->sortByDesc('period_xp')
        ->filter(function ($user) {
            return $user->period_xp > 0;
        })
        ->values() // Indekslarni 0 dan boshlab qayta raqamlash
        ->take(50);

        return $users;
    }
}