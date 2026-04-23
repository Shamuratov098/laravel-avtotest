<?php

namespace App\Services\Admin;

use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use LaravelIdea\Helper\App\Models\_IH_Category_C;

class CategoryService
{
    public function getAllCategories(): _IH_Category_C|array|LengthAwarePaginator
    {
        return Category::orderBy('order', 'asc')->paginate(15);

    }

    /**
     * @throws Exception
     */
    public function createCategory(CategoryCreateRequest $request)
    {
        $validated = $request->validated();
        $exist = Category::where('name', $validated['name'])->first();
        if ($exist) {
            throw  new Exception("Category already exist");
        }
        return Category::create([
            'name' => $validated['name'],
            'order' => $validated['order'],
            'total_questions' => 0
        ]);
    }

    public function update(CategoryUpdateRequest $request, Category $category): Category
    {
        $validated = $request->validated();
        $category->update($validated);
        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

}
