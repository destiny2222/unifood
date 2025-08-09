<?php

namespace App\Actions\Fortify;

use App\Traits\Recaptcha;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AttemptToAuthenticate
{
    use Recaptcha;

    public function __invoke(Request $request)
    {
        if (!$this->validateRecaptcha($request)) {
            throw ValidationException::withMessages([
                'g-recaptcha-response' => ['Invalid reCAPTCHA response.'],
            ]);
        }
    }
}
