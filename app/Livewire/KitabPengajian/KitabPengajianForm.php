<?php

namespace App\Livewire\KitabPengajian;

use Livewire\Component;
use App\Models\KitabPengajian;
use App\Models\TenagaPengajar;
use Livewire\WithFileUploads;

class KitabPengajianForm extends Component
{
    use WithFileUploads;

    public KitabPengajian $kitabPengajian;
    public $tenaga_pengajar_id;
    public $nama_kitab;
    public $gambar_kitab_rumi;
    public $gambar_kitab_jawi;
    public $link_kitab_rumi;
    public $link_kitab_jawi;
    public $catatan;

    protected $rules = [
        'tenaga_pengajar_id' => 'required|exists:tenaga_pengajars,id',
        'nama_kitab' => 'required|string|max:255',
        'gambar_kitab_rumi' => 'nullable|image|max:2048',
        'gambar_kitab_jawi' => 'nullable|image|max:2048',
        'link_kitab_rumi' => 'nullable|url',
        'link_kitab_jawi' => 'nullable|url',
        'catatan' => 'nullable|string',
    ];

    public function mount(KitabPengajian $kitabPengajian = null)
    {
        if ($kitabPengajian->exists) {
            $this->kitabPengajian = $kitabPengajian;
            $this->tenaga_pengajar_id = $kitabPengajian->tenaga_pengajar_id;
            $this->nama_kitab = $kitabPengajian->nama_kitab;
            $this->link_kitab_rumi = $kitabPengajian->link_kitab_rumi;
            $this->link_kitab_jawi = $kitabPengajian->link_kitab_jawi;
            $this->catatan = $kitabPengajian->catatan;
        } else {
            $this->kitabPengajian = new KitabPengajian();
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'tenaga_pengajar_id' => $this->tenaga_pengajar_id,
            'nama_kitab' => $this->nama_kitab,
            'link_kitab_rumi' => $this->link_kitab_rumi,
            'link_kitab_jawi' => $this->link_kitab_jawi,
            'catatan' => $this->catatan,
        ];

        if ($this->gambar_kitab_rumi) {
            $data['gambar_kitab_rumi'] = $this->gambar_kitab_rumi->store('kitab-pengajian', 'public');
        }

        if ($this->gambar_kitab_jawi) {
            $data['gambar_kitab_jawi'] = $this->gambar_kitab_jawi->store('kitab-pengajian', 'public');
        }

        if ($this->kitabPengajian->exists) {
            $this->kitabPengajian->update($data);
            session()->flash('message', 'Kitab Pengajian updated successfully.');
        } else {
            KitabPengajian::create($data);
            session()->flash('message', 'Kitab Pengajian created successfully.');
        }

        return redirect()->route('kitab-pengajian.index');
    }

    public function render()
    {
        $tenagaPengajars = TenagaPengajar::all();
        return view('livewire.kitab-pengajian.kitab-pengajian-form', compact('tenagaPengajars'));
    }
}