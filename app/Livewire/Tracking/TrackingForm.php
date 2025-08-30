<?php

namespace App\Livewire\Tracking;

use Livewire\Component;
use App\Models\Tracking;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class TrackingForm extends Component
{
    public $tracking;
    public $invoice_id;
    public $kurier = 'J&T';
    public $nama_penerima;
    public $alamat;
    public $poskod;
    public $no_tel;
    public $kandungan_parcel;
    public $jenis_parcel;
    public $berat;
    public $panjang;
    public $lebar;
    public $tinggi;

    protected $rules = [
        'invoice_id' => 'nullable|exists:invoice,id',
        'kurier' => 'nullable|string|max:255',
        'nama_penerima' => 'required|string|max:255',
        'alamat' => 'required|string',
        'poskod' => 'required|string|max:10',
        'no_tel' => 'required|string|max:20',
        'kandungan_parcel' => 'nullable|string',
        'jenis_parcel' => 'nullable|string',
        'berat' => 'nullable|string',
        'panjang' => 'nullable|string',
        'lebar' => 'nullable|string',
        'tinggi' => 'nullable|string',
    ];

    public function mount($tracking = null)
    {
        if ($tracking) {
            $this->tracking = $tracking;
            $this->invoice_id = $tracking->invoice_id;
            $this->kurier = $tracking->kurier;
            $this->nama_penerima = $tracking->nama_penerima;
            $this->alamat = $tracking->alamat;
            $this->poskod = $tracking->poskod;
            $this->no_tel = $tracking->no_tel;
            $this->kandungan_parcel = $tracking->kandungan_parcel;
            $this->jenis_parcel = $tracking->jenis_parcel;
            $this->berat = $tracking->berat;
            $this->panjang = $tracking->panjang;
            $this->lebar = $tracking->lebar;
            $this->tinggi = $tracking->tinggi;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'invoice_id' => $this->invoice_id,
            'bisnes_id' => session('selected_bisnes_id'),
            'kurier' => $this->kurier,
            'nama_penerima' => $this->nama_penerima,
            'alamat' => $this->alamat,
            'poskod' => $this->poskod,
            'no_tel' => $this->no_tel,
            'kandungan_parcel' => $this->kandungan_parcel,
            'jenis_parcel' => $this->jenis_parcel,
            'berat' => $this->berat,
            'panjang' => $this->panjang,
            'lebar' => $this->lebar,
            'tinggi' => $this->tinggi,
        ];

        if ($this->tracking) {
            $this->tracking->update($data);
            session()->flash('message', 'Tracking updated successfully.');
        } else {
            Tracking::create($data);
            session()->flash('message', 'Tracking created successfully.');
        }

        return redirect()->route('tracking.index');
    }

    public function render()
    {
        $invoices = Invoice::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('livewire.tracking.tracking-form', compact('invoices'));
    }
}
