<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use Exception;
use App\Services\QuestionService;

class QuestionController extends Controller
{
    public function __construct(
        private readonly QuestionService $questionService,
    )
    {
    }

    /**
     * @throws Exception
     */
    public function show(int $id)
    {
        $questions = $this->questionService->getQuestionByCategoryId($id);
        return QuestionResource::collection($questions);
    }
}
