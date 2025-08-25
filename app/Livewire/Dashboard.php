<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bisnes;
use App\Models\Produk;
use App\Models\Prospek;
use App\Models\ProspekBuy;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $totalBisnes = 0;
    public $totalProduk = 0;
    public $totalProspek = 0;
    public $totalPembelian = 0;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalBisnes = Bisnes::where('user_id', Auth::id())->count();
        $this->totalProduk = Produk::count();
        $this->totalProspek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
        $this->totalPembelian = ProspekBuy::whereHas('prospekAlamat.prospek.bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->count();
    }

    public function refreshStats()
    {
        $this->loadStats();
        $this->dispatch('stats-updated');
    }

    protected $listeners = ['refreshStats'];

    public function render()
    {
        return view('livewire.dashboard');
    }
}
