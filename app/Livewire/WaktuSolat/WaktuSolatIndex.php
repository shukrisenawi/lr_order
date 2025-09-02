<?php

namespace App\Livewire\WaktuSolat;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\WaktuSolat;
use App\Imports\WaktuSolatImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;

class WaktuSolatIndex extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $excelFile;
    public $loading = false;
    public $selectedPrayerTime = '';
    public $isBlinking = false;
    public $showResetModal = false;
    public $adminPassword = '';
    public $showDeleteModal = false;
    public $deletePassword = '';

    protected $queryString = ['search'];

    public function mount()
    {
        $this->checkBlinking();
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

    public function updatedSelectedPrayerTime()
    {
        $this->checkBlinking();
    }

    public function refreshBlinking()
    {
        $this->checkBlinking();
    }

    private function checkBlinking()
    {
        if (!$this->selectedPrayerTime) {
            $this->isBlinking = false;
            return;
        }

        // Get today's prayer times
        $today = now()->toDateString();
        $waktu = WaktuSolat::where('tarikh', $today)->first();

        if (!$waktu) {
            $this->isBlinking = false;
            return;
        }

        $prayerTimes = [
            'imsak' => $waktu->imsak,
            'subuh' => $waktu->subuh,
            'syuruk' => $waktu->syuruk,
            'zohor' => $waktu->zohor,
            'asar' => $waktu->asar,
            'maghrib' => $waktu->maghrib,
            'isyak' => $waktu->isyak,
        ];

        if (!isset($prayerTimes[$this->selectedPrayerTime])) {
            $this->isBlinking = false;
            return;
        }

        $prayerTime = $prayerTimes[$this->selectedPrayerTime];
        $currentTime = now();
        $prayerDateTime = \Carbon\Carbon::createFromFormat('H:i', $prayerTime, $currentTime->timezone)->setDate($currentTime->year, $currentTime->month, $currentTime->day);

        $timeDiff = $currentTime->diffInMinutes($prayerDateTime, false);

        // Blink when prayer time is 5 minutes or less away (approaching)
        $this->isBlinking = $timeDiff <= 5 && $timeDiff >= 0;
    }

    public function showResetModal()
    {
        $this->showResetModal = true;
        $this->adminPassword = '';
    }

    public function closeResetModal()
    {
        $this->showResetModal = false;
        $this->adminPassword = '';
    }

    public function resetDatabase()
    {
        // Verify password - you can change this to a more secure method
        if ($this->adminPassword !== 'admin123') {
            session()->flash('error', 'Kata laluan admin salah.');
            return;
        }

        try {
            Artisan::call('migrate:fresh', ['--seed' => true]);
            session()->flash('message', 'Database berjaya direset dan diseed.');
        } catch (\Exception $e) {
            session()->flash('error', 'Ralat semasa reset database: ' . $e->getMessage());
            Log::error('Database reset error: ' . $e->getMessage());
        }

        $this->closeResetModal();
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
        WaktuSolat::truncate();
        session()->flash('message', 'Semua data waktu solat telah dipadamkan.');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletePassword = '';
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
