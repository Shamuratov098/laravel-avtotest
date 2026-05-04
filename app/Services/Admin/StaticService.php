<?php
namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Question;
use App\Models\TestSession;
use App\Models\User;
use App\TestSessionStatus;
use App\TestSessionType;
use Carbon\Carbon;

class StaticService
{
    private const PASS_THRESHOLD_PERCENT = 90;

    public function getDashboardStats(): array
    {
        $now = Carbon::now();
        $startOfWeek = $now->copy()->startOfWeek();
        $startOfDay = $now->copy()->startOfDay();

        return [
            'categories' => [
                'total' => Category::count(),
            ],
            'questions' => [
                'total' => Question::count(),
            ],
            'sessions' => [
                'total' => TestSession::where('status', TestSessionStatus::COMPLETED)->count(),
                'today' => TestSession::where('status', TestSessionStatus::COMPLETED)
                    ->where('created_at', '>=', $startOfDay)
                    ->count(),
            ],
            'users' => [
                'total' => User::where('role', '!=', 'admin')->count(),
                'new_this_week' => User::where('role', '!=', 'admin')
                    ->where('created_at', '>=', $startOfWeek)
                    ->count(),
            ],
        ];
    }

    public function getTrendStats(): array
    {
        $now = Carbon::now();
        $last7Start = $now->copy()->subDays(7)->startOfDay();
        $prev7Start = $now->copy()->subDays(14)->startOfDay();
        $prev7End = $last7Start;

        return [
            'categories' => $this->percentChange(
                Category::where('created_at', '>=', $last7Start)->count(),
                Category::whereBetween('created_at', [$prev7Start, $prev7End])->count(),
            ),
            'questions' => $this->percentChange(
                Question::where('created_at', '>=', $last7Start)->count(),
                Question::whereBetween('created_at', [$prev7Start, $prev7End])->count(),
            ),
            'sessions' => $this->percentChange(
                TestSession::where('status', TestSessionStatus::COMPLETED)
                    ->where('created_at', '>=', $last7Start)->count(),
                TestSession::where('status', TestSessionStatus::COMPLETED)
                    ->whereBetween('created_at', [$prev7Start, $prev7End])->count(),
            ),
            'users' => $this->percentChange(
                User::where('role', '!=', 'admin')
                    ->where('created_at', '>=', $last7Start)->count(),
                User::where('role', '!=', 'admin')
                    ->whereBetween('created_at', [$prev7Start, $prev7End])->count(),
            ),
        ];
    }

    private function percentChange(int $current, int $previous): array
    {
        if ($previous === 0) {
            return [
                'percent' => $current > 0 ? 100 : 0,
                'direction' => $current > 0 ? 'up' : 'flat',
            ];
        }

        $change = (($current - $previous) / $previous) * 100;

        return [
            'percent' => abs(round($change)),
            'direction' => $change > 0 ? 'up' : ($change < 0 ? 'down' : 'flat'),
        ];
    }

    public function getTopCategories(int $limit = 5): array
    {
        $rows = TestSession::query()
            ->selectRaw('category_id, COUNT(*) as sessions_count')
            ->where('status', TestSessionStatus::COMPLETED)
            ->whereNotNull('category_id')
            ->groupBy('category_id')
            ->orderByDesc('sessions_count')
            ->limit($limit)
            ->with('category:id,name')
            ->get();

        $maxCount = $rows->max('sessions_count') ?: 1;

        return $rows->map(fn ($row) => [
            'name' => $row->category?->name ?? '—',
            'count' => (int) $row->sessions_count,
            'percent' => (int) round(($row->sessions_count / $maxCount) * 100),
        ])->all();
    }

    public function getRecentSessions(int $limit = 8): array
    {
        return TestSession::query()
            ->where('status', TestSessionStatus::COMPLETED)
            ->with(['user:id,name', 'category:id,name'])
            ->orderByDesc('completed_at')
            ->limit($limit)
            ->get()
            ->map(function (TestSession $session) {
                $total = max((int) $session->total_questions, 1);
                $correct = (int) $session->correct_count;
                $percent = (int) round(($correct / $total) * 100);

                return [
                    'user_name' => $session->user?->name ?? '—',
                    'category_label' => $session->type === TestSessionType::RANDOM
                        ? 'Tasodifiy'
                        : ($session->category?->name ?? '—'),
                    'is_random' => $session->type === TestSessionType::RANDOM,
                    'correct' => $correct,
                    'total' => $total,
                    'percent' => $percent,
                    'passed' => $percent >= self::PASS_THRESHOLD_PERCENT,
                    'time_ago' => $session->completed_at?->diffForHumans() ?? '—',
                ];
            })
            ->all();
    }

    public function getPassRate(): array
    {
        $since = Carbon::now()->subDays(30)->startOfDay();

        $row = TestSession::query()
            ->where('status', TestSessionStatus::COMPLETED)
            ->where('created_at', '>=', $since)
            ->where('total_questions', '>', 0)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN (correct_count * 100.0 / total_questions) >= ? THEN 1 ELSE 0 END) as passed
            ', [self::PASS_THRESHOLD_PERCENT])
            ->first();

        $total = (int) ($row->total ?? 0);
        $passed = (int) ($row->passed ?? 0);
        $failed = $total - $passed;
        $percent = $total > 0 ? (int) round(($passed / $total) * 100) : 0;

        return [
            'total' => $total,
            'passed' => $passed,
            'failed' => $failed,
            'percent' => $percent,
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
        $data = TestSession::selectRaw("TO_CHAR(created_at, 'YYYY-MM') as month, COUNT(*) as count")
            ->where('status', TestSessionStatus::COMPLETED)
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
            ->where('status', TestSessionStatus::COMPLETED)
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
