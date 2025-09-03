<?php

namespace App\Livewire\Invoice;

use Livewire\Component;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Produk;
use App\Models\Bisnes;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;

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
    public $produk_list = [];
    public $isEdit = false;

    // Customer search properties
    public $customer_search = '';
    public $customer_results = [];
    public $selected_customer_id = null;
    public $show_customer_dropdown = false;

    protected $rules = [
        'nama_penerima' => 'required|string|max:255',
        'alamat' => 'required|string',
        'no_tel' => 'required|string|max:20',
        'kurier' => 'nullable|string|max:255',
        'catatan' => 'nullable|string',
        'status' => 'required|in:pending,paid,cancelled',
        'items' => 'required|array|min:1',
        'items.*.produk_id' => 'nullable|exists:produk,id',
        'items.*.produk_custom' => 'nullable|string|max:255',
        'items.*.kuantiti' => 'required|numeric|min:0.01|regex:/^\d+(\.\d{1,2})?$/',
        'items.*.harga_seunit' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
        'items.*.harga' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
    ];

    protected $messages = [
        'items.*.kuantiti.regex' => 'Kuantiti mestilah dalam format yang betul (contoh: 1.50)',
        'items.*.harga_seunit.regex' => 'Harga seunit mestilah dalam format yang betul (contoh: 10.50)',
        'items.*.harga.regex' => 'Jumlah harga mestilah dalam format yang betul (contoh: 25.75)',
    ];

    public function mount($invoice = null, $customer = null)
    {
        $selectedBisnes = \App\Models\Bisnes::find(session('selected_bisnes_id'));
        if (!$selectedBisnes || $selectedBisnes->type_id != 1) {
            return redirect()->route('dashboard');
        }

        $this->produk_list = Produk::where('bisnes_id', session('selected_bisnes_id'))->get();
        $this->bisnes_id = session('selected_bisnes_id');

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
                    'harga_seunit' => $item->harga_seunit ?? 0,
                    'harga' => $item->harga,
                ];
            })->toArray();
        } else {
            // Pre-fill customer data if provided
            if ($customer) {
                $this->nama_penerima = $customer->nama_penerima;
                $this->alamat = $customer->alamat;
                $this->no_tel = $customer->no_tel;
            }

            $this->addItem();
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'produk_id' => null,
            'produk_custom' => '',
            'kuantiti' => 1,
            'harga_seunit' => 0,
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

    public function updatedCustomerSearch($value)
    {
        if (strlen($value) >= 2) {
            $this->customer_results = Customer::where('bisnes_id', $this->bisnes_id)
                ->where(function ($query) use ($value) {
                    $query->where('nama_penerima', 'like', '%' . $value . '%')
                          ->orWhere('no_tel', 'like', '%' . $value . '%')
                          ->orWhere('email', 'like', '%' . $value . '%');
                })
                ->limit(10)
                ->get();
            $this->show_customer_dropdown = true;
        } else {
            $this->customer_results = [];
            $this->show_customer_dropdown = false;
        }
    }

    public function selectCustomer($customerId)
    {
        $customer = Customer::find($customerId);
        if ($customer) {
            $this->nama_penerima = $customer->nama_penerima;
            $this->alamat = $customer->alamat;
            $this->no_tel = $customer->no_tel;
            $this->selected_customer_id = $customerId;
            $this->customer_search = $customer->nama_penerima;
            $this->show_customer_dropdown = false;
        }
    }

    public function clearCustomerSelection()
    {
        $this->selected_customer_id = null;
        $this->customer_search = '';
        $this->customer_results = [];
        $this->show_customer_dropdown = false;
    }

    public function updatedItemsProdukId($value, $key)
    {
        $index = explode('.', $key)[0];
        if ($value) {
            $produk = Produk::find($value);
            if ($produk) {
                $this->items[$index]['harga_seunit'] = $produk->harga;
                $this->items[$index]['produk_custom'] = '';
                $this->calculateItemTotal($index);
            }
        }
    }

    public function updatedItemsKuantiti($value, $key)
    {
        $index = explode('.', $key)[0];
        $this->calculateItemTotal($index);
    }

    public function updatedItemsHargaSeunit($value, $key)
    {
        $index = explode('.', $key)[0];
        $this->calculateItemTotal($index);
    }

    public function updatedItemsHarga($value, $key)
    {
        $index = explode('.', $key)[0];
        $this->calculateItemHargaSeunit($index);
    }

    public function updatedItems($value, $key)
    {
        // Handle any changes to items array
        if (preg_match('/^(\d+)\.(kuantiti|harga_seunit)$/', $key, $matches)) {
            $index = $matches[1];
            $this->calculateItemTotal($index);
        }
    }

    public function calculateItemTotal($index)
    {
        if (isset($this->items[$index])) {
            $kuantiti = !empty($this->items[$index]['kuantiti']) ? (float)$this->items[$index]['kuantiti'] : 0;
            $hargaSeunit = !empty($this->items[$index]['harga_seunit']) ? (float)$this->items[$index]['harga_seunit'] : 0;
            $this->items[$index]['harga'] = $kuantiti * $hargaSeunit;
        }
    }

    private function calculateItemHargaSeunit($index)
    {
        if (isset($this->items[$index])) {
            $kuantiti = !empty($this->items[$index]['kuantiti']) ? (float)$this->items[$index]['kuantiti'] : 0;
            $harga = !empty($this->items[$index]['harga']) ? (float)$this->items[$index]['harga'] : 0;
            if ($kuantiti > 0) {
                $this->items[$index]['harga_seunit'] = $harga / $kuantiti;
            }
        }
    }

    public function save()
    {
        $this->validate();

        if ($this->isEdit) {
            $this->invoice->update([
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
                'harga_seunit' => $item['harga_seunit'] ?? 0,
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
        return (float)collect($this->items)->sum(function ($item) {
            $kuantiti = !empty($item['kuantiti']) ? (float)$item['kuantiti'] : 0;
            $harga = !empty($item['harga']) ? (float)$item['harga'] : 0;
            return $kuantiti * $harga;
        });
    }

    #[Computed]
    public function itemTotals()
    {
        $totals = [];
        foreach ($this->items as $index => $item) {
            $kuantiti = !empty($item['kuantiti']) ? (float)$item['kuantiti'] : 0;
            $hargaSeunit = !empty($item['harga_seunit']) ? (float)$item['harga_seunit'] : 0;
            $totals[$index] = $kuantiti * $hargaSeunit;
        }
        return $totals;
    }

    public function getItemTotal($index)
    {
        if (isset($this->items[$index])) {
            $kuantiti = !empty($this->items[$index]['kuantiti']) ? (float)$this->items[$index]['kuantiti'] : 0;
            $hargaSeunit = !empty($this->items[$index]['harga_seunit']) ? (float)$this->items[$index]['harga_seunit'] : 0;
            return $kuantiti * $hargaSeunit;
        }
        return 0;
    }

    public function render()
    {
        return view('livewire.invoice.invoice-form');
    }
}
