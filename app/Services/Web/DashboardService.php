<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getUserStats(): array
    {
        $user = Auth::user();

        $completedSessions = $user->testSessions()->where('status', 'completed')->get();

        $totalQuestions = $completedSessions->sum('total_questions');
        $correctAnswers = $completedSessions->sum('correct_count');
        $percentage     = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        $randomSessions   = $completedSessions->where('type', 'random');
        $categorySessions = $completedSessions->where('type', 'category');

        $totalExams     = $randomSessions->count();
        $totalPractices = $categorySessions->count();

        $passedExams = $randomSessions->filter(function ($session) {
            return $session->total_questions == 20 && $session->correct_count >= 18;
        })->count();

        $failedExams = $totalExams - $passedExams;

        $recentSessions = $user->testSessions()
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return [
            'xp'             => $user->xp,
            'percentage'     => $percentage,
            'total_tests'    => $completedSessions->count(),
            'totalExams'     => $totalExams,
            'totalPractices' => $totalPractices,
            'passedExams'    => $passedExams,
            'failedExams'    => $failedExams,
            'recentSessions' => $recentSessions,
        ];
    }

    /**
     * Filter va saralash bilan oxirgi urinishlar
     * Bu alohida metod — asosiy getUserStats ga tegmaydi
     */
    public function getFilteredSessions(array $filters): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $user  = Auth::user();
        $query = $user->testSessions()->where('status', 'completed');

        // 1. TUR filtri: 'random' yoki 'category'
        if (!empty($filters['type']) && $filters['type'] !== 'all') {
            $query->where('type', $filters['type']);
        }

        // 2. HOLAT filtri: 'passed', 'failed', 'practice'
        if (!empty($filters['status']) && $filters['status'] !== 'all') {
            if ($filters['status'] === 'passed') {
                // O'tdi: random, 20 savoldan 18+ to'g'ri
                $query->where('type', 'random')
                      ->where('total_questions', 20)
                      ->where('correct_count', '>=', 18);
            } elseif ($filters['status'] === 'failed') {
                // Yiqildi: random, lekin 18 dan kam
                $query->where('type', 'random')
                      ->where(function($q) {
                          $q->where('total_questions', '!=', 20)
                            ->orWhere('correct_count', '<', 18);
                      });
            } elseif ($filters['status'] === 'practice') {
                // Mashq: category turi
                $query->where('type', 'category');
            }
        }

        // 3. SARALASH: 'newest' yoki 'oldest'
        $order = (!empty($filters['sort']) && $filters['sort'] === 'oldest') ? 'asc' : 'desc';
        $query->orderBy('updated_at', $order);

        return $query->paginate(10)->withQueryString();
    }
}