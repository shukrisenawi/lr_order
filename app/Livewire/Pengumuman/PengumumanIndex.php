<?php

namespace App\Livewire\Pengumuman;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengumuman;

class PengumumanIndex extends Component
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
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();

        session()->flash('message', 'Pengumuman deleted successfully.');
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $pengumumen = Pengumuman::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('pengumuman', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.pengumuman.pengumuman-index', compact('pengumumen'));
    }
}