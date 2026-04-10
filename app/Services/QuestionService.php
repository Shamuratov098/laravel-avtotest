<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Question;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

readonly class QuestionService
{
    /*  public function __construct(private QuestionRepository $questionRepository)
      {

      }*/

    /**
     * @throws Exception
     */
    public function getQuestionByCategoryId(int $id): Collection
    {
        Category::findOrFail($id);

        return Question::query()
            ->select([
                'id',
                'category_id',
                'question_text',
                'image_url',
            ])
            ->where('category_id', $id)
            ->with(['answers' => function ($query) {
                $query->select([
                    'id',
                    'question_id',
                    'option_number',
                    'answer_text',
                ]);
            }])
            ->get();
    }
}
