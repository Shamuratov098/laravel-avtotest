<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Question;
use App\Models\TestSession;
use App\Models\User;
use App\TestSessionStatus;

class StaticService
{

    public function getDashboardStats(): array
    {
        $now = \Carbon\Carbon::now();
        $thisMonth = $now->month;
        $thisYear = $now->year;
        $lastMonth = $now->copy()->subMonth()->month;
        $lastMonthYear = $now->copy()->subMonth()->year;

        //Categories
        $totalCategories = Category::count();
        $usersThisMonth = Category::whereMonth('created_at', '=', $thisMonth)
            ->whereYear('created_at', $thisYear)->count();
        $usersLastMonth = Category::whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)->count();

        //Questions
        $totalQuestions = Question::count();

        //Sessions
        $totalSessions = TestSession::where('status', TestSessionStatus::COMPLETED)->count();

        // Users
        $totalUsers = User::where('role', '!=', 'admin')->count();
        $usersThisMonth = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', $thisMonth)
            ->whereYear('created_at', $thisYear)->count();
        $usersLastMonth = User::where('role', '!=', 'admin')
            ->whereMonth('created_at', $lastMonth)
            ->whereYear('created_at', $lastMonthYear)->count();

        return [
            'categories' => [
                'total' => $totalCategories,
            ],
            'questions' => [
                'total' => $totalQuestions,
            ],
            'sessions' => [
                'total' => $totalSessions,
            ],
            'users' => [
                'total' => $totalUsers
            ],
        ];
    }
}
