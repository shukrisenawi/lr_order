<?php

namespace App\Livewire\WaktuSolat;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\WaktuSolat;
use App\Imports\WaktuSolatImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class WaktuSolatIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $excelFile;
    public $loading = false;

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
        $waktu = WaktuSolat::findOrFail($id);
        $waktu->delete();

        session()->flash('message', 'Waktu solat deleted successfully.');
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

            Excel::import(new WaktuSolatImport, $this->excelFile->getRealPath());

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
        $waktus = WaktuSolat::when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('tarikh', 'like', '%' . $this->search . '%')
                        ->orWhere('tarikh_hijrah', 'like', '%' . $this->search . '%')
                        ->orWhere('hari', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.waktu-solat.waktu-solat-index', compact('waktus'));
    }
}
