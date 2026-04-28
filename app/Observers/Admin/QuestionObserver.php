<?php

namespace App\Observers\Admin;

use App\Models\Category;
use App\Models\Question;

class QuestionObserver
{
    /**
     * Handle the Question "created" event.
     */
    public function created(Question $question): void
    {
        $this->updateTotalQuestions($question->category_id);
    }

    /**
     * Handle the Question "updated" event.
     */
    public function updated(Question $question): void
    {
        if ($question->wasChanged('category_id')) {
            $this->updateTotalQuestions($question->getOriginal('category_id'));
            $this->updateTotalQuestions($question->category_id);
        }
    }

    /**
     * Handle the Question "deleted" event.
     */
    public function deleted(Question $question): void
    {
        $this->updateTotalQuestions($question->category_id);
    }

    /**
     * Handle the Question "restored" event.
     */
    public function restored(Question $question): void
    {
        //
    }

    /**
     * Handle the Question "force deleted" event.
     */
    public function forceDeleted(Question $question): void
    {
        //
    }

    private function updateTotalQuestions(int $category_id): void
    {
        $count = Question::where('category_id', $category_id)->count();

        Category::where('id', $category_id)
            ->update(['total_questions' => $count]);
    }
}
