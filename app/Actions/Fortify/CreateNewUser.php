<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Traits\Recaptcha;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, Recaptcha;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password'=> ['required', 'confirmed', Password::min(8)->numbers()->letters()->mixedCase()->symbols()],
            'g-recaptcha-response' => ['required', 'string'],
        ])->validate();

        if (!$this->validateRecaptcha(request())) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['Invalid reCAPTCHA response.'],
            ]);
        }

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
