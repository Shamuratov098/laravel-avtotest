<?php

namespace App\Repositories;

use App\Models\Question;
use App\Repositories\Contracts\QuestionRepositoryInterface;
use Illuminate\Support\Collection;

class QuestionRepository implements QuestionRepositoryInterface
{


    public function getQuestionsByCategoryId(int $categoryId): Collection
    {
        return Question::query()
            ->select([
                'id',
                'category_id',
                'question_text',
                'image_url',
                /*'correct_answer',
                'explanation'*/
            ])
            ->where('category_id', $categoryId)
            ->where('is_active', true)
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
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }

    public function getRandomTest(): Collection
    {
        return Question::query()
            ->select([
                'id',
                'category_id',
                'question_text',
                'image_url',
               /* 'correct_answer',
                'explanation'*/
            ])
            ->where('is_active', true)
            ->with(['answers' => fn($q) => $q->select([
                'question_id',
                'option_number',
                'answer_text',
            ])])
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }
}
