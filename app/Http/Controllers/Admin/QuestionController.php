<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreQuestionRequest;
use App\Http\Requests\Admin\UpdateQuestionRequest;
use App\Models\Category;
use App\Models\Question;
use App\Services\Admin\QuestionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
    public function index(Request $request): View
    {
        $filters = $request->only(['category_id', 'search', 'status']);
        $questions = $this->questionService->getAllQuestions($filters);
        $categories = Category::orderBy('order')->get(['id', 'name']);

        return view('admin.question.index', compact('questions', 'categories', 'filters'));
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
    public function edit(Question $question): View
    {
        $question = $this->questionService->getQuestionForEdit($question->id);
        $categories = $this->questionService->getAllCategories();

        return view('admin.question.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question): RedirectResponse
    {
        $this->questionService->update($question, $request->validated());

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Savol muvaffaqiyatli yangilandi!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $this->questionService->delete($question);
        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Savol o\'chirildi!');
    }

    public function toggleActive(Question $question): RedirectResponse
    {
        $isActive = $this->questionService->toggleActive($question);
        $message = $isActive ? 'Savol faollashtirildi!' : 'Savol nofaollashtirildi!';

        return redirect()->back()->with('success', $message);
    }
}
