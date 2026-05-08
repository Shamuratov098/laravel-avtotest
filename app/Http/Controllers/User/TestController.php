<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Web\TestService;
use App\Http\Requests\Web\SaveTestResultRequest;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Question;
// Agar kategoriyalar ro'yxati kerak bo'lsa Category modelini chaqirish kerak bo'ladi
// use App\Models\Category; 

class TestController extends Controller
{
    protected $testService;

    public function __construct(TestService $testService)
    {
        $this->testService = $testService;
    }

    /**
     * Test boshlash menyusi (Kategoriyalar yoki Random tanlash sahifasi)
     */
    public function index()
    {
        $categories = Category::all();
        return view('user.tests.index', compact('categories'));
    }

    /**
     * Aralash (Random) testni boshlash
     * 20 ta savol, 30 daqiqa
     */
    public function startCategory($id) // <--- DIQQAT: (Category $category) o'rniga ($id) yozdik
    {
        // Bazadan kategoriyani o'zimiz aniq topib olamiz:
        $category = \App\Models\Category::findOrFail($id);

        // Hamma narsa Service'dan tayyor keladi
        $testData = $this->testService->startTest('category', $category->id);

        $questions = $testData['questions'];
        $timeLeft = $testData['timeLeft'];
        $title = $category->name; // Endi bu aniq ishlashiga kafilman!
        $type = 'category';

        return view('user.tests.show', compact('testData', 'questions', 'title', 'type', 'timeLeft'));
    }

    public function startRandom()
    {
        // Hamma narsa Service'dan tayyor keladi
        $testData = $this->testService->startTest('random');
        
        $questions = $testData['questions'];
        $timeLeft  = $testData['timeLeft']; // Service hisoblab bergan vaqt
        $title     = "Aralash imtihon";
        $type      = 'random';

        return view('user.tests.show', compact('testData', 'questions', 'title', 'type', 'timeLeft'));
    }

    /**
     * Kategoriyalar ro'yxatini ko'rsatish
     */
    public function categories()
    {
        // Bazadan barcha kategoriyalarni olamiz (agar active/inactive kabi statuslari bo'lsa where ishlatasiz)
        $categories = Category::all(); 
        
        // Blade faylga jo'natamiz
        return view('user.tests.categories', compact('categories'));
    }

    /**
     * Test yakunlanganda (Vaqt tugaganda yoki foydalanuvchi tugatganda)
     */
    public function saveResult(\Illuminate\Http\Request $request)
    {
        // Hamma qora mehnatni Service bajaradi
        $result = $this->testService->finishTest($request->all());

        return response()->json($result);
    }
}