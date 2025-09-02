<?php

namespace App\Livewire\Kumpulan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kumpulan;
use Illuminate\Support\Facades\Auth;

class KumpulanIndex extends Component
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

    public function updateOn(Kumpulan $id)
    {
        $id->on = !$id->on;
        $id->save();
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
        $kumpulan = Kumpulan::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $kumpulan->delete();

        session()->flash('message', 'Kumpulan deleted successfully.');
        $this->dispatch('kumpulan-deleted');
    }

    public function render()
    {
        $kumpulan = Kumpulan::with('bisnes')
            ->where('bisnes_id', session('selected_bisnes_id'))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.kumpulan.kumpulan-index', compact('kumpulan'));
    }
}