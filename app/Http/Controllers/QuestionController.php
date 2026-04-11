<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use Exception;
use App\Services\QuestionService;
use Illuminate\Http\Resources\Json\ResourceCollection;

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
    public function getQuestionsByCategory(int $id)
    {
        $questions = $this->questionService->getQuestionByCategoryId($id);
        return QuestionResource::collection($questions);
    }

    public function getRandomQuestions(): ResourceCollection
    {
        $questions = $this->questionService->getRandomTest();
        return QuestionResource::collection($questions);
    }
}
