<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryRepository implements CategoryRepositoryInterface
{

    public function getAll(): \Illuminate\Support\Collection
    {
        return Category::query()
            ->select(['id', 'name', 'total_questions'])
            ->orderBy('id', 'ASC')
            ->get();
    }

    /**
     * Berilgan ID ga mos kategoriyani qaytaradi.
     *
     * @throws ModelNotFoundException — ID topilmasa avtomatik exception chiqadi
     */
    public function findById(int $id): Category
    {
        return Category::query()->findOrFail($id);
    }
}
