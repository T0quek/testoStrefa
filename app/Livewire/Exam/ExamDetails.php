<?php

namespace App\Livewire\Exam;

use App\Models\Exam;
use Carbon\Carbon;
use Livewire\Component;

class ExamDetails extends Component
{
    public $currentQuestion = 0;
    public $totalQuestions = 1;
    public $correctAnswers = 0;
    public $remainingTime;
    public $examId = 0;


    protected $listeners = ['exam-progress-updated' => 'updateProgress', 'update-remaining-time' => 'updateRemainingTime'];

    public function mount($examId)
    {
        $exam = Exam::with(['examQuestions'])->findOrFail($examId);
        $this->examId = $examId;

        $this->totalQuestions = $exam->examQuestions->count();
        $this->correctAnswers = $exam->examQuestions->where('is_correct', true)->count();
        $this->currentQuestion = $exam->examQuestions->where('answered', false)->keys()->first() + 1 ?? $this->totalQuestions;

        if ($exam->maxTime) $this->remainingTime = Carbon::now()->diffInSeconds(Carbon::parse($exam->maxTime), false);
        else $this->remainingTime = null;
    }

    public function tick()
    {
        if (!is_null($this->remainingTime)) {
            $this->remainingTime--;

            if ($this->remainingTime <= 0) {
                $this->remainingTime = 0;
                $this->redirectToSummary();
            }
        }
    }

    public function updateRemainingTime($time)
    {
        $this->remainingTime = $time;

        if ($this->remainingTime <= 0) {
            $this->redirectToSummary();
        }
    }

    private function redirectToSummary()
    {
        return redirect()->route('panel.exams.history.details', ["examId" => $this->examId]);
    }

    public function cancelExam() {
        $exam = Exam::findOrFail($this->examId)->update(["status"=>3]);
        $this->redirectToSummary();
    }

    public function updateProgress($data)
    {
        $this->currentQuestion = $data['currentQuestion']??$this->currentQuestion;
        $this->totalQuestions = $data['totalQuestions'];
        $this->correctAnswers = $data['correctAnswers'];
    }

    public function render()
    {
        return view('livewire.exam.exam-details', [
            'currentQuestion' => $this->currentQuestion,
            'totalQuestions' => $this->totalQuestions,
            'correctAnswers' => $this->correctAnswers,
            'remainingTime' => $this->remainingTime,
        ]);
    }
}
