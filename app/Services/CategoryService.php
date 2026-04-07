<?php

namespace App\Services;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Collection;

readonly class CategoryService
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    )
    {
    }

    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    /* public function getCategoryById(int $id): Category
     {
         return $this->categoryRepository->findById($id);
     }*/
}
