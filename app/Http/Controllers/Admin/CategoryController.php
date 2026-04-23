<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\CategoryRequest;
use App\Services\Admin\CategoryService;
use Exception;
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
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('category.create');
    }

    /**
     * @throws Exception
     */
    public function store(CategoryRequest $request)
    {
        $this->categoryService->createCategory($request);
        return $this->success('admin.categories.index', 'Kategoriya muvafaqiyatli yaratildi');
    }
}
