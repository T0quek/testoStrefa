<?php

namespace App\Http\Controllers\panel\courses;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\AuthKey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class redeemController extends Controller
{
    public function index() {
        return view('panel.courses.redeemCode');
    }

    public function redeemCode(Request $request) {
        $request->validate([
            "code" => "required|exists:auth_keys,key|regex:/^[A-Z0-9]{5}-[A-Z0-9]{5}-[A-Z0-9]{5}$/"
        ], [
            "code.regex"=>"Klucz musi mieć odpowiedni format. Sprawdź pisownię i spróbuj ponownie",
            "code.exists"=>"Wprowadzony klucz jest nieprawidłowy lub przedawniony!"
        ]);

        $key = AuthKey::where("key", $request->input("code"))->first();
        $options = json_decode($key->options, true);
        if($options["usageCount"]<=0) return redirect()->back()->withError("Wprowadzony klucz został wykorzystany maksymalną liczbę razy");
        $dateTime = Carbon::createFromFormat("Y-m-d H:i:s", $options["dateTime"]);
        if($dateTime < Carbon::now()) return redirect()->back()->withError("Wprowadzony klucz jest nieprawidłowy lub przedawniony!");

        //Przyznawanie dostępów
        foreach($options["sets"] as $set) {
            $query = Access::where("set_id", $set)->where("user_id", Auth::user()->id)->exists();
            if(!$query) {
                $access = new Access();
                $access->user_id = Auth::user()->id;
                $access->creator_id = $key->creator_id;
                $access->set_id = $set;
                $access->save();
            }
        }

        if($options["usageCount"]<=1) $key->delete();
        else {
            $options["usageCount"] -=1;
            $key->options = json_encode($options);
            $key->save();
        }

        return redirect()->back()->with(["success"=>"Klucz poprawny! Odpowiednie dostępy zostały przydzielone"]);
    }
}
