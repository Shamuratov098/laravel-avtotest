<?php

namespace App\Services;

use App\Exceptions\ActiveTestException;
use App\Models\TestResult;
use App\Models\TestSession;
use App\Models\User;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use App\TestSessionStatus;
use App\TestSessionType;
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
