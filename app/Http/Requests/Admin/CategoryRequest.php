<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:categories,name',
            'order' => 'required|integer|min:1|unique:categories,order',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Category name is required.',
            'name.string' => 'Category name must be a string.',
            'name.max' => 'Category name cannot be longer than 255 characters.',
            'order.required' => 'Category order is required.',
            'order.integer' => 'Category order must be an integer.',
            'order.min' => 'Category order must be a positive integer.',
            'order.unique' => 'Category order must be unique.',
            'name.unique' => 'Category name must be unique.',
        ];
    }
}
