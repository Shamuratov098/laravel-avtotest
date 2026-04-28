<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Services\Admin\QuestionService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class QuestionController extends Controller
{

    public function __construct(
        private readonly QuestionService $questionService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $questions = $this->questionService->getAllQuestions();
        return view('admin.question.index', compact('questions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = $this->questionService->getAllCategories();
        return view('admin.question.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuestionRequest $request)
    {
        $this->questionService->store($request->validated());
        return redirect()->route('admin.questions.index')->with('success', 'Savol muvaffaqiyatli qo\'shildi!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
