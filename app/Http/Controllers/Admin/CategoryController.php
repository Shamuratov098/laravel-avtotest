<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryCreateRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService
    )
    {

    }

    public function index(): View
    {
        $categories = $this->categoryService->getAllCategories();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('admin.category.create');
    }

    /**
     * @throws Exception
     */
    public function store(CategoryCreateRequest $request)
    {
        $this->categoryService->createCategory($request);
        return $this->success('admin.categories.index', 'Kategoriya muvaffaqiyatli yaratildi!');
    }

    public function edit(Category $category): View
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category): RedirectResponse
    {
        $this->categoryService->update($request, $category);
        return $this->success('admin.categories.index', 'Kategoriya muvaffaqiyatli yangilandi!');

    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->total_questions > 0) {
            return $this->errorBack('Bu kategoriyada test savollar mavjud. Avval ularni o\'chiring yoki boshqa kategoriyaga ko\'chiring.');
        }

        $this->categoryService->delete($category);

        return $this->successBack('Kategoriya muvaffaqiyatli o\'chirildi!');
    }
}
