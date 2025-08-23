<?php

namespace App\Livewire\Bisnes;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bisnes;
use Illuminate\Support\Facades\Auth;

class BisnesIndex extends Component
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
        $bisnes = Bisnes::where('user_id', Auth::id())->findOrFail($id);
        $bisnes->delete();

        session()->flash('message', 'Bisnes deleted successfully.');
        $this->dispatch('bisnes-deleted');
    }

    public function render()
    {
        $bisnes = Bisnes::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_bines', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_syarikat', 'like', '%' . $this->search . '%')
                        ->orWhere('jenis_bisnes', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.bisnes.bisnes-index', compact('bisnes'));
    }
}
