<?php
namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Question;
use App\Models\TestSession;
use App\Models\User;
use App\TestSessionStatus;
use Carbon\Carbon;

class StaticService
{
    public function getDashboardStats(): array
    {
        $now = Carbon::now();

        return [
            'categories' => [
                'total' => Category::count(),
            ],
            'questions' => [
                'total' => Question::count(),
            ],
            'sessions' => [
                'total' => TestSession::where('status', TestSessionStatus::COMPLETED)->count(),
            ],
            'users' => [
                'total' => User::where('role', '!=', 'admin')->count(),
            ],
        ];
    }

    public function getDailyTests(): array
    {
        $data = TestSession::selectRaw('created_at::date as date, COUNT(*) as count')
            ->where('status', TestSessionStatus::COMPLETED)
            ->where('created_at', '>=', now()->subDays(29)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        $result = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $result[$date] = $data[$date] ?? 0;
        }

        return $result;
    }

    public function getMonthlyTests(): array
    {
        // ✅ TO_CHAR PostgreSQL formati: 'YYYY-MM'
        $data = TestSession::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count")
            ->where('status', TestSessionStatus::COMPLETED) // ✅ filter qo'shildi
            ->where('created_at', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month')
            ->toArray();

        $result = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('Y-m');
            $result[$month] = $data[$month] ?? 0;
        }

        return $result;
    }

    public function getYearlyTests(): array
    {
        $data = TestSession::selectRaw('EXTRACT(YEAR FROM created_at)::int as year, COUNT(*) as count')
            ->where('status', TestSessionStatus::COMPLETED) // ✅ filter qo'shildi
            ->where('created_at', '>=', now()->subYears(4)->startOfYear())
            ->groupBy('year')
            ->orderBy('year')
            ->pluck('count', 'year')
            ->toArray();

        $result = [];
        for ($i = 4; $i >= 0; $i--) {
            $year = (int) now()->subYears($i)->format('Y');
            $result[$year] = $data[$year] ?? 0;
        }

        return $result;
    }
}
