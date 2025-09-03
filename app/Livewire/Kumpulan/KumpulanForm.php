<?php

namespace App\Livewire\Kumpulan;

use Livewire\Component;
use App\Models\Kumpulan;
use Illuminate\Support\Facades\Auth;

class KumpulanForm extends Component
{
    public Kumpulan $kumpulan;
    public $nama;
    public $description;
    public $on = true;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'description' => 'nullable|string',
        'on' => 'boolean',
    ];

    public function mount(Kumpulan $kumpulan = null)
    {
        if (session('selected_bisnes_id') != 3) {
            return redirect()->route('dashboard');
        }

        if ($kumpulan->exists) {
            $this->kumpulan = $kumpulan;
            $this->nama = $kumpulan->nama;
            $this->description = $kumpulan->description;
            $this->on = $kumpulan->on;
        } else {
            $this->kumpulan = new Kumpulan();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama' => $this->nama,
            'description' => $this->description,
            'on' => $this->on,
            'bisnes_id' => session('selected_bisnes_id'),
        ];

        if ($this->kumpulan->exists) {
            $this->kumpulan->update($data);
            session()->flash('message', 'Kumpulan updated successfully.');
        } else {
            Kumpulan::create($data);
            session()->flash('message', 'Kumpulan created successfully.');
        }

        return redirect()->route('kumpulan.index');
    }

    public function render()
    {
        return view('livewire.kumpulan.kumpulan-form');
    }
}