<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
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
}
