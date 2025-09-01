<?php

namespace App\Livewire\AnakKhariah;

use Livewire\Component;
use App\Models\AnakKhariah;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;

class AnakKhariahForm extends Component
{
    use WithFileUploads;

    public AnakKhariah $anakKhariah;
    public $nama;
    public $gelaran;
    public $alamat;
    public $tarikh_lahir;
    public $no_tel;
    public $gambar;
    public $on = true;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'gelaran' => 'nullable|string|max:255',
        'alamat' => 'nullable|string',
        'tarikh_lahir' => 'nullable|date',
        'no_tel' => 'required|string|max:20',
        'gambar' => 'nullable|image|max:2048',
        'on' => 'boolean',
    ];

    public function mount(AnakKhariah $anakKhariah = null)
    {
        if ($anakKhariah->exists) {
            $this->anakKhariah = $anakKhariah;
            $this->nama = $anakKhariah->nama;
            $this->gelaran = $anakKhariah->gelaran;
            $this->alamat = $anakKhariah->alamat;
            $this->tarikh_lahir = $anakKhariah->tarikh_lahir?->format('Y-m-d');
            $this->no_tel = $anakKhariah->no_tel;
            $this->on = $anakKhariah->on;
        } else {
            $this->anakKhariah = new AnakKhariah();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'gelaran' => $this->gelaran,
            'alamat' => $this->alamat,
            'tarikh_lahir' => $this->tarikh_lahir,
            'no_tel' => $this->no_tel,
            'on' => $this->on,
            'bisnes_id' => session('selected_bisnes_id'),
        ];

        if ($this->gambar) {
            $data['gambar'] = $this->gambar->store('anak-khariah', 'public');
        }

        if ($this->anakKhariah->exists) {
            $this->anakKhariah->update($data);
            session()->flash('message', 'Anak Khariah updated successfully.');
        } else {
            AnakKhariah::create($data);
            session()->flash('message', 'Anak Khariah created successfully.');
        }

        return redirect()->route('anak-khariah.index');
    }

    public function render()
    {
        return view('livewire.anak-khariah.anak-khariah-form');
    }
}