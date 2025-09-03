<?php

namespace App\Livewire\KodCula;

use Livewire\Component;
use App\Models\KodCula;
use Livewire\WithPagination;

class KodCulaIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $sortField = 'kod_cula';
    public $sortDirection = 'asc';

    // Modal properties
    public $showModal = false;
    public $isEditing = false;
    public $kodCulaId = null;

    // Form properties
    public $kod_cula = '';
    public $nama_cula = '';

    protected $rules = [
        'kod_cula' => 'required|string|max:10|unique:kod_cula,kod_cula',
        'nama_cula' => 'required|string|max:255',
    ];

    protected $messages = [
        'kod_cula.required' => 'Kod cula diperlukan',
        'kod_cula.unique' => 'Kod cula sudah wujud',
        'nama_cula.required' => 'Nama cula diperlukan',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $kodCula = KodCula::findOrFail($id);
        $this->kodCulaId = $id;
        $this->kod_cula = $kodCula->kod_cula;
        $this->nama_cula = $kodCula->nama_cula;
        $this->isEditing = true;
        $this->showModal = true;

        // Update validation rule for editing
        $this->rules['kod_cula'] = 'required|string|max:10|unique:kod_cula,kod_cula,' . $id;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->kodCulaId = null;
        $this->kod_cula = '';
        $this->nama_cula = '';
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $kodCula = KodCula::findOrFail($this->kodCulaId);
            $kodCula->update([
                'kod_cula' => $this->kod_cula,
                'nama_cula' => $this->nama_cula,
            ]);
            session()->flash('success', 'Kod cula berjaya dikemaskini!');
        } else {
            KodCula::create([
                'kod_cula' => $this->kod_cula,
                'nama_cula' => $this->nama_cula,
            ]);
            session()->flash('success', 'Kod cula berjaya ditambah!');
        }

        $this->closeModal();
        $this->dispatch('kod-cula-updated');
    }

    public function delete($id)
    {
        $kodCula = KodCula::findOrFail($id);
        $kodCula->delete();
        session()->flash('success', 'Kod cula berjaya dipadam!');
        $this->dispatch('kod-cula-updated');
    }


    public function render()
    {
        $kodCulas = KodCula::query()
            ->when($this->search, function ($query) {
                $query->where('kod_cula', 'like', '%' . $this->search . '%')
                       ->orWhere('nama_cula', 'like', '%' . $this->search . '%');
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        return view('livewire.kod-cula.kod-cula-index', [
            'kodCulas' => $kodCulas,
        ]);
    }
}
