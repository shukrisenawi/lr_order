<?php

namespace App\Livewire\TenagaPengajar;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\TenagaPengajar;

class TenagaPengajarIndex extends Component
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

    public function updateStatus(TenagaPengajar $tenagaPengajar)
    {
        $tenagaPengajar->status = !$tenagaPengajar->status;
        $tenagaPengajar->save();
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
        $tenagaPengajar = TenagaPengajar::findOrFail($id);
        $tenagaPengajar->delete();

        session()->flash('message', 'Tenaga Pengajar deleted successfully.');
        $this->dispatch('tenaga-pengajar-deleted');
    }

    public function render()
    {
        $tenagaPengajar = TenagaPengajar::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('no_tel', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.tenaga-pengajar.tenaga-pengajar-index', compact('tenagaPengajar'));
    }
}