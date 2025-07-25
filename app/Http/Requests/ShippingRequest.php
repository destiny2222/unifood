<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingRequest extends FormRequest
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
            'first_name'=> ['required', 'string', 'max:255'],
            'last_name'=> ['required', 'string', 'max:255'],
            'email'=> ['required', 'string', 'email'],
            'phone_number'=> ['required'],
            'address'=> ['required'],
            'address_type'=> ['required'],
            // 'delivery_area_id'=> ['required'],
            // 'user_id'=>['required']
        ];
    }
}
