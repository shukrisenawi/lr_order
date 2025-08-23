<?php

namespace App\Livewire\Prospek;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Prospek;
use Illuminate\Support\Facades\Auth;

class ProspekIndex extends Component
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
        $prospek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $prospek->delete();

        session()->flash('message', 'Prospect deleted successfully.');
        $this->dispatch('prospect-deleted');
    }

    public function render()
    {
        $prospek = Prospek::with('bisnes')
            ->whereHas('bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('gelaran', 'like', '%' . $this->search . '%')
                        ->orWhere('no_tel', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.prospek.prospek-index', compact('prospek'));
    }
}
