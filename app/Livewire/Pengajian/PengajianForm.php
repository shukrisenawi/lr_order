<?php

namespace App\Livewire\Pengajian;

use Livewire\Component;
use App\Models\Pengajian;
use App\Models\TenagaPengajar;
use App\Models\KitabPengajian;

class PengajianForm extends Component
{
    public $pengajian;
    public $hari = '';
    public $minggu = '';
    public $masa = '';
    public $pengajar_id = '';
    public $kitab_id = '';
    public $tempat = '';
    public $isEdit = false;

    protected $rules = [
        'hari' => 'nullable|string|max:255',
        'minggu' => 'nullable|integer|min:1|max:5',
        'masa' => 'nullable|string|max:255',
        'pengajar_id' => 'required|exists:tenaga_pengajars,id',
        'kitab_id' => 'required|exists:kitab_pengajian,id',
        'tempat' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'hari.required' => 'Hari diperlukan.',
        'minggu.required' => 'Minggu diperlukan.',
        'minggu.integer' => 'Minggu mestilah nombor.',
        'minggu.min' => 'Minggu minimum 1.',
        'minggu.max' => 'Minggu maksimum 5.',
        'masa.required' => 'Masa diperlukan.',
        'pengajar_id.required' => 'Tenaga Pengajar diperlukan.',
        'pengajar_id.exists' => 'Tenaga Pengajar tidak sah.',
        'kitab_id.required' => 'Kitab Pengajian diperlukan.',
        'kitab_id.exists' => 'Kitab Pengajian tidak sah.',
        'tempat.required' => 'Tempat diperlukan.',
    ];

    public function mount($pengajian = null)
    {
        if ($pengajian) {
            $this->pengajian = $pengajian;
            $this->isEdit = true;
            $this->hari = $pengajian->hari;
            $this->minggu = $pengajian->minggu ? (string) $pengajian->minggu : '';
            $this->masa = $pengajian->masa;
            $this->pengajar_id = $pengajian->pengajar_id;
            $this->kitab_id = $pengajian->kitab_id;
            $this->tempat = $pengajian->tempat;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'hari' => $this->hari ?: null,
            'minggu' => $this->minggu ? (int) $this->minggu : null,
            'masa' => $this->masa ?: null,
            'pengajar_id' => $this->pengajar_id,
            'kitab_id' => $this->kitab_id,
            'tempat' => $this->tempat ?: null,
        ];

        if ($this->isEdit) {
            $this->pengajian->update($data);
            session()->flash('success', 'Pengajian berjaya dikemaskini.');
        } else {
            Pengajian::create($data);
            session()->flash('success', 'Pengajian berjaya dicipta.');
        }

        return redirect()->route('pengajian.index');
    }

    public function render()
    {
        $tenagaPengajars = TenagaPengajar::all();
        $kitabPengajians = KitabPengajian::all();

        return view('livewire.pengajian.pengajian-form', compact('tenagaPengajars', 'kitabPengajians'));
    }
}