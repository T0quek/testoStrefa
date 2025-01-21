<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
//        dd($request);
        $token = $request->input('g-recaptcha-response');

        if (!$token) {
            return redirect()->back()->withErrors(['error' => 'Brak tokenu reCAPTCHA. Odśwież stronę i spróbuj ponownie']);
        }

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $token,
            'remoteip' => $request->ip(),
        ]);

        $recaptcha = $response->json();

        if (!$recaptcha['success'] || $recaptcha['score'] < 0.5) {
            return redirect()->back()->withErrors(['error' => 'Nieudana weryfikacja reCAPTCHA. Odśwież stronę i spróbuj ponownie']);
        }

        return $next($request);
    }
}
