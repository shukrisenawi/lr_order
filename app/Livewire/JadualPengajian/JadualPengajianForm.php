<?php

namespace App\Livewire\JadualPengajian;

use Livewire\Component;
use App\Models\JadualPengajian;

class JadualPengajianForm extends Component
{
    public $jadual;
    public $hari = '';
    public $minggu = '';
    public $masa = '';
    public $penceramah_program = '';
    public $topik_kitab = '';
    public $tempat = '';
    public $isEdit = false;

    protected $rules = [
        'hari' => 'nullable|string|max:255',
        'minggu' => 'nullable|integer|min:1|max:5',
        'masa' => 'nullable|string|max:255',
        'penceramah_program' => 'nullable|string|max:255',
        'topik_kitab' => 'nullable|string|max:255',
        'tempat' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'hari.required' => 'Hari diperlukan.',
        'minggu.required' => 'Minggu diperlukan.',
        'minggu.integer' => 'Minggu mestilah nombor.',
        'minggu.min' => 'Minggu minimum 1.',
        'minggu.max' => 'Minggu maksimum 5.',
        'masa.required' => 'Masa diperlukan.',
        'penceramah_program.required' => 'Penceramah/Program diperlukan.',
        'topik_kitab.required' => 'Topik/Kitab diperlukan.',
        'tempat.required' => 'Tempat diperlukan.',
    ];

    public function mount($jadual = null)
    {
        if ($jadual) {
            $this->jadual = $jadual;
            $this->isEdit = true;
            $this->hari = $jadual->hari;
            $this->minggu = $jadual->minggu ? (string) $jadual->minggu : '';
            $this->masa = $jadual->masa;
            $this->penceramah_program = $jadual->penceramah_program;
            $this->topik_kitab = $jadual->topik_kitab;
            $this->tempat = $jadual->tempat;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'hari' => $this->hari ?: null,
            'minggu' => $this->minggu ? (int) $this->minggu : null,
            'masa' => $this->masa ?: null,
            'penceramah_program' => $this->penceramah_program ?: null,
            'topik_kitab' => $this->topik_kitab ?: null,
            'tempat' => $this->tempat ?: null,
        ];

        if ($this->isEdit) {
            $this->jadual->update($data);
            session()->flash('success', 'Jadual pengajian berjaya dikemaskini.');
        } else {
            JadualPengajian::create($data);
            session()->flash('success', 'Jadual pengajian berjaya dicipta.');
        }

        return redirect()->route('jadual-pengajian.index');
    }

    public function render()
    {
        return view('livewire.jadual-pengajian.jadual-pengajian-form');
    }
}
