<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PasswordResetToken;
use App\Models\User;
use App\Rules\NotInPolishWordlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class resetPasswordController extends Controller
{
    public function send(Request $request) {
        $request->validate([
            'forgotEmail' => 'required|string|email',
        ]);

        $user = User::where('email', $request->input('forgotEmail'))->first();
        if($user) {
            $user->password = Hash::make(Str::random(64));
            $user->save();

            $token_plain = Str::random(64);
            PasswordResetToken::where("user_id", $user->id)->delete();
            $token = new PasswordResetToken();
            $token->token = Hash::make($token_plain);
            $token->user_id = $user->id;
            $token->save();


            Mail::send('email.reset-password', ['token' => $token_plain, 'name'=>$user->name], function ($message) use ($request) {
                $message->to($request->input('forgotEmail'));
                $message->subject('testoStrefa.pl - Resetowanie Hasła');
            });
        }
        return redirect()->back()->with(['success'=>"Jeżeli adres email został podany prawidłowo, został wysłany na niego link do zresetowania hasła."]);

    }

    public function index($token)
    {
        $tokenQuery = PasswordResetToken::where("token", "!=", null)->get(); // Pobieramy wszystkie wpisy z tokenami
        $validToken = $tokenQuery->first(function ($item) use ($token) {
            return Hash::check($token, $item->token);
        });

        if ($validToken) {
            $user = User::find($validToken->user_id);
            if ($user->deleted) {
                return redirect()->route('login.index')->withError("Konto zostało usunięte i nie jest możliwa zmiana hasła.");
            }
            return view('public.resetPassword')->with('token', $token);
        }
        return redirect()->route('login.index')->withError("Link do resetowania hasła wygasł lub jest nieprawidłowy!");


    }

    public function reset(Request $request, $token)
    {
        $tokenQuery = PasswordResetToken::where("token", "!=", null)->get();

        $validToken = $tokenQuery->first(function ($item) use ($token) {
            return Hash::check($token, $item->token);
        });

        if ($validToken) {
            $user = User::find($validToken->user_id);
            if ($user->deleted) {
                return redirect()->route('login.index')->withError("Konto zostało usunięte i nie jest możliwa zmiana hasła.");
            }

            $request->validate([
                'password' => [
                    'required', 'string', 'max:255', 'confirmed',
                    Password::min(12)->uncompromised(),
                    new NotInPolishWordlist(),
                ],
            ]);

            $user->password = Hash::make($request->password);
            $user->save();

            PasswordResetToken::where('id', $validToken->id)->delete();

            return redirect()->route('login.index')->with(["success" => "Hasło zostało zmienione. Zaloguj się swoimi danymi logowania!"]);
        }
        return redirect()->route('login.index');
    }
}
