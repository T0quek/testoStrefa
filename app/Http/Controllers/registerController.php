<?php

namespace App\Http\Controllers;

use App\Jobs\sendEmail;
use App\Models\ActivateToken;
use App\Models\User;
use App\Rules\NotInPolishWordlist;
use Illuminate\Http\Request;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Mockery\Matcher\Not;

class registerController extends Controller
{
    public function index()
    {
        if(auth()->user()) return redirect()->route('panel.index');
        return view('public.register');
    }

    public function regulation(){
        return view('public.regulation');
    }
    public function policy(){
        return view('public.policy');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'string', 'max:255', 'confirmed',
                Password::min(12)
                    ->uncompromised(),
                new NotInPolishWordlist(),
            ],
            'regulation' => 'checked',
        ]);

        $token = Str::random(64);

        //Utworzenie Użytkownika
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        //Utworzenie tokena aktywacyjnego
        $tokenRow = new ActivateToken();
        $tokenRow->token = Hash::make($token);
        $tokenRow->user_id =$user->id;
        $tokenRow->save();


        //Stwórz dispatch joba do sendEmail
        dispatch(new sendEmail(
            $user->email,
            array(
                "token" => $token,
                "name" => $user->name,
                "subject" => "Witaj na testoStrefa.pl!"
            ),
            "register"
        ));


//        Mail::send('email.register', ['token' => $token, 'name'=>$user->name], function ($message) use ($request) {
//            $message->to($request->email);
//            $message->subject('Witaj na testoStrefa.pl!');
//        });

        return redirect()->back()->with(['success'=>"Konto utworzone. Na podany adres email został wysłany link aktywacyjny."]);
    }


    public function activate($token) {

        $tokenQuery = ActivateToken::whereNotNull('token')->get();

        $matchingToken = $tokenQuery->first(function ($record) use ($token) {
            return Hash::check($token, $record->token);
        });

        if ($matchingToken) {
            $user = User::find($matchingToken->user_id);
            if ($user) {
                $user->status = 1;
                $user->email_verified_at = now();
                $user->save();
                $matchingToken->delete();

                return redirect()->route('login.index')->with(["success" => "Konto zostało aktywowane. Zaloguj się swoimi danymi logowania!"]);
            }
        }

        return redirect()->route('login.index');
    }

    public function test(Request $request) {
        Mail::send('email.register', ['token' => "TOKEN", 'name'=>"Adam toChuj"], function ($message) use ($request) {
            $message->to("tomaszgudyka@gmail.com");
            $message->subject('Witaj na testoStrefa.pl!');
        });
        return response()->json(['message' => 'Email sent successfully.']);
    }
}
