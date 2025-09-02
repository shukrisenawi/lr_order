<?php

namespace App\Livewire\Pengumuman;

use Livewire\Component;
use App\Models\Pengumuman;

class PengumumanForm extends Component
{
    public $pengumuman;
    public $pengumuman_text = '';
    public $tarikh = '';
    public $isEdit = false;

    protected $rules = [
        'pengumuman_text' => 'required|string',
        'tarikh' => 'required|date',
    ];

    protected $messages = [
        'pengumuman_text.required' => 'Pengumuman diperlukan.',
        'pengumuman_text.string' => 'Pengumuman mestilah teks.',
        'tarikh.required' => 'Tarikh diperlukan.',
        'tarikh.date' => 'Tarikh tidak sah.',
    ];

    public function mount($pengumuman = null)
    {
        if ($pengumuman) {
            $this->pengumuman = $pengumuman;
            $this->isEdit = true;
            $this->pengumuman_text = $pengumuman->pengumuman;
            $this->tarikh = $pengumuman->tarikh ? $pengumuman->tarikh->format('Y-m-d') : '';
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'pengumuman' => $this->pengumuman_text,
            'tarikh' => $this->tarikh,
        ];

        if ($this->isEdit) {
            $this->pengumuman->update($data);
            session()->flash('success', 'Pengumuman berjaya dikemaskini.');
        } else {
            Pengumuman::create($data);
            session()->flash('success', 'Pengumuman berjaya dicipta.');
        }

        return redirect()->route('pengumuman.index');
    }

    public function render()
    {
        return view('livewire.pengumuman.pengumuman-form');
    }
}