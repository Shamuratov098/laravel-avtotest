<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Web\TestService;
use App\Models\Category;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __construct(protected TestService $testService) {}

    /**
     * Test boshlash menyusi
     */
    public function index()
    {
        $categories = Category::whereHas('questions', function($q) {
        $q->where('is_active', true);
        })->get();

    return view('user.tests.index', compact('categories'));
    }

    /**
     * Kategoriyalar ro'yxati
     */
    public function categories()
    {
        $categories = Category::all();
        return view('user.tests.categories', compact('categories'));
    }

    /**
     * Aralash (Random) test — 20 ta savol, 30 daqiqa
     */
    public function startRandom()
    {
        $testData = $this->testService->startTest('random');

        return view('user.tests.show', [
            'testData'             => $testData,
            'questions'            => $testData['questions'],
            'timeLeft'             => $testData['timeLeft'],
            'answeredCount'        => $testData['answeredCount'],
            'correctAnsweredCount' => $testData['correctAnsweredCount'],
            'title'                => 'Aralash imtihon',
            'type'                 => 'random',
        ]);
    }

    /**
     * Kategoriya testi — 10 ta savol, 15 daqiqa
     */
    public function startCategory($id)
    {
        $category = Category::findOrFail($id);
        $testData = $this->testService->startTest('category', $category->id);

        return view('user.tests.show', [
            'testData'             => $testData,
            'questions'            => $testData['questions'],
            'timeLeft'             => $testData['timeLeft'],
            'answeredCount'        => $testData['answeredCount'],
            'correctAnsweredCount' => $testData['correctAnsweredCount'],
            'title'                => $category->name,
            'type'                 => 'category',
        ]);
    }

    /**
     * Har bir javobni darhol saqlash (AJAX)
     */
    public function saveSingleAnswer(Request $request)
    {
        $result = $this->testService->saveAnswer($request->only([
            'session_id',
            'question_id',
            'chosen_answer',
            'is_correct',
        ]));

        return response()->json($result);
    }

    /**
     * Test yakunida umumiy natijani saqlash (AJAX)
     */
    public function saveResult(Request $request)
    {
        $result = $this->testService->finishTest($request->only([
            'session_id',
            'correct',
            'total',
            'type',
        ]));

        return response()->json($result);
    }
}