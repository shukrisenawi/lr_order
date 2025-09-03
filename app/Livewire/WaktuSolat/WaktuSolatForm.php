<?php

namespace App\Livewire\WaktuSolat;

use Livewire\Component;
use App\Models\WaktuSolat;

class WaktuSolatForm extends Component
{
    public $waktu;
    public $tarikh = '';
    public $tarikh_hijrah = '';
    public $hari = '';
    public $imsak = '';
    public $subuh = '';
    public $syuruk = '';
    public $zohor = '';
    public $asar = '';
    public $maghrib = '';
    public $isyak = '';
    public $isEdit = false;

    protected $rules = [
        'tarikh' => 'required|date',
        'tarikh_hijrah' => 'nullable|string|max:255',
        'hari' => 'nullable|string|max:255',
        'imsak' => 'nullable|date_format:H:i',
        'subuh' => 'nullable|date_format:H:i',
        'syuruk' => 'nullable|date_format:H:i',
        'zohor' => 'nullable|date_format:H:i',
        'asar' => 'nullable|date_format:H:i',
        'maghrib' => 'nullable|date_format:H:i',
        'isyak' => 'nullable|date_format:H:i',
    ];

    protected $messages = [
        'tarikh.required' => 'Tarikh diperlukan.',
        'tarikh.date' => 'Tarikh mestilah format tarikh yang sah.',
        'tarikh_hijrah.string' => 'Tarikh Hijrah mestilah teks.',
        'tarikh_hijrah.max' => 'Tarikh Hijrah maksimum 255 aksara.',
        'hari.string' => 'Hari mestilah teks.',
        'hari.max' => 'Hari maksimum 255 aksara.',
        'imsak.date_format' => 'Imsak mestilah format masa H:i.',
        'subuh.date_format' => 'Subuh mestilah format masa H:i.',
        'syuruk.date_format' => 'Syuruk mestilah format masa H:i.',
        'zohor.date_format' => 'Zohor mestilah format masa H:i.',
        'asar.date_format' => 'Asar mestilah format masa H:i.',
        'maghrib.date_format' => 'Maghrib mestilah format masa H:i.',
        'isyak.date_format' => 'Isyak mestilah format masa H:i.',
    ];

    public function mount($waktu = null)
    {
        if (session('selected_bisnes_id') != 3) {
            return redirect()->route('dashboard');
        }

        if ($waktu) {
            $this->waktu = $waktu;
            $this->isEdit = true;
            $this->tarikh = $waktu->tarikh;
            $this->tarikh_hijrah = $waktu->tarikh_hijrah;
            $this->hari = $waktu->hari;
            $this->imsak = $waktu->imsak;
            $this->subuh = $waktu->subuh;
            $this->syuruk = $waktu->syuruk;
            $this->zohor = $waktu->zohor;
            $this->asar = $waktu->asar;
            $this->maghrib = $waktu->maghrib;
            $this->isyak = $waktu->isyak;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'tarikh' => $this->tarikh,
            'tarikh_hijrah' => $this->tarikh_hijrah ?: null,
            'hari' => $this->hari ?: null,
            'imsak' => $this->imsak ?: null,
            'subuh' => $this->subuh ?: null,
            'syuruk' => $this->syuruk ?: null,
            'zohor' => $this->zohor ?: null,
            'asar' => $this->asar ?: null,
            'maghrib' => $this->maghrib ?: null,
            'isyak' => $this->isyak ?: null,
        ];

        if ($this->isEdit) {
            $this->waktu->update($data);
            session()->flash('success', 'Waktu solat berjaya dikemaskini.');
        } else {
            WaktuSolat::create($data);
            session()->flash('success', 'Waktu solat berjaya dicipta.');
        }

        return redirect()->route('waktu-solat.index');
    }

    public function render()
    {
        return view('livewire.waktu-solat.waktu-solat-form');
    }
}
