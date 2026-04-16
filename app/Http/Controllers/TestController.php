<?php

namespace App\Http\Controllers;

use App\Exceptions\ActiveTestException;
use App\Http\Requests\Test\AnswerTestRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\SessionResultResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\TestService;
use Throwable;

class TestController extends Controller
{
    public function __construct(
        private readonly TestService $testService,
    )
    {

    }

    /**
     * @throws Throwable
     */
    public function startRandomTest(Request $request): JsonResponse
    {
        $result = $this->testService->startRandomTest($request->user());
        return response()->json([
            'session' => $result['session'],
            'questions' => QuestionResource::collection($result['questions']),
        ], 201);
    }

    /**
     * @throws Throwable
     * @throws ActiveTestException
     */
    public function startCategory(Request $request, int $categoryId): JsonResponse
    {
        $result = $this->testService->startCategoryTest($request->user(), $categoryId);
        return response()->json([
            'session' => $result['session'],
            'questions' => QuestionResource::collection($result['questions']),
        ], 201);
    }

    /**
     * @throws Throwable
     */
    public function checkAnswer(AnswerTestRequest $request, int $sessionId): JsonResponse
    {
        $result = $this->testService->submitAnswer(
            $request->user(),
            $sessionId,
            $request->validated(),
        );
        return response()->json([
            'is_correct' => $result['is_correct'],
            'correct_answer' => $result['correct_answer'],
            'explanation' => $result['explanation'],
            'progress' => $result['progress'],
            'session_completed' => $result['session_completed'],
            'result' => $result['session_completed']
                ? new SessionResultResource($result['session'])
                : null,
        ], 200);
    }
}
