<?php

namespace App\Http\Requests\Admin\AboutPage;

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
            'short_title'=>['required', 'string'],
            'long_title'=>['required', 'string'],
            'description'=>['required', 'string'],
            'image'=>['nullable', 'image', 'mimes:png,jpg,jpeg'],
        ];
    }
}
