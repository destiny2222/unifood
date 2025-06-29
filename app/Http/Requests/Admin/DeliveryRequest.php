<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
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
            'area_name'=>['required', 'string'],
            'minimum_delivery_time'=>['required', 'integer'],
            'status'=>['required', 'boolean'],
            'maximum_delivery_time'=>['required', 'integer'],
            'delivery_fee'=>['required', 'numeric'],
        ];
    }
}
