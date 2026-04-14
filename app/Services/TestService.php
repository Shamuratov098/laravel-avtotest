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
