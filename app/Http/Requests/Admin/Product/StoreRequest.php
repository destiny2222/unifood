<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'availability' => ['nullable', 'string', 'max:100'],
            'featured' => ['nullable', 'string', 'max:100'],
            'badge' => ['nullable', 'string', 'max:100'],
            'price' => ['nullable', 'numeric', 'min:0.01'],
            'discount' => ['nullable', 'numeric', 'min:0', 'max:100'],
            // 'images' => ['nullable', 'array'],
            // 'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status' => ['nullable', 'boolean'],
            'today_special' => ['nullable', 'boolean'],
            'category_id' => ['required', 'exists:categories,id'],
            'description' => ['required', 'string'],
            'slug' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            // 'weight.required' => 'The weight is required.',
            // 'weight.numeric' => 'The weight must be a number.',
            // 'weight.min' => 'The weight must be at least 0.01.',
            // 'weight_unit.required' => 'The weight unit is required.',
            // 'weight_unit.in' => 'The weight unit must be either kg or g.',
            // 'price.required' => 'The price is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.01.',
            'discount.numeric' => 'The discount must be a number.',
            'discount.max' => 'The discount may not be greater than 100.',
            // 'images.*.image' => 'Each file must be an image.',
            // 'images.*.mimes' => 'Each image must be a file of type: jpeg, png, jpg, gif, svg.',
            // 'images.*.max' => 'Each image may not be greater than 2MB.',
        ];
    }
}