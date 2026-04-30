<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\TestSession;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    /**
     * Test tanlash bosh sahifasi (Variant yoki Random tanlash uchun)
     */
    public function index()
    {
        return view('user.tests.index');
    }

    /**
     * Barcha 111 ta kategoriyani chiqarish
     */
    public function categories()
    {
    // Kategoriyalarni savollar soni bilan olish
    $categories = Category::withCount('questions')->orderBy('id', 'asc')->get();
    
    return view('user.tests.categories', compact('categories'));
    }

    /**
     * Kategoriya (Variant) bo'yicha testni boshlash
     * Har bir kategoriyadan ketma-ket 10 ta savol
     */
    public function startCategory($id)
    {
        $category = \App\Models\Category::findOrFail($id);
        
        // Savollarni javoblari bilan birga yuklaymiz
        $questions = \App\Models\Question::with(['answers' => function($query) {
                $query->orderBy('option_number', 'asc');
            }])
            ->where('category_id', $id)
            ->take(10) // Siz aytgandek 10 ta
            ->get();

        return view('user.tests.show', [
            'questions' => $questions,
            'title' => $category->name,
            'type' => 'category'
        ]);
    }

    /**
     * Tasodifiy (Random) testni boshlash
     * Hammasini ichidan 10 ta aralash savol
     */
    public function startRandom()
    {
        $questions = Question::with('answers')
            ->inRandomOrder()
            ->take(10)
            ->get();

        return view('user.tests.show', [
            'questions' => $questions,
            'title' => "Tasodifiy imtihon testi",
            'type' => 'random'
        ]);
    }
    // Controller ichiga qo'shing:
   

    public function saveResult(Request $request)
    {
        DB::transaction(function () use ($request) {
            // Testni saqlash
            \App\Models\TestSession::create([
                'user_id' => auth()->id(),
                'category_id' => $request->category_id ?: null,
                'type' => $request->type,
                'total_questions' => $request->total,
                'correct_count' => $request->correct,
                'status' => 'completed',
                'started_at' => now(), 
                'completed_at' => now(),
            ]);

            // Faqat XP ni oshirish
            $user = auth()->user();
            $user->xp += $request->correct * 10; // To'g'ri javob * 10 XP
            $user->save();
        });

        return response()->json(['status' => 'saved']);
    }

    public function statistics()
    {
        $user = auth()->user();
        
        // get() o'rniga paginate(10) ishlatamiz
        $sessions = \App\Models\TestSession::where('user_id', $user->id)
                    ->with('category')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10); // 10 tadan sahifalash

        // Umumiy statistika (hisob-kitoblar o'zgarmaydi)
        $allSessions = \App\Models\TestSession::where('user_id', $user->id)->get();
        $totalAttempts = $allSessions->count();
        $totalCorrect = $allSessions->sum('correct_count');
        $totalQuestions = $allSessions->sum('total_questions');
        $accuracy = $totalQuestions > 0 ? round(($totalCorrect / $totalQuestions) * 100) : 0;

        return view('user.statistics', compact('sessions', 'totalAttempts', 'accuracy', 'totalCorrect'));
    }
}