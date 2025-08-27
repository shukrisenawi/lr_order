<?php

namespace App\Livewire\CustomerBuy;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerBuy;
use Illuminate\Support\Facades\Auth;

class CustomerBuyIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $totalRevenue = 0;
    public $totalPurchases = 0;
    public $averageOrder = 0;

    protected $queryString = ['search'];

    public function mount()
    {
        $this->calculateStats();
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
        $customerBuy = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $customerBuy->delete();

        session()->flash('message', 'Purchase deleted successfully.');
        $this->calculateStats();
        $this->dispatch('purchase-deleted');
    }

    public function calculateStats()
    {
        $purchases = CustomerBuy::whereHas('customerAlamat.customer.bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $this->totalPurchases = $purchases->count();
        $this->totalRevenue = $purchases->sum(function ($item) {
            return ($item->kuantiti ?? 1) * ($item->harga ?? 0);
        });
        $this->averageOrder = $this->totalPurchases > 0 ? $this->totalRevenue / $this->totalPurchases : 0;
    }

    public function refreshData()
    {
        $this->calculateStats();
        $this->dispatch('data-refreshed');
    }

    public function render()
    {
        $customerBuy = CustomerBuy::with(['customerAlamat.customer.bisnes', 'produk'])
            ->whereHas('customerAlamat.customer.bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('customerAlamat.customer', function ($customerQuery) {
                        $customerQuery->where('no_tel', 'like', '%' . $this->search . '%')
                            ->orWhere('gelaran', 'like', '%' . $this->search . '%');
                    })
                        ->orWhereHas('produk', function ($produkQuery) {
                            $produkQuery->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.customer-buy.customer-buy-index', compact('customerBuy'));
    }
}
