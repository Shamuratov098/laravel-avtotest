<?php

namespace App\Services\Web;

use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function getUserStats(): array
    {
        $user = Auth::user();
        
        // Faqat tugallangan (completed) testlarni olamiz
        $completedSessions = $user->testSessions()->where('status', 'completed')->get();
        
        // --- ESKI MANTIQ (XP va Foiz) ---
        $totalQuestions = $completedSessions->sum('total_questions');
        $correctAnswers = $completedSessions->sum('correct_count');
        $percentage = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 100) : 0;

        // --- YANGI MANTIQ (Statistikalar) ---
        // Sessiyalarni turlarga ajratamiz
        $randomSessions = $completedSessions->where('type', 'random');
        $categorySessions = $completedSessions->where('type', 'category');

        $totalExams = $randomSessions->count();
        $totalPractices = $categorySessions->count();

        // O'tganlarni hisoblash (20 ta savol ishlangan va kamida 18 ta to'g'ri bo'lsa)
        $passedExams = $randomSessions->filter(function ($session) {
            return $session->total_questions == 20 && $session->correct_count >= 18;
        })->count();

        // Yiqilganlar - bu jami haqiqiy imtihonlardan o'tganlarni ayirib tashlaganimiz
        $failedExams = $totalExams - $passedExams; 

        // Hammasini bitta massiv qilib Controller'ga qaytaramiz
        return [
            'xp'             => $user->xp,
            'percentage'     => $percentage,
            'total_tests'    => $completedSessions->count(),
            
            // Yangi qo'shilgan qiymatlar:
            'totalExams'     => $totalExams,
            'totalPractices' => $totalPractices,
            'passedExams'    => $passedExams,
            'failedExams'    => $failedExams,
        ];
    }
}