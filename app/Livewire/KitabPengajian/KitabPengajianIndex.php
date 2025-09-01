<?php

namespace App\Livewire\KitabPengajian;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KitabPengajian;

class KitabPengajianIndex extends Component
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
        $kitabPengajian = KitabPengajian::findOrFail($id);
        $kitabPengajian->delete();

        session()->flash('message', 'Kitab Pengajian deleted successfully.');
        $this->dispatch('kitab-pengajian-deleted');
    }

    public function render()
    {
        $kitabPengajian = KitabPengajian::with('tenagaPengajar')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_kitab', 'like', '%' . $this->search . '%')
                        ->orWhere('catatan', 'like', '%' . $this->search . '%')
                        ->orWhereHas('tenagaPengajar', function ($subQuery) {
                            $subQuery->where('nama', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.kitab-pengajian.kitab-pengajian-index', compact('kitabPengajian'));
    }
}