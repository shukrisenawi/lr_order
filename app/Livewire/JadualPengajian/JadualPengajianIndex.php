<?php

namespace App\Livewire\JadualPengajian;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\JadualPengajian;
use App\Imports\JadualPengajianImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;

class JadualPengajianIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $excelFile;
    public $loading = false;

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
        $jadual = JadualPengajian::findOrFail($id);
        $jadual->delete();

        session()->flash('message', 'Jadual pengajian deleted successfully.');
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

            Excel::import(new JadualPengajianImport, $this->excelFile->getRealPath());

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
        $jaduals = JadualPengajian::when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('hari', 'like', '%' . $this->search . '%')
                    ->orWhere('masa', 'like', '%' . $this->search . '%')
                    ->orWhere('penceramah_program', 'like', '%' . $this->search . '%')
                    ->orWhere('topik_kitab', 'like', '%' . $this->search . '%')
                    ->orWhere('tempat', 'like', '%' . $this->search . '%');
            });
        })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.jadual-pengajian.jadual-pengajian-index', compact('jaduals'));
    }
}
