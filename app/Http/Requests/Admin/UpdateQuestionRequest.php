<?php

namespace App\Http\Requests\Admin;

use App\Models\Question;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'question_text' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
            'explanation' => ['nullable', 'string'],
//            'order_in_category' => ['required', 'integer', 'min:1'],
            'is_active' => ['boolean'],
            'correct_answer' => ['required', 'integer', 'min:1', 'max:6'],

            'answers' => ['required', 'array', 'min:2', 'max:6'],
            'answers.*.id' => ['nullable', 'exists:answers,id'],
            'answers.*.option_number' => ['required', 'integer', 'min:1', 'max:6'],
            'answers.*.answer_text' => ['required', 'string'],
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $categoryId = $this->input('category_id');

            if (!$categoryId) return;

            $count = Question::where('category_id', $categoryId)->count();

            if ($count >= 10) {
                $validator->errors()->add(
                    'category_id',
                    "Ushbu Kategoriyada {$count} - ta savol mavjud. Boshqa Kategoriya tanlang yoki yangisini yarating!"
                );
            }
        });

    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Kategoriyani tanlang.',
            'question_text.required' => 'Savol matni kiritilishi shart.',
//            'order_in_category.required' => 'Tartib raqamini kiriting.',
            'answers.required' => 'Kamida 2 ta javob variantini kiriting.',
            'answers.*.answer_text.required' => 'Barcha javob variantlarini to\'ldiring.',
            'correct_answer.required' => 'To\'g\'ri javobni belgilang.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
