<?php

namespace App\Livewire\AnakKhariah;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AnakKhariah;
use App\Models\Kumpulan;
use Illuminate\Support\Facades\Auth;

class AnakKhariahAddToKumpulan extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'nama';
    public $sortDirection = 'asc';
    public $selectedKumpulan = '';
    public $selectedAnakKhariah = [];

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

    public function selectAll()
    {
        $allIds = $this->getAnakKhariahIds();
        if (count($this->selectedAnakKhariah) === count($allIds)) {
            $this->selectedAnakKhariah = [];
        } else {
            $this->selectedAnakKhariah = $allIds;
        }
    }

    private function getAnakKhariahIds()
    {
        return AnakKhariah::with('bisnes', 'kumpulans')
            ->where('bisnes_id', session('selected_bisnes_id'))
            ->when($this->selectedKumpulan, function ($query) {
                // Exclude anak khariah who are already in the selected group
                $query->whereDoesntHave('kumpulans', function ($q) {
                    $q->where('kumpulan_id', $this->selectedKumpulan);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%')
                        ->orWhere('gelaran', 'like', '%' . $this->search . '%')
                        ->orWhere('no_tel', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->pluck('id')
            ->toArray();
    }

    public function addToKumpulan()
    {
        if (!$this->selectedKumpulan || empty($this->selectedAnakKhariah)) {
            session()->flash('error', 'Sila pilih kumpulan dan sekurang-kurangnya satu anak khariah.');
            return;
        }

        $kumpulan = Kumpulan::findOrFail($this->selectedKumpulan);

        foreach ($this->selectedAnakKhariah as $anakId) {
            $anakKhariah = AnakKhariah::findOrFail($anakId);
            // Check if already in group to avoid duplicates
            if (!$anakKhariah->kumpulans()->where('kumpulan_id', $this->selectedKumpulan)->exists()) {
                $anakKhariah->kumpulans()->attach($this->selectedKumpulan);
            }
        }

        // Reset selections
        $this->selectedKumpulan = '';
        $this->selectedAnakKhariah = [];

        session()->flash('message', 'Anak Khariah berjaya ditambah ke kumpulan.');
        // Stay on the same page to allow adding to more groups
    }

    public function removeFromKumpulan($anakKhariahId, $kumpulanId)
    {
        $anakKhariah = AnakKhariah::findOrFail($anakKhariahId);
        $kumpulan = Kumpulan::findOrFail($kumpulanId);

        // Remove the relationship
        $anakKhariah->kumpulans()->detach($kumpulanId);

        session()->flash('message', 'Anak Khariah berjaya dikeluarkan dari kumpulan ' . $kumpulan->nama . '.');
    }

    public function render()
    {
        $anakKhariah = AnakKhariah::with('bisnes', 'kumpulans')
            ->where('bisnes_id', session('selected_bisnes_id'))
            ->when($this->selectedKumpulan, function ($query) {
                // Exclude anak khariah who are already in the selected group
                $query->whereDoesntHave('kumpulans', function ($q) {
                    $q->where('kumpulan_id', $this->selectedKumpulan);
                });
            })
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

        $kumpulans = Kumpulan::where('bisnes_id', session('selected_bisnes_id'))->where('on', true)->get();

        return view('livewire.anak-khariah.anak-khariah-add-to-kumpulan', compact('anakKhariah', 'kumpulans'));
    }
}