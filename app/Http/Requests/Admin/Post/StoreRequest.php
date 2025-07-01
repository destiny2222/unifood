<?php

namespace App\Http\Requests\Admin\Post;

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
            'description'=>['required','string'],
            'category_id'=>['required','integer'],
            'status'=>['required','integer'],
            'show_homepage'=>['required','integer'],
            // 'image'=>['required','image','mimes:jpg,jpeg,png'],
        ];
    }
}
