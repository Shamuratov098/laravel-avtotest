<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface QuestionRepositoryInterface
{
    public function getQuestionsByCategoryId(int $categoryId): Collection;
}
