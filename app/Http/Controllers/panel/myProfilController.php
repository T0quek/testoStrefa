<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Rules\NotInPolishWordlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class myProfilController extends Controller
{
    public function index() {
        $user = User::find(Auth::user()->id);
        return view('panel.myProfil', with(['user' => $user]));
    }

    public function updateName(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->input("name");
        $user->save();
        return redirect()->back()->with(["success"=>"Imię i nazwisko zmieniono pomyślnie!"]);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'old_password' => 'required',
            'password' => ['required', 'string', 'max:255', 'confirmed',
                Password::min(12)
                    ->uncompromised(),
                new NotInPolishWordlist(),
            ],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->input('old_password'), $user->password)) {
            return back()->withErrors(['old_password' => 'Podane stare hasło jest nieprawidłowe.']);
        }

        $user->password = Hash::make($request->input('password'));
        $user->save();

        return redirect()->back()->with(['success', 'Hasło zostało pomyślnie zmienione.']);
    }
}
