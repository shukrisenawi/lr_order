<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Produk;
use App\Models\Bisnes;
use Illuminate\Support\Facades\Auth;

class InvoiceForm extends Component
{
    public $invoice;
    public $bisnes_id;
    public $nama_penerima;
    public $alamat;
    public $no_tel;
    public $kurier;
    public $catatan;
    public $status = 'pending';
    public $items = [];
    public $bisnes_list = [];
    public $produk_list = [];
    public $isEdit = false;

    protected $rules = [
        'bisnes_id' => 'required|exists:bisnes,id',
        'nama_penerima' => 'required|string|max:255',
        'alamat' => 'required|string',
        'no_tel' => 'required|string|max:20',
        'kurier' => 'nullable|string|max:255',
        'catatan' => 'nullable|string',
        'status' => 'required|in:pending,paid,cancelled',
        'items' => 'required|array|min:1',
        'items.*.produk_id' => 'nullable|exists:produk,id',
        'items.*.produk_custom' => 'nullable|string|max:255',
        'items.*.kuantiti' => 'required|integer|min:1',
        'items.*.harga' => 'required|numeric|min:0',
    ];

    public function mount($invoice = null)
    {
        $this->bisnes_list = Bisnes::where('user_id', Auth::id())->get();
        $this->produk_list = Produk::where('bisnes_id', session('selected_bisnes_id'))->get();

        if ($invoice) {
            $this->isEdit = true;
            $this->invoice = $invoice;
            $this->bisnes_id = $invoice->bisnes_id;
            $this->nama_penerima = $invoice->nama_penerima;
            $this->alamat = $invoice->alamat;
            $this->no_tel = $invoice->no_tel;
            $this->kurier = $invoice->kurier;
            $this->catatan = $invoice->catatan;
            $this->status = $invoice->status;

            $this->items = $invoice->items->map(function ($item) {
                return [
                    'produk_id' => $item->produk_id,
                    'produk_custom' => $item->produk_custom,
                    'kuantiti' => $item->kuantiti,
                    'harga' => $item->harga,
                ];
            })->toArray();
        } else {
            $this->addItem();
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'produk_id' => null,
            'produk_custom' => '',
            'kuantiti' => 1,
            'harga' => 0,
        ];
    }

    public function removeItem($index)
    {
        if (count($this->items) > 1) {
            unset($this->items[$index]);
            $this->items = array_values($this->items);
        }
    }

    public function updatedItemsProdukId($value, $key)
    {
        $index = explode('.', $key)[0];
        if ($value) {
            $produk = Produk::find($value);
            if ($produk) {
                $this->items[$index]['harga'] = $produk->harga;
                $this->items[$index]['produk_custom'] = '';
            }
        }
    }

    public function save()
    {
        $this->validate();

        // Verify bisnes belongs to authenticated user
        $bisnes = Bisnes::where('id', $this->bisnes_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($this->isEdit) {
            $this->invoice->update([
                'bisnes_id' => $this->bisnes_id,
                'nama_penerima' => $this->nama_penerima,
                'alamat' => $this->alamat,
                'no_tel' => $this->no_tel,
                'kurier' => $this->kurier,
                'catatan' => $this->catatan,
                'status' => $this->status,
            ]);

            // Delete existing items and add new ones
            $this->invoice->items()->delete();
        } else {
            $this->invoice = Invoice::create([
                'bisnes_id' => $this->bisnes_id,
                'nama_penerima' => $this->nama_penerima,
                'alamat' => $this->alamat,
                'no_tel' => $this->no_tel,
                'kurier' => $this->kurier,
                'catatan' => $this->catatan,
                'status' => $this->status,
                'jumlah' => 0,
            ]);
        }

        // Add invoice items
        foreach ($this->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $this->invoice->id,
                'produk_id' => $item['produk_id'] ?: null,
                'produk_custom' => $item['produk_custom'] ?: null,
                'kuantiti' => $item['kuantiti'],
                'harga' => $item['harga'],
            ]);
        }

        // Update total
        $this->invoice->updateTotal();

        session()->flash('message', $this->isEdit ? 'Invoice updated successfully!' : 'Invoice created successfully!');

        return redirect()->route('invoice.show', $this->invoice);
    }

    public function getTotal()
    {
        return collect($this->items)->sum(function ($item) {
            return $item['kuantiti'] * $item['harga'];
        });
    }

    public function render()
    {
        return view('livewire.invoice.invoice-form');
    }
}
