<?php

namespace App\Repositories\Contracts;

use Illuminate\Support\Collection;

interface QuestionRepositoryInterface
{
    /**
     * Berilgan kategoriyadan tasodifiy 10 ta aktiv savol qaytaradi.
     * (Kategoriya bo'yicha Test rejimi uchun)
     */
    public function getQuestionsByCategoryId(int $categoryId): Collection;

    /**
     * Barcha aktiv savollardan tasodifiy 10 tasini qaytaradi.
     * (Random Test rejimi uchun)
     */
    public function getRandomTest(): Collection;
}
