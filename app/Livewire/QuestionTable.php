<?php

namespace App\Livewire;

use App\Models\Question;
use Livewire\Component;
use Livewire\WithPagination;

class QuestionTable extends Component
{
    use WithPagination;
    protected $listeners = ['loadQuestionDetails'];
    public $search = '';
    public $perPage = 5;
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $setId;
    public $total;
    public $questionData;
    public $historyData = null;

    //Do edycji
//    public $questionEditData = [];
//    public $editMode = false;

    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->setId = session('set_id');
        if (!$this->setId) abort(403, 'Brak dostępu do tego zestawu.');
        $this->total = Question::where("set_id", $this->setId)->where("deleted", false)->count();
    }


//    public $editQuestionId = null;
//    public $questionEditData = [];
//    public $activeTab = 'abcd'; // Domyślna zakładka

// Funkcja do załadowania danych pytania do edycji
    public function loadQuestionForEdit($id)
    {
        $question = Question::findOrFail($id);

        $data = [
            'title' => $question->data['title'] ?? '',
            'type' => $question->type,
            'correctAnswers' => $question->data['correctAnswers'] ?? [],
            'gaps' => $question->data['gaps'] ?? [],
            'image_path' => $question->image_path ?? null,
            'question_id' => $question->id,
        ];
        if($question->data["type"]==3) {
            foreach($question->data["answers"] as $answer) {
                $data["answers"][] = implode("\n", $answer);;
            }
        }
        else $data["answers"] = implode("\n", $question->data['answers'] ?? []);

        if($question->data["type"]==4) $data["correctAnswers"] = implode("\n", $question->data['correctAnswers'] ?? []);

        $this->dispatch('open-edit-modal', question:$data);
    }

// Funkcja resetująca dane edycji
    public function resetEditForm()
    {
        $this->editQuestionId = null;
        $this->questionEditData = [];
        $this->activeTab = 'abcd';
    }

//    public function loadQuestionForEdit($id)
//    {
//        $question = Question::findOrFail($id);
//        $this->questionEditData = [
//            'title' => $question->data['title'] ?? '',
//            'type' => $question->type,
//            'answers' => is_array($question->data['answers']) ? $question->data['answers'] : explode("\n", $question->data['answers']),
//            'correctAnswers' => is_array($question->data['correctAnswers']) ? $question->data['correctAnswers'] : json_decode($question->data['correctAnswers'], true),
//            'image_path' => $question->image_path ?? null,
//        ];
//
//        $this->dispatch('showEditModal', ['type' => $this->questionEditData['type']]);
//    }


    public function loadQuestionDetails($id)
    {
        $question = Question::find($id);
        if($question){
            $questionData = $question->data;
            $questionData["image_path"] = $question->image_path??null;
            $this->questionData = $questionData;
        }
        //dd($this->questionData);
    }
    public function loadQuestionHistory($id)
    {
        $history = [];
        $current = Question::find($id);

        // Rekurencyjne przechodzenie przez historię pytań
        while ($current) {
            $history[] = $current->data + ['version' => $current->depth];
            $current = $current->previous_question_id ? Question::find($current->previous_question_id) : null;
        }

        $this->historyData = $history;
    }
    public function updatedSearch(){$this->resetPage();}

    public function updatedPerPage(){$this->resetPage();}

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
        $questions = Question::where('data->title', 'like', '%' . $this->search . '%')
            ->where('set_id', $this->setId)
            ->with('previousQuestion')
            ->where('deleted', false)
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);

        foreach($questions as $question){
            $depth = 0;
            $current = $question;
            while ($current) {
                $depth++;
                $current = $current->previousQuestion; // Relacja modelu
            }
            $question->depth = $depth;
        }

        return view('livewire.question-table', [
            'questions' => $questions,
        ]);
    }
}
