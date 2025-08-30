<?php

namespace App\Livewire\Iklan;

use Livewire\Component;
use App\Models\Iklan;
use Illuminate\Support\Facades\Session;

class IklanForm extends Component
{
    public $nama_iklan = '';
    public $keterangan = '';
    public $hari = '';
    public $on = false;
    public $iklan;

    protected $rules = [
        'nama_iklan' => 'required|string|max:255',
        'keterangan' => 'required|string',
        'hari' => 'required|integer|min:1',
        'on' => 'boolean',
    ];

    public function mount($iklan = null)
    {
        if ($iklan) {
            $this->iklan = $iklan;
            $this->nama_iklan = $iklan->nama_iklan;
            $this->keterangan = $iklan->keterangan;
            $this->hari = $iklan->hari;
            $this->on = $iklan->on;
        } else {
            // Set default hari for new iklan
            $latestDay = Iklan::where('bisnes_id', session('selected_bisnes_id'))->max('hari') ?? 0;
            $this->hari = $latestDay + 1;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'bisnes_id' => session('selected_bisnes_id'),
            'nama_iklan' => $this->nama_iklan,
            'keterangan' => $this->keterangan,
            'hari' => $this->hari,
            'on' => $this->on,
        ];

        if ($this->iklan) {
            $this->iklan->update($data);
            session()->flash('message', 'Iklan updated successfully.');
        } else {
            Iklan::create($data);
            session()->flash('message', 'Iklan created successfully.');
        }

        return redirect()->route('iklan.index');
    }

    public function render()
    {
        return view('livewire.iklan.iklan-form');
    }
}
