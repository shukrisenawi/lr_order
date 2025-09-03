<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use App\Models\Produk;
use App\Models\InvoiceItem;

class InvoiceItemForm extends Component
{
    public $produk_id;
    public $produk_custom = '';
    public $kuantiti = 1;
    public $harga_seunit = 0;
    public $harga = 0;
    public $produk_list = [];

    protected $rules = [
        'produk_id' => 'nullable|exists:produk,id',
        'produk_custom' => 'nullable|string|max:255',
        'kuantiti' => 'required|integer|min:1',
        'harga_seunit' => 'required|numeric|min:0',
        'harga' => 'required|numeric|min:0',
    ];

    public function mount($item = null)
    {
        $this->produk_list = Produk::where('bisnes_id', session('selected_bisnes_id'))->get();

        if ($item) {
            $this->produk_id = $item->produk_id;
            $this->produk_custom = $item->produk_custom;
            $this->kuantiti = $item->kuantiti;
            $this->harga_seunit = $item->harga_seunit ?? 0;
            $this->harga = $item->harga;
        }
    }

    public function updatedProdukId($value)
    {
        if ($value) {
            $produk = Produk::find($value);
            if ($produk) {
                $this->harga_seunit = $produk->harga;
                $this->produk_custom = '';
                $this->calculateHarga();
            }
        }
    }

    public function updatedKuantiti($value)
    {
        $this->calculateHarga();
    }

    public function updatedHargaSeunit($value)
    {
        $this->calculateHarga();
    }

    public function updatedHarga($value)
    {
        $this->calculateHargaSeunit();
    }

    private function calculateHarga()
    {
        if ($this->kuantiti > 0 && $this->harga_seunit > 0) {
            $this->harga = $this->kuantiti * $this->harga_seunit;
        }
    }

    private function calculateHargaSeunit()
    {
        if ($this->kuantiti > 0 && $this->harga > 0) {
            $this->harga_seunit = $this->harga / $this->kuantiti;
        }
    }

    public function saveItem()
    {
        $this->validate();

        return [
            'produk_id' => $this->produk_id,
            'produk_custom' => $this->produk_custom,
            'kuantiti' => $this->kuantiti,
            'harga_seunit' => $this->harga_seunit,
            'harga' => $this->harga,
        ];
    }

    public function resetForm()
    {
        $this->produk_id = null;
        $this->produk_custom = '';
        $this->kuantiti = 1;
        $this->harga_seunit = 0;
        $this->harga = 0;
    }

    public function render()
    {
        return view('livewire.invoice.invoice-item-form');
    }
}
