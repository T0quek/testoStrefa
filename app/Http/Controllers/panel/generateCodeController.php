<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\AuthKey;
use App\Models\Course;
use App\Models\Set;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class generateCodeController extends Controller
{
    public function index() {
        $userId = Auth::user()->id;
        return view('panel.generateCode')->with([
            'courses' => Course::with([
                'sets' => function ($query) use ($userId) {
                    $query->whereHas('accesses', function ($accessQuery) use ($userId) {
                        $accessQuery->where('user_id', $userId);
                    })->with(['questions' => function ($questionQuery) {
                        $questionQuery->where('deleted', false);
                    }]);
                }
            ])
                ->whereHas('sets.accesses', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->get()
        ]);
    }

    public function generate(Request $request)
    {
//        dd($request);
        $request->validate([
            "sets" => "required|array|min:1",
            "datepicker" => [
                'regex:/^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/\d{4} ([01][0-9]|2[0-3]):[0-5][0-9]$/'
            ],
            "usageCount" => "integer|min:1|max:100",
        ]);

        $sets = $request->input("sets");

        foreach($sets as $set_name=>$set_id) {
            $q_set = Set::find($set_id);
            $user_id = Auth::user()->id;
            $access = Access::where("set_id", $set_id)->where("user_id", $user_id)->first();
            if(!$q_set or !$access) {
                return redirect()->back()->withError("Wybrane zestawy pytań nie istnieją lub nie masz do nich uprawnień!");
            }
        }

        //Utworzenie klucza oryginalnego
        do {
            $key = collect(range(1, 3))
                ->map(fn() => strtoupper(Str::random(5)))
                ->implode('-');
        } while (AuthKey::where("key", $key)->exists());


        //Sprawdzenie daty
        $dateTime = null;
        if($request->input("datepicker")) {
            $dateTime = Carbon::createFromFormat('d/m/Y H:i', $request->input("datepicker"));
            if(!$dateTime->isFuture()) return redirect()->back()->withError("Data wygaśnięcia klucza musi być w przyszłości!");
            $dateTime = Carbon::createFromFormat('d/m/Y H:i', $request->input("datepicker"))->format('Y-m-d H:i:s');
        }


        $date = new DateTime();
        $date->modify('+1 week');
        $next_week = $date->format('Y-m-d H:i:s');

        $token = new AuthKey();
        $token->key =$key;
        $token->creator_id = Auth::user()->id;
        $token->options = json_encode([
            "usageCount" => $request->input("usageCount")??1,
            "dateTime"  => $dateTime??$next_week,
            "sets" => $request->input("sets"),
        ]);
        $token->save();

        return redirect()->route("panel.generateCode.index")->with(["success"=>"Kod wygenerowano pomyślnie", "token"=>$token]);
    }
}
