<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Question;
use Exception;
use http\Message;
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
                'total_questions'
            ])
            ->withCount('questions')
            ->orderBy('order', 'desc')
            ->get();
    }

    public function store(array $data): Question
    {
        $nextOption = Question::max('order_in_category') + 1;
        $question = Question::create([
            'category_id' => $data['category_id'],
            'question_text' => $data['question_text'],
            'image_url' => $data['image_url'] ?? null,
            'correct_answer' => $data['correct_answer'],
            'explanation' => $data['explanation'] ?? null,
            'order_in_category' => $nextOption,
            'is_active' => $data['is_active'] ?? true,
        ]);
        $this->syncAnswers($question, $data['answers']);

        return $question;
    }


    private function syncAnswers(Question $question, array $answers): void
    {
        foreach ($answers as $answer) {
            $question->answers()->create([
                'option_number' => $answer['option_number'],
                'answer_text' => $answer['answer_text'],
            ]);
        }

    }
}
