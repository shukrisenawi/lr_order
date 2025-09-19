<?php

namespace App\Livewire\TenagaPengajar;

use Livewire\Component;
use App\Models\TenagaPengajar;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

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
        if (session('selected_bisnes_id') != 3) {
            return redirect()->route('dashboard');
        }

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

        // Handle image upload
        if ($this->gambar) {
            try {
                // Delete old image if updating
                if ($this->tenagaPengajar->exists && $this->tenagaPengajar->gambar && Storage::disk('public')->exists('tenaga-pengajar/' . $this->tenagaPengajar->gambar)) {
                    Storage::disk('public')->delete('tenaga-pengajar/' . $this->tenagaPengajar->gambar);
                }

                // Ensure directory exists
                Storage::disk('public')->makeDirectory('tenaga-pengajar');

                $path = $this->gambar->store('tenaga-pengajar', 'public');
                if (!$path) {
                    throw new \Exception('Failed to store image file.');
                }
                $data['gambar'] = basename($path);
            } catch (\Exception $e) {
                session()->flash('error', 'Gagal menyimpan gambar: ' . $e->getMessage());
                return;
            }
        }

        try {
            if ($this->tenagaPengajar->exists) {
                $this->tenagaPengajar->update($data);
                session()->flash('message', 'Tenaga Pengajar berjaya dikemaskini.');
            } else {
                TenagaPengajar::create($data);
                session()->flash('message', 'Tenaga Pengajar berjaya dicipta.');
            }

            return redirect()->route('tenaga-pengajar.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Gagal menyimpan data: ' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.tenaga-pengajar.tenaga-pengajar-form');
    }
}