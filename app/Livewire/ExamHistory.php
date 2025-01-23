<?php

namespace App\Livewire;

use App\Models\Exam;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ExamHistory extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $total;

    protected $paginationTheme = 'bootstrap';

    public function mount() {
        $this->total = Exam::with("examQuestions")->where("creator_id", Auth::user()->id)->count();
    }

    public function performSearch(){$this->resetPage();}

    public function sortBy($column)
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortColumn = $column;
            $this->sortDirection = 'asc';
        }
    }


    public function render()
    {
        DB::statement('CALL UpdateExpiredExams()');

        $exams = Exam::with("examQuestions")
            ->select([
                'exams.*', // Pobiera wszystkie kolumny z tabeli exams
                DB::raw('GetDistinctSetNamesByExam(exams.id) AS set_names'), // Dodaje kolumnę z nazwami zestawów
                DB::raw('GetExamAverageScore(exams.id) AS average_score') // Dodaje kolumnę z wynikiem średnim
            ])
            ->where(function ($query) {
                $query->where('created_at', 'like', '%' . $this->search . '%');
            })
            ->where("creator_id", Auth::user()->id)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        // Dodanie identyfikatora ręcznie
        foreach ($exams as $exam) {
            $identifier = hash_hmac('sha256', $exam->id . env("APP_KEY"), config('app.key'));
            $exam->identifier = substr($identifier, 0, 10);
        }

        //dd($exams);

        return view('livewire.exam-history', [
            "exams" => $exams,
        ]);
    }
}
