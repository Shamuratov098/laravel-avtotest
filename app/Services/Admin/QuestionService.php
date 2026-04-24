<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class QuestionService
{
    public function getAllQuestions(): LengthAwarePaginator
    {
        return Question::query()
            ->select([
                'id',
                'order_in_category',
                'question_text',
                'image_url',
                'category_id',
                'correct_answer',
                'is_active'
            ])
            ->with([
                'category:id,name',
                'answers' => fn($q) => $q->select([
                    'id',
                    'question_id',
                    'option_number',
                    'answer_text',
                ])
                    ->orderBy('option_number'),
            ])
            ->orderBy('order_in_category')
            ->paginate(20);
    }

    public function getQuestionForEdit(int $id): Question
    {
        return Question::with([
            'answers' => fn($q) => $q->orderBy('option_number'),
        ])->findOrFail($id);
    }

    public function getAllCategories(): Collection
    {
        return Category::query()
            ->select([
                'id',
                'name',
            ])
            ->orderBy('name')
            ->get();
    }
}
