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
            'title'=>['required','string'],
            'availability'=>['nullable', 'string'],
            'featured'=>['nullable', 'string'],
            'badge'=>['nullable', 'string'],
            'weight'=>['required','numeric'],
            'weight_unit'=>['required', 'in:g,kg'],
            'price'=>['required','numeric'],
            'discount'=>['nullable','numeric'],
            // 'images' => ['array', 'nullable'],
            // 'images.*' => ['image', 'nullable', 'mimes:jpeg,png,jpg,gif,svg'],
            'status'=>['nullable', 'boolean'],
            'today_special'=>['nullable', 'boolean'],
        ];
    }
}
