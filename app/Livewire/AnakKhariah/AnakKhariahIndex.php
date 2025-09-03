<?php

namespace App\Livewire\AnakKhariah;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AnakKhariah;
use App\Models\Kumpulan;
use Illuminate\Support\Facades\Auth;

class AnakKhariahIndex extends Component
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

    public function updateOn(AnakKhariah $id)
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
        $anakKhariah = AnakKhariah::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $anakKhariah->delete();

        session()->flash('message', 'Anak Khariah deleted successfully.');
        $this->dispatch('anak-khariah-deleted');
    }


    public function render()
    {
        $anakKhariah = AnakKhariah::with('bisnes', 'kumpulans')
            ->where('bisnes_id', session('selected_bisnes_id'))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('gelaran', 'like', '%' . $this->search . '%')
                        ->orWhere('no_tel', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.anak-khariah.anak-khariah-index', compact('anakKhariah'));
    }
}