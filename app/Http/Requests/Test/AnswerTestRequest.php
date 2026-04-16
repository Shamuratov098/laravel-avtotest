<?php

namespace App\Http\Requests\Test;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class AnswerTestRequest extends FormRequest
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
            'question_id' => 'required|integer|exists:questions,id',
            'chosen_answer' => 'required|integer|between:1,4',
        ];
    }

    public function messages(): array
    {
        return [
            'question_id.required' => 'Question is required',
            'question_id.exists' => 'Question is not found',
            'question_id.integer' => 'Question is an integer',

            'chosen_answer.required' => 'Chosen Answer is required',
            'chosen_answer.integer' => 'Chosen Answer is not an integer',
            'chosen_answer.between' => 'Chosen Answer is not between 1 and 4',
        ];
    }
}
