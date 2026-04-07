<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('questions:import app{file}')]
#[Description('JSON fayldan savollarni PostgreSQL ga import qilish')]
class ImportQuestionsCommand extends Command
{
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $file = storage_path('data/' . $this->argument('file'));
        $data = json_decode(file_get_contents($file), true);
        //kategoriyani guruxlash
        $grouped = collect($data)->groupBy('question_category');

        foreach ($grouped as $categoryOrder => $questions) {
            $category = Category::firstOrCreate(
                ['order' => (int)$categoryOrder],
                ['name' => "{$categoryOrder}-variant"]
            );
            foreach ($questions as $q) {
                try {
                    $question = $category->questions()->create([
                        'question_text' => $q['question'],
                        'image_url' => $q['image_q'] ?? null,
                        'correct_answer' => $q['correct_answer'],
                        'explanation' => $q['correct_ans_alls'],
                        'order_in_category' => $q['id'],
                        'is_active' => $q['done'] ?? true,
                    ]);
                    foreach ($q['answers'] as $index => $text) {
                        $question->answers()->create([
                            'option_number' => $index + 1,
                            'answer_text' => $text,
                        ]);
                    }
                } catch (\Exception $e) {
                    $this->error("❌ Savol #{$q['id']} xato: " . $e->getMessage());
                }

            }
        }
        $this->info('Barcha savollar import qilindi');
    }
}
