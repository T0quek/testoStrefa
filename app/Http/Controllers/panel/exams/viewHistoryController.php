<?php

namespace App\Http\Controllers\panel\exams;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class viewHistoryController extends Controller
{
    public function index() {
        return view('panel.exams.examHistory');
    }

    public function details($examId) {
        $exam = Exam::with(["examQuestions", "questions"])
            ->select([
                'exams.*', // Pobiera wszystkie kolumny z tabeli exams
                DB::raw('GetDistinctSetNamesByExam(exams.id) AS set_names'), // Dodaje kolumnę z nazwami zestawów
                DB::raw('GetExamAverageScore(exams.id) AS average_score') // Dodaje kolumnę z wynikiem średnim
            ])
            ->find($examId);

        if($exam->creator_id != Auth::user()->id) abort(403);

        return view('panel.exams.examDetails', [
            "exam" => $exam
        ]);
    }
}
