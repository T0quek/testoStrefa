<?php

namespace App\Http\Controllers\panel\exams;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ExamController extends Controller
{
    public function show($identifier)
    {
        $exams = Exam::all();

        foreach ($exams as $exam) {
            $test = hash_hmac('sha256', $exam->id . env("APP_KEY"), config('app.key'));
            $test = substr($test, 0, 10);

            if ($test == $identifier) {
                if ($exam->creator_id != Auth::user()->id) abort(403);

                $examId = $exam->id;

                $remainingTime = null;
                if ($exam->maxTime) {
                    $remainingTime = Carbon::now()->diffInSeconds(Carbon::parse($exam->maxTime), false);
                    if ($remainingTime <= 0) $remainingTime = 0;
                }
                return view('panel.exams.exam', compact('examId', 'exam', 'remainingTime'));
            }
        }
        abort(404);
    }

    public function results($examId) {
        redirect()->route("panel.exams.history.details", ["examId" => $examId]);
    }
}
