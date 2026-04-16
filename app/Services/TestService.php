<?php

namespace App\Services;

use App\Exceptions\ActiveTestException;
use App\Models\Category;
use App\Models\TestResult;
use App\Models\TestSession;
use App\Models\User;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\TestSessionStatus;
use App\TestSessionType;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

readonly class TestService
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
    )
    {
    }

    /**
     * @throws Throwable
     */
    public function submitAnswer(User $user, int $sessionId, array $data): array
    {
        $session = TestSession::with('results')->findOrFail($sessionId);

        if ($session->user_id !== $user->id) {
            abort(403, 'Bu sessiya sizga tegishli emas');
        }
        if ($session->status !== TestSessionStatus::IN_PROGRESS) {
            abort(422, 'Bu test allaqachon yakunlangan');
        }

        $testResult = $session->results
            ->firstWhere('question_id', $data['question_id']);

        if (!$testResult) {
            abort(422, 'Bu savol ushbu sesiyaga tegishli emas');
        }

        if (!is_null($testResult->chosen_answer)) {
            abort(422, 'Bu savolga allaqachon javob berilgan.');
        }

        $question = $testResult->question()->with('answers')->firstOrFail();
        $isCorrect = $question->correct_answer === (int)$data['chosen_answer'];

        DB::transaction(function () use ($session, $testResult, $data, $isCorrect) {
            $testResult->update([
                'chosen_answer' => $data['chosen_answer'],
                'is_correct' => $isCorrect,
            ]);
            if ($isCorrect) {
                $session->increment('correct_count');
            }
            $answeredCount = $session->results()
                ->whereNotNull('chosen_answer')
                ->count();

            if ($answeredCount === $session->total_questions) {
                $session->update([
                    'status' => TestSessionStatus::COMPLETED,
                    'completed_at' => now(),
                ]);
            }
        });
        $session->refresh();

        $answeredCount = $session->results()
            ->whereNotNull('chosen_answer')
            ->count();

        $correctAnswer = $question->answers
            ->firstWhere('option_number', $question->correct_answer);

        return [
            'is_correct' => $isCorrect,
            'correct_answer' => [
                'option_number' => $question->correct_answer,
                'answer_text' => $correctAnswer?->answer_text,
            ],
            'explanation' => $question->explanation,
            'progress' => [
                'answered' => $answeredCount,
                'correct' => $session->correct_count,
                'wrong' => $answeredCount - $session->correct_count,
                'remaining' => $session->total_questions - $answeredCount,
            ],
            'session_completed' => $session->status === TestSessionStatus::COMPLETED,
            'session' => $session->status === TestSessionStatus::COMPLETED ? $session : null,
        ];
    }

    /**
     * @throws Throwable
     */
    public function startRandomTest(User $user)
    {
        $this->checkActiveSession($user->id);

        return DB::transaction(function () use ($user) {
            $questions = $this->questionRepository->getRandomTest();

            $session = TestSession::create([
                'user_id' => $user->id,
                'category_id' => null,
                'type' => TestSessionType::RANDOM,
                'status' => TestSessionStatus::IN_PROGRESS,
                'total_questions' => $questions->count(),
            ]);

            $records = $questions->map(fn($question) => [
                'test_session_id' => $session->id,
                'question_id' => $question->id,
                'chosen_answer' => null,
                'is_correct' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray();

            TestResult::insert($records);

            return [
                'session' => $session,
                'questions' => $questions,
            ];
        });
    }

    /**
     * @throws ActiveTestException
     * @throws Throwable
     */
    public function startCategoryTest(User $user, int $categoryId): array
    {
        Category::findOrFail($categoryId);

        $this->checkActiveSession($user->id);
        return DB::transaction(function () use ($user, $categoryId) {
            $questions = $this->questionRepository->getQuestionsByCategoryId($categoryId);

            $session = $this->createSession($user->id, [
                'category_id' => $categoryId,
                'type' => TestSessionType::CATEGORY,
//                'status' => TestSessionStatus::IN_PROGRESS,
            ], $questions->count());

            $this->createTestResults($session->id, $questions);
            return [
                'session' => $session,
                'questions' => $questions,
            ];
        });
    }

    private function createSession(int $userId, array $extra, int $total): TestSession
    {
        return TestSession::create([
            'user_id' => $userId,
            'status' => TestSessionStatus::IN_PROGRESS,
            'total_questions' => $total,
            ...$extra,
        ]);
    }

    private function createTestResults(int $sessionId, Collection $questions): void
    {
        $records = $questions->map(fn($question) => [
            'test_session_id' => $sessionId,
            'question_id' => $question->id,
            'chosen_answer' => null,
            'is_correct' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();
        TestResult::insert($records);
    }

    /**
     * @throws ActiveTestException
     */
    private function checkActiveSession(int $id): void
    {
        $hasActive = TestSession::where('user_id', $id)
            ->where('status', TestSessionStatus::IN_PROGRESS)
            ->exists();
        if ($hasActive) {
            throw new ActiveTestException();
        }
    }

}
