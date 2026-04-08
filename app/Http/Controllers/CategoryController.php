<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(private readonly CategoryService $categoryService)
    {
    }

    public function index()
    {
        $categories = $this->categoryService->getAllCategories();

        return CategoryResource::collection($categories);
    }

    /*    public function show(int $id)
        {
            $category = $this->categoryService->getCategoryById($id);

            return response()->json([
                'data' => $category,
            ]);
        }*/
}
