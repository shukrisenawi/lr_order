<?php

namespace App\Livewire\DataPenduduk;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\DataPenduduk;
use App\Imports\DataPendudukImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class DataPendudukIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $excelFile;
    public $loading = false;
    public $showDeleteModal = false;
    public $deletePassword = '';
    public $selectedNamaDm = '';
    public $selectedNamaLokaliti = '';
    public $namaDmOptions = [];
    public $namaLokalitiOptions = [];

    protected $queryString = ['search', 'selectedNamaDm', 'selectedNamaLokaliti'];

    public function mount()
    {
        if (session('selected_bisnes_id') != 4) {
            return redirect()->route('dashboard');
        }

        $this->namaDmOptions = DataPenduduk::select('nama_dm')->distinct()->whereNotNull('nama_dm')->where('nama_dm', '!=', '')->orderBy('nama_dm')->pluck('nama_dm')->toArray();
    }

    public function updatedSelectedNamaDm()
    {
        $this->selectedNamaLokaliti = '';
        $this->resetPage();
        if ($this->selectedNamaDm) {
            $this->namaLokalitiOptions = DataPenduduk::select('nama_lokaliti')
                ->distinct()
                ->where('nama_dm', $this->selectedNamaDm)
                ->whereNotNull('nama_lokaliti')
                ->where('nama_lokaliti', '!=', '')
                ->orderBy('nama_lokaliti')
                ->pluck('nama_lokaliti')
                ->toArray();
        } else {
            $this->namaLokalitiOptions = [];
        }
    }

    public function updatedSelectedNamaLokaliti()
    {
        $this->resetPage();
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
        $data = DataPenduduk::findOrFail($id);
        $data->delete();

        session()->flash('message', 'Data Penduduk deleted successfully.');
    }

    public function deleteAll()
    {
        $this->showDeleteModal = true;
    }

    public function confirmDeleteAll()
    {
        if (!Hash::check($this->deletePassword, auth()->user()->password)) {
            session()->flash('error', 'Kata laluan salah. Sila cuba lagi.');
            $this->deletePassword = '';
            return;
        }

        $this->performDeleteAll();
        $this->closeDeleteModal();
    }

    private function performDeleteAll()
    {
        DataPenduduk::truncate();
        session()->flash('message', 'Semua data penduduk telah dipadamkan.');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletePassword = '';
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->selectedNamaDm = '';
        $this->selectedNamaLokaliti = '';
        $this->resetPage();
    }

    public function gotoPage($page)
    {
        $this->setPage($page);
    }

    public function importExcel()
    {
        $this->loading = true;

        try {
            $this->validate([
                'excelFile' => 'required|mimes:xlsx,xls',
            ]);

            Excel::import(new DataPendudukImport, $this->excelFile->getRealPath());

            session()->flash('message', 'Data Excel berjaya diimport.');
            $this->excelFile = null;
        } catch (\Exception $e) {
            session()->flash('error', 'Ralat semasa import: ' . $e->getMessage());
            Log::error('Excel import error: ' . $e->getMessage());
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        $dataPenduduks = DataPenduduk::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('nama_dm', 'like', '%' . $this->search . '%')
                        ->orWhere('kod_lokaliti', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_lokaliti', 'like', '%' . $this->search . '%')
                        ->orWhere('no_siri', 'like', '%' . $this->search . '%')
                        ->orWhere('no_kp_baru', 'like', '%' . $this->search . '%')
                        ->orWhere('nama_pemilih', 'like', '%' . $this->search . '%')
                        ->orWhere('bangsa', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat_kp', 'like', '%' . $this->search . '%')
                        ->orWhere('alamat_kediaman', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedNamaDm, function ($query) {
                $query->where('nama_dm', $this->selectedNamaDm);
            })
            ->when($this->selectedNamaLokaliti, function ($query) {
                $query->where('nama_lokaliti', $this->selectedNamaLokaliti);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.data-penduduk.data-penduduk-index', compact('dataPenduduks'));
    }
}
