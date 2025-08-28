<?php

namespace App\Livewire\Produk;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Produk;

class ProdukIndex extends Component
{

    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

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
        $produk = Produk::findOrFail($id);
        $produk->delete();

        session()->flash('message', 'Product deleted successfully.');
        $this->dispatch('product-deleted');
    }

    public function render()
    {
        $produk = Produk::with('gambar')
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(10);

        return view('livewire.produk.produk-index', compact('produk'));
    }
}
