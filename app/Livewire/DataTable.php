<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Bisnes;
use App\Models\Produk;
use App\Models\Prospek;
use App\Models\ProspekBuy;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DataTable extends Component
{
    use WithPagination;

    public $activeTab = 'bisnes';
    public $search = '';
    public $lastRefresh;

    protected $queryString = ['activeTab', 'search'];

    public function mount()
    {
        $this->lastRefresh = now()->format('H:i:s');
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
        $this->search = '';
    }

    public function refreshData()
    {
        $this->lastRefresh = now()->format('H:i:s');
        $this->resetPage();
        $this->dispatch('data-refreshed');
    }

    public function getBisnesData()
    {
        return Bisnes::where('user_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->where('nama_bisnes', 'like', '%' . $this->search . '%')
                    ->orWhere('jenis_bisnes', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getProdukData()
    {
        return Produk::when($this->search, function ($query) {
            $query->where('nama_produk', 'like', '%' . $this->search . '%')
                ->orWhere('kategori', 'like', '%' . $this->search . '%');
        })
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getProspekData()
    {
        return Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('telefon', 'like', '%' . $this->search . '%');
            })
            ->with('bisnes')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getPembelianData()
    {
        return ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })
            ->when($this->search, function ($query) {
                $query->whereHas('prospekAlamat.prospek', function ($q) {
                    $q->where('nama', 'like', '%' . $this->search . '%');
                });
            })
            ->with(['prospekAlamat.prospek.bisnes', 'produk'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $data = [];

        switch ($this->activeTab) {
            case 'bisnes':
                $data = $this->getBisnesData();
                break;
            case 'produk':
                $data = $this->getProdukData();
                break;
            case 'prospek':
                $data = $this->getProspekData();
                break;
            case 'pembelian':
                $data = $this->getPembelianData();
                break;
        }

        return view('livewire.data-table', [
            'data' => $data,
            'totalRecords' => $data->total()
        ]);
    }
}
