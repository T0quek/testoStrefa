<?php

namespace App\Http\Controllers\panel\courses;

use App\Http\Controllers\Controller;
use App\Http\Requests\questionRequest;
use App\Models\Access;
use App\Models\Question;
use App\Models\Set;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class setQuestionsController extends Controller
{
    public function index($id){
        $hasAccess = Access::where("user_id", Auth::user()->id)->where("set_id", $id)->exists();
        if(!$hasAccess) abort(403);

        if(!Set::where("id",$id)->exists()) abort(404);

        $set = Set::with('questions')->where('id', $id)->firstOrFail();
        session(['set_id' => $id]);
        //dd($set);
        return view('panel.courses.setQuestions',[
            'set'=>$set,
        ]);
    }

    public function addQuestion(QuestionRequest $request){
        $validatedData = $request->validated();

        $setId = session('set_id');
        if (!$setId || !Set::where('id', $setId)->exists()) {
            return redirect()->back()->withError("Nie znaleziono aktywnego zestawu lub zestaw jest nieprawidłowy.");
        }

        // Przygotowanie danych do JSON
        $data = [
            'title' => $validatedData['questionTitle'],
            'type' => (int) $validatedData['questionType'],
        ];

        switch ((int) $validatedData['questionType']) {
            case 1: // ABCD (jedna poprawna)
                $data['answers'] = array_filter(array_map('trim', explode("\n", $validatedData['questionAnswers'])));
                $data['correctAnswers'] = [(int) $validatedData['questionCorrectAnswer']];
                break;

            case 2: // ABCD (wiele poprawnych)
                $data['answers'] = array_filter(array_map('trim', explode("\n", $validatedData['questionAnswers'])));
                $data['correctAnswers'] = array_map('intval', $validatedData['questionCorrectAnswer']);
                break;

            case 3: // SELECT (wstaw w luki)
                $data['answers'] = [];
                $data['correctAnswers'] = [];

                foreach ($validatedData as $key => $value) {
                    if (preg_match('/^questionAnswers_(\d+)$/', $key, $matches)) {
                        $data['answers'][] = array_filter(array_map('trim', explode("\n", $value)));
                    }
                    if (preg_match('/^questionCorrectAnswer_(\d+)$/', $key, $matches)) {
                        $data['correctAnswers'][] = (int) $value; // Pojedyncza odpowiedź jako indeks
                    }
                }
                break;

            case 4: // INPUT (wpisz wartość)
                $data['correctAnswers'] = array_filter(array_map('trim', explode("\n", $validatedData['questionCorrectAnswers'])));
                break;

            default:
                return redirect()->back()->withError("Nieobsługiwany typ pytania.");
        }

        // Obsługa pliku obrazu
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $timestamp = now()->timestamp . "_" . Str::random(8);
            $extension = $file->getClientOriginalExtension();
            $fileName = $timestamp . '.' . $extension;
            $imagePath = $file->storeAs('images/questions', $fileName, 'public');
        }


        $question = new Question();
        $question->type = (int) $data['type'];
        $question->data = $data;
        $question->set_id = session('set_id');
        $question->creator_id = Auth::user()->id;
        $question->image_path = $imagePath;

        //CZY DODAWANIE CZY EDYCJA
        if($request->input("questionEditId") and Question::find($request->input("questionEditId"))->exists()){
            $oldQuestion = Question::find($request->input("questionEditId"));
            $oldQuestion->deleted = true;
            $oldQuestion->save();
            $question->previous_question_id = $oldQuestion->id;
            $success = "Pytanie zmodyfikowano pomyślnie!";
        }
        else $success = "Pytanie utoworzne pomyślnie!";

        $question->save();


        return redirect()->back()->with(["success"=>$success]);
    }

    public function deleteQuestion(Request $request, $id){
        $question = Question::find($id);
        if(!$question) abort(403);
        $set_id = $question->set_id;
        $hasAccess = Access::where("user_id", Auth::user()->id)->where("set_id", $set_id)->exists();
        if(!$hasAccess) abort(403);

        if($question->deleted) {
            return redirect()->back()->withError("Pytanie już zostało usunięte!");
        }

        $question->deleted = true;
        $question->save();

        return redirect()->back()->with(['success'=>'Pytanie zostało usunięte!']);
    }
}
