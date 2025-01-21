<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class loginController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()) return redirect()->route('panel.index');
        return view('public.login');
    }

    // Obsługa logowania
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        // Próba logowania
        if (Auth::attempt($credentials)) {
            if(Auth::user()->status !== 1) {
                Auth::logout();

                return redirect()->back()->withErrors([
                    'email' => 'Twoje konto jest nieaktywne lub zablokowane.'
                ]);
            }

            $request->session()->regenerate();

            return redirect()->route('panel.index')->with('success', 'Zalogowano pomyślnie.');
        }

        return back()->withErrors([
            'email' => 'Podane dane logowania są nieprawidłowe.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route("login.index")->with('success', 'Wylogowano pomyślnie.');
    }
}
