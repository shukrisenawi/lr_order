<?php

namespace App\Livewire\Bisnes;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Bisnes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BisnesForm extends Component
{
    use WithFileUploads;

    public $bisnes;
    public $nama_bisnes = '';
    public $exp_date = '';
    public $nama_syarikat = '';
    public $no_pendaftaran = '';
    public $alamat = '';
    public $poskod = '';
    public $no_tel = '';
    public $on = false;
    public $system_message = '';
    public $gambar;
    public $existing_gambar = '';
    public $isEdit = false;

    protected $rules = [
        'nama_bisnes' => 'required|string|max:255',
        'exp_date' => 'required|date',
        'nama_syarikat' => 'required|string|max:255',
        'no_pendaftaran' => 'nullable|string|max:255',
        'alamat' => 'required|string',
        'poskod' => 'required|string|max:10',
        'no_tel' => 'required|string|max:20',
        'on' => 'boolean',
        'system_message' => 'nullable|string',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ];

    protected $messages = [
        'nama_bisnes.required' => 'Nama bisnes diperlukan.',
        'exp_date.required' => 'Tarikh tamat diperlukan.',
        'nama_syarikat.required' => 'Nama syarikat diperlukan.',
        'alamat.required' => 'Alamat diperlukan.',
        'poskod.required' => 'Poskod diperlukan.',
        'no_tel.required' => 'No. telefon diperlukan.',
        'gambar.image' => 'Fail yang dimuat naik mestilah imej.',
        'gambar.mimes' => 'Format imej yang disokong: JPEG, PNG, JPG, GIF.',
        'gambar.max' => 'Saiz imej tidak boleh melebihi 2MB.',
    ];

    public function mount($bisnes = null)
    {
        if ($bisnes) {
            $this->bisnes = $bisnes;
            $this->isEdit = true;
            $this->nama_bisnes = $bisnes->nama_bisnes;
            $this->exp_date = $bisnes->exp_date;
            $this->nama_syarikat = $bisnes->nama_syarikat;
            $this->no_pendaftaran = $bisnes->no_pendaftaran;
            $this->alamat = $bisnes->alamat;
            $this->poskod = $bisnes->poskod;
            $this->no_tel = $bisnes->no_tel;
            $this->on = $bisnes->on;
            $this->system_message = $bisnes->system_message;
            $this->existing_gambar = $bisnes->gambar;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'user_id' => Auth::id(),
            'nama_bisnes' => $this->nama_bisnes,
            'exp_date' => $this->exp_date,
            'nama_syarikat' => $this->nama_syarikat,
            'no_pendaftaran' => $this->no_pendaftaran,
            'alamat' => $this->alamat,
            'poskod' => $this->poskod,
            'no_tel' => $this->no_tel,
            'on' => $this->on,
            'system_message' => $this->system_message,
        ];

        // Handle image upload
        if ($this->gambar) {
            // Delete old image if updating
            if ($this->isEdit && $this->existing_gambar && Storage::disk('public')->exists('bisnes/' . $this->existing_gambar)) {
                Storage::disk('public')->delete('bisnes/' . $this->existing_gambar);
            }

            $path = $this->gambar->store('bisnes', 'public');
            $data['gambar'] = basename($path);
        }

        if ($this->isEdit) {
            $this->bisnes->update($data);
            session()->flash('success', 'Bisnes berjaya dikemaskini.');
        } else {
            Bisnes::create($data);
            session()->flash('success', 'Bisnes berjaya dicipta.');
        }

        return redirect()->route('bisnes.index');
    }

    public function render()
    {
        return view('livewire.bisnes.bisnes-form');
    }
}
