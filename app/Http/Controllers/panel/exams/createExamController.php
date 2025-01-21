<?php

namespace App\Http\Controllers\panel\exams;

use App\Http\Controllers\Controller;
use App\Models\Access;
use App\Models\Course;
use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class createExamController extends Controller
{
    public function index() {
        $userId = Auth::user()->id;
        return view('panel.exams.createExam')->with([
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

    public function createExam(Request $request) {
        $request->validate([
            "sets" => "required|array|min:1",
            'setUsageInput' => "required|array",
            'setUsageInput.*' => "numeric|min:0|max:100",
            'questionNumber' => "required|integer|min:0|max:200",
            'maxTime'=> "integer|min:0|max:1000",
        ]);

        if (round(array_sum($request->input('setUsageInput'))) != 100) {
            return redirect()->back()->withError('Suma proporcji musi się równać 100%')->withInput();
        }

        if(count($request->input('sets'))!=count($request->input('setUsageInput'))) {
            return redirect()->back()->withError('Wystąpił błąd z zestawami pytań. Spróbuj ponownie!')->withInput();
        }

        $sets = $request->input("sets");
        $data = array();
        $i = 0;


        $totalQuestions = 0;

        foreach($sets as $set_name=>$set_id) {
            $q_set = Set::with(['questions' => function ($query) {
                $query->where('deleted', 0);
            }])->find($set_id);
            $user_id = Auth::user()->id;
            $access = Access::where("set_id", $set_id)->where("user_id", $user_id)->first();
//            if(!$q_set or !$access) {
//                return redirect()->back()->withError("Wybrane zestawy pytań nie istnieją lub nie masz do nich uprawnień!")->withInput();
//            }
            $totalQuestions += count($q_set->questions);

            $data[$i] = array(
                "set_id" => $set_id,
                "set_name" => $q_set->name,
                "question_number" => count($q_set->questions),
                "questions" => $q_set->questions,
            );
            $i++;
        }

        //Sprawdzenie łącznej liczby pytań
//        if($totalQuestions<$request->input('questionNumber')) {
//            return redirect()->back()->withError("W bazie znajduje się zbyt mało pytań, aby utworzyć taki egzamin! Zmniejsz liczbę pytań")->withInput();
//        }

        //Nadanie użyć do każdego setu w tablicy
        $i = count($sets);
        for($j=0; $j<$i; $j++) {
            $data[$j]["usage"] = (float)$request->input("setUsageInput")[$j];
        }

//        dd($data, $request->all());
        $checkValue = 0;
        //Sprawdzenie dla każdego zestawu pytań czy można tyle pytań
        foreach($data as &$setData) {
            // set_id, set_name, question_number, usage (jako np. 25)
//            if(($setData["usage"]/100) * $request->input("questionNumber")>$setData["question_number"]) {
//                return redirect()->back()->withError("Zestaw: ".$setData["set_name"]." ma zbyt małą liczbę pytań. Zmniejsz liczbę pytań.")->withInput();
//            }
            $setData["final_question_number"] = (int)round(($setData["usage"]/100)*$request->input("questionNumber"));
            $checkValue += $setData["final_question_number"];
        }

        //Sprawdzenie przypadku zaokrąglania liczb (jeżeli jest równo podzielone na 0.5 i zaokrągla w górę)
        if($checkValue!=(int)$request->input("questionNumber")) {
            $data[0]["final_question_number"] -= 1;
        }

        //Losowanie pytań i zebranie informacji na temat poszczególnych pytań
        $collectedQuestions = [];

        foreach ($data as $setDatas) {
            $questionIds = $setDatas["questions"]->pluck("id");
            $finalQuestionNumber = $setDatas["final_question_number"];

            // Losowanie pytań dla danego zestawu
            $randomQuestions = (collect($questionIds)->random($finalQuestionNumber))->toArray();
            shuffle($randomQuestions);
            foreach ($randomQuestions as $questionId) {
                $collectedQuestions[] = [
                    'question_id' => $questionId,
                    'answered' => false, // Czy na pytanie odpowiedziano
                    'is_correct' => false, // Czy odpowiedź była poprawna
                    'answers' => json_encode([]), // Zaznaczone odpowiedzi
//                    'created_at' => date("Y-m-d H:i:s"),
//                    'updated_at' => date("Y-m-d H:i:s"),
                ];
            }
        }
        shuffle($collectedQuestions);
        //dd($data, $collectedQuestions, $request->all(), $request->all());





        $exam = new Exam();
        $exam->status = 0;
        //$exam->data = json_encode($collectedQuestions);
        $exam->creator_id = Auth::user()->id;
        if($request->input("maxTime")) {
            $exam->maxTime = now()->addMinutes((int) $request->input("maxTime"));
        }

        if(isset($request->learnMode)) $learnMode = true;
        else $learnMode = false;

        $exam->learnMode = $learnMode;


        $exam->save();

        //Stworzenie wpisów do bazy exam_questions
        foreach($collectedQuestions as $question) {
            $examQuestion = new ExamQuestion();
            $examQuestion->question_id = $question["question_id"];
            $examQuestion->exam_id = $exam->id;
            $examQuestion->save();
        }

        // Utwórz identyfikator na podstawie ID egzaminu i losowej wartości

        $identifier = hash_hmac('sha256', $exam->id . env("APP_KEY"), config('app.key')); // HMAC z kluczem aplikacji

        $short = substr($identifier, 0, 10); // Skróć do 10 znaków


        return redirect()->route("exam.show", ["identifier"=>$short]);
    }
}
