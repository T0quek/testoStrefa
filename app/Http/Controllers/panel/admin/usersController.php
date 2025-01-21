<?php

namespace App\Http\Controllers\panel\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    public function index()
    {
        return view('panel.admin.users')->with([
            "users" => User::all(),
        ]);
    }

    public function changeStatus(Request $request, $id) {
        $user = User::find($id);
        if(!$user) return redirect()->back()->withErrors(['Nie znaleziono użytkownika']);
        $user->status = ($user->status xor 1);
        $user->save();
        return redirect()->back()->with(['success'=>'Status użytkownika zmieniono pomyślnie!']);
    }
}
