<?php

namespace App\Http\Requests\Admin\Testimonial;

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
            'name'=>['required', 'string'],
            'designation'=>['required', 'string'],
            'description'=>['required'],
            'status'=>['string', 'boolean'],
            'existing_image'=>['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'product_image'=>['nullable', 'image', 'mimes:png,jpg,jpeg'],
        ];
    }
}
