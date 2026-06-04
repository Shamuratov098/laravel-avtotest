<?php

namespace App\Services\Web;

use App\Models\TestSession;
use App\Models\TestResult;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TestService
{
    public function startTest(string $type, ?int $categoryId = null): array
    {
        $user             = Auth::user();
        $totalQuestions   = ($type === 'random') ? 20 : 10;
        $timeLimitMinutes = (str_contains((string)$type, 'random')) ? 30 : 15;

        TestSession::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->get()
            ->each(function($session) {
                $limit = ($session->type->value === 'random') ? 30 : 15;
                $limit = ($session->type === 'random') ? 30 : 15;
                $endTime = Carbon::parse($session->started_at)->addMinutes($limit);
                
                if (now()->greaterThan($endTime)) {
                    $session->update([
                        'status'       => 'completed',
                        'completed_at' => $endTime, // ← test vaqti tugagan aniq moment
                    ]);
                }
            });

        $session   = null;
        $questions = collect();

        $activeSession = TestSession::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->where('type', $type)
            ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
            ->latest()
            ->first();

        if ($activeSession) {
            $endTime          = Carbon::parse($activeSession->started_at)->addMinutes($timeLimitMinutes);
            $remainingSeconds = now()->diffInSeconds($endTime, false);

            if ($remainingSeconds > 0) {
                $session     = $activeSession;
                $results     = TestResult::where('test_session_id', $session->id)->orderBy('id')->get();
                $questionIds = $results->pluck('question_id')->toArray();
                $questions   = Question::whereIn('id', $questionIds)
                    ->get()
                    ->sortBy(fn($q) => array_search($q->id, $questionIds))
                    ->values();
            } else {
                $activeSession->update(['status' => 'completed']);
            }
        }

        if (!$session) {
            $session = TestSession::create([
                'user_id'         => $user->id,
                'category_id'     => $categoryId,
                'type'            => $type,
                'status'          => 'in_progress',
                'total_questions' => $totalQuestions,
                'started_at'      => now(),
            ]);

            $questions = ($type === 'category')
                ? Question::where('category_id', $categoryId)->where('is_active', true)->orderBy('order_in_category')->limit($totalQuestions)->get()
                : Question::where('is_active', true)->inRandomOrder()->limit($totalQuestions)->get();

            foreach ($questions as $q) {
                TestResult::create([
                    'test_session_id' => $session->id,
                    'question_id'     => $q->id,
                    'chosen_answer'   => 0,
                    'is_correct'      => false,
                ]);
            }
        }

        $endTime          = Carbon::parse($session->started_at)->addMinutes($timeLimitMinutes);
        $remainingSeconds = now()->diffInSeconds($endTime, false);
        $timeLeft         = $remainingSeconds > 0 ? (int) $remainingSeconds : 0;

        $answeredQuestions = TestResult::where('test_session_id', $session->id)
            ->where('chosen_answer', '!=', 0)
            ->get();

        return [
            'session'              => $session,
            'time_limit'           => $timeLimitMinutes,
            'total_questions'      => $totalQuestions,
            'questions'            => $questions,
            'timeLeft'             => $timeLeft,
            'answered'             => $answeredQuestions,
            'answeredCount'        => $answeredQuestions->count(),
            'correctAnsweredCount' => $answeredQuestions->where('is_correct', 1)->count(),
        ];
    }

    public function saveAnswer(array $data): array
    {
        TestResult::where('test_session_id', $data['session_id'])
            ->where('question_id', $data['question_id'])
            ->update([
                'chosen_answer' => $data['chosen_answer'],
                'is_correct'    => $data['is_correct'],
            ]);

        return ['success' => true];
    }

    public function finishTest(array $data): array
    {
        $session = TestSession::find($data['session_id']);

        if (!$session) {
            return ['success' => false, 'message' => 'Sessiya topilmadi'];
        }

        // JS dan emas, bazadan hisoblaymiz
        $actualAnswered = TestResult::where('test_session_id', $session->id)
            ->where('chosen_answer', '!=', 0)
            ->count();

        $actualCorrect = TestResult::where('test_session_id', $session->id)
            ->where('chosen_answer', '!=', 0)
            ->where('is_correct', true)
            ->count();

        $session->update([
            'correct_count'   => $actualCorrect,
            'total_questions' => $actualAnswered,
            'status'          => 'completed',
            'completed_at'    => now(),
        ]);

        $xpEarned = $actualCorrect * 5;
        auth()->user()->increment('xp', $xpEarned);

        return [
            'success' => true,
            'xp'      => $xpEarned,
            'correct' => $actualCorrect,
            'total'   => $actualAnswered,
            'message' => 'Natija muvaffaqiyatli saqlandi!',
        ];
    }
}
