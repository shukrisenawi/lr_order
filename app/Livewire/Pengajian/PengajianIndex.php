<?php

namespace App\Livewire\Pengajian;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Pengajian;

class PengajianIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['search'];

    public function mount()
    {
        if (session('selected_bisnes_id') != 3) {
            return redirect()->route('dashboard');
        }
    }

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
        $pengajian = Pengajian::findOrFail($id);
        $pengajian->delete();

        session()->flash('message', 'Pengajian deleted successfully.');
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        $pengajians = Pengajian::with(['tenagaPengajar', 'kitabPengajian'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('hari', 'like', '%' . $this->search . '%')
                        ->orWhere('masa', 'like', '%' . $this->search . '%')
                        ->orWhere('tempat', 'like', '%' . $this->search . '%')
                        ->orWhereHas('tenagaPengajar', function ($subQuery) {
                            $subQuery->where('nama', 'like', '%' . $this->search . '%');
                        })
                        ->orWhereHas('kitabPengajian', function ($subQuery) {
                            $subQuery->where('nama_kitab', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.pengajian.pengajian-index', compact('pengajians'));
    }
}