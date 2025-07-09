<?php

namespace App\Http\Requests\Admin\WhyChoose;

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
            'background_image'=>['nullable', 'image', 'mimes:png,jpg,jpeg'], 
            'image_one'=>['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'image_two'=>['nullable', 'image', 'mimes:png,jpg,jpeg'], 
            'short_title'=>['required', 'string'],
            'long_title'=>['required', 'string'],
            'status'=>['required', 'boolean'], 
            'description'=>['required', 'string'] ,
            'title_one'=>['required', 'string'],
            'icon_one'=>['required', 'string'],
            'title_two'=>['required', 'string'],
            'icon_two'=>['required', 'string'],
            'title_three'=>['required', 'string'],
            'icon_three'=>['required', 'string'],
            'title_four'=>['required', 'string'],
            'icon_four'=>['required', 'string'],
        ];
    }
}
