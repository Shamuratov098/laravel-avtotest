<?php

namespace App\Services\Admin;

use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class QuestionService
{
    public function getAllQuestions(array $filters = []): LengthAwarePaginator
    {
        $categoryId = $filters['category_id'] ?? null;
        $search = $filters['search'] ?? null;
        $status = $filters['status'] ?? null;

        return Question::query()
            ->select([
                'id',
                'order_in_category',
                'question_text',
                'image_url',
                'category_id',
                'correct_answer',
                'is_active',
                'created_at',
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
            ->when($categoryId, fn($q, $id) => $q->where('category_id', $id))
            ->when($search, fn($q, $s) => $q->where('question_text', 'like', "%{$s}%"))
            ->when($status === 'active', fn($q) => $q->where('is_active', true))
            ->when($status === 'inactive', fn($q) => $q->where('is_active', false))
            ->when(
                $categoryId,
                fn($q) => $q->orderBy('order_in_category'),
                fn($q) => $q->orderByDesc('created_at'),
            )
            ->paginate(20)
            ->withQueryString();
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

        $imagePath = null;
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $imagePath = $data['image']->store('questions', 'public');
        }

        $question = Question::create([
            'category_id' => $data['category_id'],
            'question_text' => $data['question_text'],
            'image_url' => $imagePath,
            'correct_answer' => $data['correct_answer'],
            'explanation' => $data['explanation'] ?? null,
            'order_in_category' => $nextOption,
            'is_active' => $data['is_active'] ?? true,
        ]);
        $this->syncAnswers($question, $data['answers']);

        return $question;
    }

    public function update(Question $question, array $data): Question
    {
        $imageUrl = $question->image_url;
        $hasNewFile = isset($data['image']) && $data['image'] instanceof UploadedFile;

        if (!empty($data['delete_image']) || $hasNewFile) {
            $this->deleteStoredImage($question->image_url);
            $imageUrl = null;
        }

        if ($hasNewFile) {
            $imageUrl = $data['image']->store('questions', 'public');
        }

        $question->update([
            'category_id' => $data['category_id'],
            'question_text' => $data['question_text'],
            'image_url' => $imageUrl,
            'correct_answer' => $data['correct_answer'],
            'explanation' => $data['explanation'] ?? null,
            'is_active' => $data['is_active'],
        ]);

        $question->answers()->delete();
        $this->syncAnswers($question, $data['answers']);

        return $question->fresh('answers');
    }

    public function delete(Question $question): void
    {
        $this->deleteStoredImage($question->image_url);
        $question->answers()->delete();
        $question->delete();
    }

    public function toggleActive(Question $question): bool
    {
        $question->update(['is_active' => !$question->is_active]);

        return $question->is_active;
    }

    // HELPERS
    private function syncAnswers(Question $question, array $answers): void
    {
        foreach ($answers as $answer) {
            $question->answers()->create([
                'option_number' => $answer['option_number'],
                'answer_text' => $answer['answer_text'],
            ]);
        }

    }

    private function deleteStoredImage(?string $value): void
    {
        if (empty($value)) {
            return;
        }

        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            return;
        }

        Storage::disk('public')->delete($value);
    }
}
