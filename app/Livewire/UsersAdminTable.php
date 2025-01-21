<?php

namespace App\Livewire;

use App\Models\Question;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UsersAdminTable extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 5;
    public $sortColumn = 'id';
    public $sortDirection = 'asc';
    public $total;

    protected $paginationTheme = 'bootstrap';


    public function mount() {
        $this->total = User::all()->count();
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

    public function changeStatus($userId)
    {
        $user = User::find($userId);
        if ($user) {
            $user->status = !$user->status;
            $user->save();

            // Emitowanie komunikatu sukcesu do widoku
            $this->dispatch('success', 'Status użytkownika został zmieniony.');
        }
    }

    public function deleteUser($id) {
        $user = User::findOrFail($id);
        $user->status = 0;
        $user->deleted = 1;
        $user->save();
        // Emitowanie zdarzenia z komunikatem
        $this->dispatch('showSuccessMessage', 'Status użytkownika został zmieniony.');
    }

    public function render()
    {
        $users = User::where("deleted", 0)
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortColumn, $this->sortDirection)
            ->paginate($this->perPage);


        return view('livewire.users-admin-table', [
            'users' => $users,
        ]);
    }
}
