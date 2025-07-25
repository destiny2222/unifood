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
            // 'background_image'=>['nullable', 'image'], 
            // 'image_one'=>['nullable', 'image', 'mimes:png,jpg,jpeg,avif,webp'],
            // 'image_two'=>['nullable', 'image', 'mimes:png,jpg,jpeg,avif,webp'], 
            'short_title'=>['required', 'string'],
            'long_title'=>['required', 'string'],
            'status'=>['required', 'boolean'], 
            'description'=>['nullable', 'string'] ,
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

    /**
     * Get custom messages for the validation rules.
     */
    public function messages(): array
    {
        return [
            // 'background_image.image' => 'The background image must be an image file.',
            // 'background_image.mimes' => 'The background image must be a file of type:png, jpg, jpeg.',
            // 'image_two.image' => 'The image two must be an image file.',
            // 'image_two.mimes' => 'The image two must be a file of type:png, jpg, jpeg.',
            // 'image_one.image' => 'The image one must be an image file.',
            // 'image_one.mimes' => 'The image one must be a file of type:png, jpg, jpeg.',
            'short_title.required' => 'The short title is required.',
            'long_title.required' => 'The long title is required.',
            'status.required' => 'The status is required.',
            'description.required' => 'The description is required.',
            'title_one.required' => 'The title one is required.',
            'icon_one.required' => 'The icon one is required.',
            'title_two.required' => 'The title two is required.',
            'icon_two.required' => 'The icon two is required.',
            'title_three.required' => 'The title three is required.',
            'icon_three.required' => 'The icon three is required.',
            'title_four.required' => 'The title four is required.',
            'icon_four.required' => 'The icon four is required.',
        ];
    }
}
