<?php

namespace App\Livewire\Iklan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Iklan;

class IklanIndex extends Component
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
    public function updateOn(Iklan $id)
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
        $iklan = Iklan::findOrFail($id);
        $iklan->delete();

        session()->flash('message', 'Iklan deleted successfully.');
        $this->dispatch('iklan-deleted');
    }

    public function render()
    {
        $iklan = Iklan::where('bisnes_id', session('selected_bisnes_id'))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_iklan', 'like', '%' . $this->search . '%')
                        ->orWhere('keterangan', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.iklan.iklan-index', compact('iklan'));
    }
}
