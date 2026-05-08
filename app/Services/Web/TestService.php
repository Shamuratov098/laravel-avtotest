<?php

namespace App\Services\Web;

use App\Models\TestSession;
use App\Models\TestResult;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TestService
{
    /**
     * Testni boshlash (in_progress)
     */
    public function startTest(string $type, ?int $categoryId = null)
    {
        $totalQuestions = ($type === 'random') ? 20 : 10;
        $timeLimitMinutes = ($type === 'random') ? 30 : 15;

        $session = TestSession::create([
            'user_id' => Auth::id(),
            'category_id' => $categoryId,
            'type' => $type,
            'status' => TestSession::In_progress,
            'total_questions' => $totalQuestions,
            'started_at' => now(),
        ]);

        if ($type === 'category') {
            $questions = \App\Models\Question::where('category_id', $categoryId)
                            ->inRandomOrder()
                            ->limit($totalQuestions)
                            ->get();
        } else {
            $questions = \App\Models\Question::inRandomOrder()
                            ->limit($totalQuestions)
                            ->get();
        }

        // ====================================================
        // TAYMER MANTIQI (Backend hisob-kitobi)
        // ====================================================
        // 1. Tugash vaqtini hisoblaymiz (Boshlangan vaqt + Berilgan daqiqa)
        $endTime = \Carbon\Carbon::parse($session->started_at)->addMinutes($timeLimitMinutes);
        
        // 2. Hozirgi vaqtdan tugash vaqtigacha necha sekund qolganini topamiz
        $remainingSeconds = now()->diffInSeconds($endTime, false);
        
        // 3. Agar vaqt o'tib ketgan bo'lsa manfiy sonni emas, 0 ni olamiz
        $timeLeft = $remainingSeconds > 0 ? (int) $remainingSeconds : 0;

        return [
            'session' => $session,
            'time_limit' => $timeLimitMinutes,
            'total_questions' => $totalQuestions,
            'questions' => $questions,
            'timeLeft' => $timeLeft // <--- HISOB-KITOB QILINGAN VAQT (SEKUNDDA)
        ];
    }

    /**
     * Testni yakunlash (completed) va Natijalarni saqlash
     */
    public function finishTest(array $data)
    {
        $session = \App\Models\TestSession::find($data['session_id']);

        if (!$session) {
            return ['success' => false, 'message' => 'Sessiya topilmadi'];
        }

        // 1. Sessiyani yangilash (Oldingi yozganimiz)
        $session->update([
            'correct_count' => $data['correct'],
            'status'       => 'completed',
            'total_questions' => count($data['answers'] ?? []),
            'completed_at' => now(),
        ]);

        // ====================================================
        // 2. YANGI QISM: Batafsil natijalarni saqlash
        // ====================================================
        if (isset($data['answers']) && is_array($data['answers'])) {
            foreach ($data['answers'] as $ans) {
                \App\Models\TestResult::create([
                    'test_session_id' => $session->id,
                    'question_id'     => $ans['question_id'],
                    'chosen_answer'   => $ans['chosen_answer'],
                    'is_correct'      => $ans['is_correct'],
                    // Agar 'test_results' jadvalingizda boshqa ustunlar ham bo'lsa 
                    // (masalan, tanlangan javob ID si), shu yerga qo'shasiz.
                ]);
            }
        }

        // 3. XP qo'shish (Oldingi yozganimiz)
        $xpEarned = $data['correct'] * 5;
        
        $user = auth()->user();
        $user->increment('xp', $xpEarned);

        return [
            'success' => true, 
            'xp' => $xpEarned,
            'message' => 'Natija muvaffaqiyatli saqlandi!'
        ];
    }
}