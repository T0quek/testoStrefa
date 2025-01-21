<?php

namespace App\Http\Controllers\panel;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class indexController extends Controller
{
    public function index() {
        $userId = Auth::id();


        return view('panel.index')->with([

            //Wszystkie egzaminy
            "allEndExams" => Exam::where("creator_id", Auth::id())->where("status", "2")->count(),

            //Zdane egzaminy
            "passedExams" => Exam::withCount([
                'examQuestions as correct_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                        ->where('is_correct', true);
                },
                'examQuestions as total_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId);
                }
            ])->where("status", 2)->get()->filter(function ($exam) {
                return $exam->total_count > 0 && $exam->correct_count / $exam->total_count > 0.5;
            })->count(),

            //Przejebane egzaminy
            "failedExams" => Exam::withCount([
                'examQuestions as correct_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                        ->where('is_correct', true);
                },
                'examQuestions as total_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId);
                }
            ])->where("status", 2)->get()->filter(function ($exam) {
                return $exam->total_count > 0 && $exam->correct_count / $exam->total_count <= 0.5;
            })->count(),


            "averageScore" => Exam::withCount([
                'examQuestions as correct_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId)
                        ->where('is_correct', true);
                },
                'examQuestions as total_count' => function ($query) use ($userId) {
                    $query->where('creator_id', $userId);
                }
            ])->where("status", 2)->get()->filter(function ($exam) {
                return $exam->total_count > 0;
            })->map(function ($exam) {
                return $exam->correct_count / $exam->total_count;
            })->average(),
        ]);
    }
}
