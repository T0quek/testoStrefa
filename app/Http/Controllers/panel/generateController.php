<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class generateController extends Controller
{
    public function index() {
        return view('panel.generateCode');
    }
}
