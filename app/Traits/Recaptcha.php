<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait Recaptcha
{
    public function validateRecaptcha($request)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('NOCAPTCHA_SECRET'),
            'response' => $request->input('g-recaptcha-response'),
        ]);

        return $response->json('success');
    }
}
