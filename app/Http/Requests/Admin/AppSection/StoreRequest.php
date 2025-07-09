<?php

namespace App\Http\Requests\Admin\AppSection;

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
            'play_store_link'=>['required', 'string'], 
            'app_store_link'=>['required', 'string'], 
            'title'=>['required', 'string'], 
            'description'=>['required', 'string'], 
            'background_image'=>['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'app_image'=>['nullable', 'image', 'mimes:png,jpg,jpeg'],
        ];
    }
}
