<?php

namespace App\Livewire;

use App\Models\ScanCula;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

class ScanCulaCrud extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $no_kp, $nama_pemilih, $alamat, $cula, $approve, $scanCulaId, $isOpen = 0;
    public $search = '';
    public $activeTab = 'baru'; // 'baru' untuk approve=0, 'rekod' untuk approve=1
    public $selectedItems = []; // Array of selected item IDs
    public $selectAll = false; // Master checkbox state

    protected $queryString = ['search', 'activeTab'];


    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function render()
    {
        $query = ScanCula::query();

        // Filter berdasarkan tab aktif
        if ($this->activeTab === 'baru') {
            $query->where('approve', false);
        } elseif ($this->activeTab === 'rekod') {
            $query->where('approve', true);
        }

        // Filter pencarian
        $query->when($this->search, function ($query) {
            $query->where(function ($q) {
                $q->where('no_kp', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pemilih', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('cula', 'like', '%' . $this->search . '%');
            });
        });

        return view('livewire.scan-cula-crud', [
            'scanCulas' => $query->paginate(30)
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

        session()->flash(
            'message',
            $this->scanCulaId ? 'Data berhasil diperbarui.' : 'Data berhasil dibuat.'
        );

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

    public function approve($id)
    {
        $scanCula = ScanCula::findOrFail($id);
        $scanCula->update(['approve' => true]);
        session()->flash('message', 'Data berhasil disetujui.');
    }

    public function unapprove($id)
    {
        $scanCula = ScanCula::findOrFail($id);
        $scanCula->update(['approve' => false]);
        session()->flash('message', 'Persetujuan data berhasil dibatalkan.');
    }

    public function bulkApprove()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item terlebih dahulu.');
            return;
        }

        ScanCula::whereIn('id', $this->selectedItems)->update(['approve' => true]);

        $count = count($this->selectedItems);
        $this->selectedItems = [];
        $this->selectAll = false;

        session()->flash('message', "{$count} data berhasil disetujui.");
    }

    public function bulkUnapprove()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item terlebih dahulu.');
            return;
        }

        ScanCula::whereIn('id', $this->selectedItems)->update(['approve' => false]);

        $count = count($this->selectedItems);
        $this->selectedItems = [];
        $this->selectAll = false;

        session()->flash('message', "{$count} persetujuan data berhasil dibatalkan.");
    }

    public function bulkDelete()
    {
        if (empty($this->selectedItems)) {
            session()->flash('error', 'Pilih item terlebih dahulu.');
            return;
        }

        ScanCula::whereIn('id', $this->selectedItems)->delete();

        $count = count($this->selectedItems);
        $this->selectedItems = [];
        $this->selectAll = false;

        session()->flash('message', "{$count} data berhasil dihapus.");
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedItems = $this->getCurrentScanCulas()->pluck('id')->toArray();
        } else {
            $this->selectedItems = [];
        }
    }

    public function updatedSelectedItems()
    {
        $currentItems = $this->getCurrentScanCulas()->pluck('id')->toArray();
        $this->selectAll = !empty($currentItems) && count(array_intersect($this->selectedItems, $currentItems)) === count($currentItems);
    }

    private function getCurrentScanCulas()
    {
        $query = ScanCula::query();

        // Apply same filters as in render method
        if ($this->activeTab === 'baru') {
            $query->where('approve', false);
        } elseif ($this->activeTab === 'rekod') {
            $query->where('approve', true);
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('no_kp', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_pemilih', 'like', '%' . $this->search . '%')
                    ->orWhere('alamat', 'like', '%' . $this->search . '%')
                    ->orWhere('cula', 'like', '%' . $this->search . '%');
            });
        }

        return $query->get();
    }
}
