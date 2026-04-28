<?php

namespace App\Http\Requests\Admin;

use App\Models\Question;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'image_url' => ['nullable', 'string', 'max:500'],
            'explanation' => ['nullable', 'string'],
            'is_active' => ['boolean'],
            'correct_answer' => ['required', 'integer', 'min:1', 'max:6'],

            'answers' => ['required', 'array', 'min:2', 'max:6'],
            'answers.*.option_number' => ['required', 'integer'],
            'answers.*.answer_text' => ['required', 'string', 'max:500'],

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
            'category_id.required' => 'Kategoriya maydoni majburiy.',
            'category_id.exists' => 'Tanlangan kategoriya mavjud emas.',
            'question_text.required' => 'Savol matni majburiy.',
            'answers.required' => 'Javob variantlari majburiy.',
            'answers.min' => 'Kamida 2 ta javob varianti bo\'lishi kerak.',
            'answers.*.answer_text.required' => 'Javob matni majburiy.',
            'correct_answer.required' => 'To\'g\'ri javob belgilanmagan.',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
