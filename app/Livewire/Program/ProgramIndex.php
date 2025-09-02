<?php

namespace App\Livewire\Program;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Program;

class ProgramIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        $this->sortField = $field;
    }

    public function delete($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        session()->flash('message', 'Program deleted successfully.');
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $programs = Program::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('tajuk', 'like', '%' . $this->search . '%')
                        ->orWhere('keterangan', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.program.program-index', compact('programs'));
    }
}