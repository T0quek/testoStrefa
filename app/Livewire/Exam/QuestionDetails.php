<?php

namespace App\Livewire\Exam;

use App\Models\Exam;
use App\Models\ExamQuestion;
use App\Models\Question;
use App\Models\QuestionReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class QuestionDetails extends Component
{
    public $examId;
    public $questionsDetails = [];
    public $currentIndex = 0;
    public $selectedAnswers = [];
    public $feedback = [];
    public $feedbackMessage;
    public $isSubmitted = false;
    public $shuffle = 0;
    public $remainingTime;

    protected $rules = [
        'reportDescription' => 'required|min:10|max:500',
    ];

    public $reportDescription = ''; // Pole do opisu zgłaszania błędu
    public $successMessage = ''; // Komunikat o sukcesie
    public $errorMessage = ''; // Komunikat o błędzie

    public function mount($examId, $remainingTime)
    {
        if ($this->hasTimeExpired()) {
            $this->endExam(2);
        }

        $this->examId = $examId;
        $this->remainingTime = $remainingTime;

        // Pobranie egzaminu i powiązanych pytań
        $exam = Exam::with(['examQuestions.question'])->findOrFail($examId);
        //dd($exam);
        $this->questionsDetails = $exam->examQuestions->map(function ($examQuestion) {
            return $examQuestion;
        })->toArray();


        $this->currentIndex = 0;
        for($i=0; $i < count($this->questionsDetails); $i++) {
            if (!$this->questionsDetails[$i]['answered']) {
                $this->currentIndex = $i;
                break;
            }
        }
        //dd($this->questionsDetails[1]["answered"]);
//        $this->currentIndex = $this->getNextIndex();
        $this->generateShuffle();
        $this->dispatch('questionLoaded');
        $this->dispatchProgress();
    }

    public function submitReport()
    {
        $this->validate();

        try {
            $report = new QuestionReport();
            $report->question_id = $this->questionsDetails[$this->currentIndex]['question_id'];
            $report->creator_id = Auth::id();
            $report->description = $this->reportDescription;
            $report->save();

            $this->successMessage = 'Zgłoszenie zostało wysłane pomyślnie!';
            $this->reset('reportDescription'); // Wyczyść pole opisu
        } catch (\Exception $e) {
            $this->errorMessage = 'Wystąpił błąd podczas zgłaszania pytania. Spróbuj ponownie później.';
        }

    }
    public function updatedReportDescription()
    {
        $this->validateOnly('reportDescription');
    }

    private function getNextIndex()
    {
        for ($i = $this->currentIndex+1; $i < count($this->questionsDetails); $i++) {
            if (!$this->questionsDetails[$i]['answered']) return $i;
        }
        foreach ($this->questionsDetails as $index => $examQuestion) {
            if (!$examQuestion['answered']) return $index;
        }

        return count($this->questionsDetails);
    }

    public function submitAnswer()
    {
        if ($this->hasTimeExpired()) {
            $this->endExam(1);
            return;
        }

        $currentQuestion = $this->questionsDetails[$this->currentIndex];
        $data = $currentQuestion['question']['data'];

        $questionCorrect = $this->checkAnswers($data);

        $exam = Exam::find($this->examId);
        $answered = $exam->learnMode && !$questionCorrect ? false : true;

        ExamQuestion::where('id', $currentQuestion['id'])->update([
            'answered' => $answered,
            'is_correct' => $questionCorrect,
            'user_answers' => json_encode(array_map('htmlspecialchars', $this->selectedAnswers), JSON_UNESCAPED_UNICODE),
        ]);

        $this->questionsDetails[$this->currentIndex]['answered'] = $answered;
        $this->questionsDetails[$this->currentIndex]['is_correct'] = $questionCorrect;

        if ($this->checkExamCompletion()) {
            $this->endExam(2);
            return;
        }

        $this->isSubmitted = true;
        $this->feedbackMessage = $questionCorrect ? 'success' : 'danger';

        $this->dispatchProgress(false);
    }

    private function checkAnswers($data)
    {
        $correctAnswers = $data['correctAnswers'];
        $questionCorrect = true;

        switch ($data['type']) {
            case 1: // Jedna poprawna odpowiedź
                $correctAnswers = [$data['answers'][$correctAnswers[0]]];
                $questionCorrect = $this->selectedAnswers === $correctAnswers[0];
                break;

            case 2: // Wiele poprawnych odpowiedzi
                $correctAnswers = array_map(fn($index) => $data['answers'][$index], $correctAnswers);
                $questionCorrect = !array_diff($this->selectedAnswers, $correctAnswers) && !array_diff($correctAnswers, $this->selectedAnswers);
                break;

            case 3: // Pytanie z lukami do wypełnienia
                foreach ($correctAnswers as $key => $index) {
                    if (!isset($this->selectedAnswers[$key]) || $this->selectedAnswers[$key] !== $data['answers'][$key][$index]) {
                        $questionCorrect = false;
                        break;
                    }
                }
                break;

            case 4: // Wartość liczbowa lub tekstowa
                $questionCorrect = in_array($this->selectedAnswers??null, $correctAnswers);
                break;
        }

        $this->generateFeedback($data, $questionCorrect);
        return $questionCorrect;
    }

    private function generateFeedback($data, $questionCorrect)
    {
        $this->feedback = [];

        // Przekształcenie odpowiedzi użytkownika na tablicę, jeśli jest pojedynczą wartością
        if (!is_array($this->selectedAnswers)) {
            $this->selectedAnswers = [substr($this->selectedAnswers, 0, 512)];
        }
        switch ($data['type']) {
            case 1: // Pytanie z jedną poprawną odpowiedzią
            case 2: // Pytanie z wieloma poprawnymi odpowiedziami
                // Pobranie poprawnych odpowiedzi na podstawie indeksów
                $correctAnswers = array_map(function ($index) use ($data) {
                    return $data['answers'][$index];
                }, $data['correctAnswers']);

                foreach ($data['answers'] as $index => $answer) {
                    if (in_array($answer, $this->selectedAnswers) && in_array($answer, $correctAnswers)) {
                        $this->feedback[$answer] = 'success';
                    } elseif (in_array($answer, $this->selectedAnswers)) {
                        $this->feedback[$answer] = 'danger';
                    } elseif (in_array($answer, $correctAnswers)) {
                        $this->feedback[$answer] = 'warning';
                    } else $this->feedback[$answer] = '';
                }
                break;

            case 3: // Pytanie z lukami do wypełnienia
                foreach ($data['correctAnswers'] as $index => $correctAnswer) {
                    if (!isset($this->selectedAnswers[$index])) {
                        $this->feedback[$index] = 'warning';
                    } elseif ($this->selectedAnswers[$index] == $data['answers'][$index][$correctAnswer]) {
                        $this->feedback[$index] = 'success';
                    } else $this->feedback[$index] = 'danger';
                }
                break;

            case 4: // Pytanie z wartością tekstową/liczbową
                if (empty($this->selectedAnswers)) {
                    $this->feedback[0] = 'warning';
                } elseif (in_array($this->selectedAnswers[0], $data['correctAnswers'])) {
                    $this->feedback[0] = 'success';
                } else $this->feedback[0] = 'danger';
                break;
        }
    }

    public function nextQuestion()
    {
        if ($this->hasTimeExpired()) {
            $this->endExam(1);
            return redirect()->route('panel.index');
        }

        if ($this->checkExamCompletion()) {
            $this->endExam(2);
            return redirect()->route('panel.index');
        }

        $this->currentIndex = $this->getNextIndex();
        $this->generateShuffle(); // Losuj nową wartość tylko przy przejściu do nowego pytania
        $this->selectedAnswers = [];
        $this->isSubmitted = false;
        $this->feedback = [];
        $this->feedbackMessage = '';

        $this->reset('successMessage', 'errorMessage');
        $this->dispatch('questionLoaded');
        $this->dispatchProgress();
    }

    private function generateShuffle()
    {
        $this->shuffle = rand(1, 100000); // Losowa wartość na podstawie której frontend ustawi kolejność
    }

    private function checkExamCompletion()
    {
        $allAnswered = collect($this->questionsDetails)->every(fn($q) => $q['answered'] === true);

        if ($allAnswered) return true;
        return false;
    }

    private function endExam($status=null)
    {
        if($status) Exam::where('id', $this->examId)->update(['status' => $status]);
        $this->dispatch('exam-ended');
        return redirect()->route('panel.exams.history.details', ["examId" => $this->examId]);
    }

    private function hasTimeExpired()
    {
        if (is_null($this->remainingTime)) return false;
        return $this->remainingTime <= 0;
    }

    public function dispatchProgress($currentQuestionInclude=true)
    {
        if ($this->hasTimeExpired()) {
            $this->endExam(1);
            return;
        }

        $totalQuestions = count($this->questionsDetails);
        $correctAnswers = collect($this->questionsDetails)->filter(fn($q) => $q['is_correct'])->count();

        if($currentQuestionInclude) {
            $this->dispatch('exam-progress-updated', [
                'currentQuestion' => $this->currentIndex + 1,
                'totalQuestions' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
            ]);
        }
        else {
            $this->dispatch('exam-progress-updated', [
                'totalQuestions' => $totalQuestions,
                'correctAnswers' => $correctAnswers,
            ]);
        }
    }

    public function check() {
        dd($this->shuffle);
    }

    public function render()
    {
        //dd($this->questionsDetails);
        return view('livewire.exam.question-details', [
            'currentQuestion' => $this->questionsDetails[$this->currentIndex] ?? [],
            'feedback' => $this->feedback,
            'isSubmitted' => $this->isSubmitted,
        ]);
    }
}
