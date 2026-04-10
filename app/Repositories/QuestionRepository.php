<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;

class QuestionRepository implements QuestionRepositoryInterface
{


    public function getQuestionsByCategoryId(int $categoryId): \Illuminate\Support\Collection
    {
        return Question::query()
            ->select([
                'id',
                'category_id',
                'question_text',
                'image_url',
            ])
            ->where('category_id', $categoryId)
            ->with([
                'answers' => function ($query) {
                    $query->select([
                        'id',
                        'question_id',
                        'option_number',
                        'answer_text',
                    ]);
                }
            ])
            ->get();
    }
}
