<?php

namespace App\Livewire\TenagaPengajar;

use Livewire\Component;
use App\Models\TenagaPengajar;
use Livewire\WithFileUploads;

class TenagaPengajarForm extends Component
{
    use WithFileUploads;

    public TenagaPengajar $tenagaPengajar;
    public $nama;
    public $no_tel;
    public $alamat;
    public $gambar;
    public $status = true;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'no_tel' => 'required|string|max:20',
        'alamat' => 'nullable|string',
        'gambar' => 'nullable|image|max:2048',
        'status' => 'boolean',
    ];

    public function mount(TenagaPengajar $tenagaPengajar = null)
    {
        if ($tenagaPengajar->exists) {
            $this->tenagaPengajar = $tenagaPengajar;
            $this->nama = $tenagaPengajar->nama;
            $this->no_tel = $tenagaPengajar->no_tel;
            $this->alamat = $tenagaPengajar->alamat;
            $this->status = $tenagaPengajar->status;
        } else {
            $this->tenagaPengajar = new TenagaPengajar();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'no_tel' => $this->no_tel,
            'alamat' => $this->alamat,
            'status' => $this->status,
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('tenaga-pengajar', 'public');
        }

        if ($this->tenagaPengajar->exists) {
            $this->tenagaPengajar->update($data);
            session()->flash('message', 'Tenaga Pengajar updated successfully.');
        } else {
            TenagaPengajar::create($data);
            session()->flash('message', 'Tenaga Pengajar created successfully.');
        }

        return redirect()->route('tenaga-pengajar.index');
    }

    public function render()
    {
        return view('livewire.tenaga-pengajar.tenaga-pengajar-form');
    }
}