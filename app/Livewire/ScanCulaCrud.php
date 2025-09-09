<?php

namespace App\Livewire;

use App\Models\ScanCula;
use Livewire\WithPagination;
use Livewire\Component;

class ScanCulaCrud extends Component
{
    protected $paginationTheme = 'tailwind';

    public $no_kp, $nama_pemilih, $alamat, $cula, $approve, $scanCulaId, $isOpen = 0;
    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.scan-cula-crud', [
            'scanCulas' => ScanCula::query()
                ->when($this->search, function ($query) {
                    $query->where('no_kp', 'like', '%' . $this->search . '%')
                          ->orWhere('nama_pemilih', 'like', '%' . $this->search . '%')
                          ->orWhere('alamat', 'like', '%' . $this->search . '%')
                          ->orWhere('cula', 'like', '%' . $this->search . '%');
                })
                ->paginate(10)
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields()
    {
        $this->no_kp = '';
        $this->nama_pemilih = '';
        $this->alamat = '';
        $this->cula = '';
        $this->approve = false;
        $this->scanCulaId = '';
    }

    public function store()
    {
        $this->validate([
            'no_kp' => 'required',
            'nama_pemilih' => 'required',
            'alamat' => 'required',
            'cula' => 'required',
        ]);

        ScanCula::updateOrCreate(['id' => $this->scanCulaId], [
            'no_kp' => $this->no_kp,
            'nama_pemilih' => $this->nama_pemilih,
            'alamat' => $this->alamat,
            'cula' => $this->cula,
            'approve' => $this->approve,
        ]);

        session()->flash('message',
            $this->scanCulaId ? 'Data berhasil diperbarui.' : 'Data berhasil dibuat.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $scanCula = ScanCula::findOrFail($id);
        $this->scanCulaId = $id;
        $this->no_kp = $scanCula->no_kp;
        $this->nama_pemilih = $scanCula->nama_pemilih;
        $this->alamat = $scanCula->alamat;
        $this->cula = $scanCula->cula;
        $this->approve = $scanCula->approve;

        $this->openModal();
    }

    public function delete($id)
    {
        ScanCula::find($id)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }
}
