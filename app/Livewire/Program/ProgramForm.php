<?php

namespace App\Livewire\Program;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Program;

class ProgramForm extends Component
{
    use WithFileUploads;

    public $program;
    public $gambar_banner;
    public $tajuk = '';
    public $keterangan = '';
    public $tarikh_masa_program = '';
    public $isEdit = false;

    protected $rules = [
        'tajuk' => 'required|string|max:255',
        'keterangan' => 'nullable|string',
        'tarikh_masa_program' => 'required|date',
        'gambar_banner' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'tajuk.required' => 'Tajuk diperlukan.',
        'tajuk.string' => 'Tajuk mestilah teks.',
        'tajuk.max' => 'Tajuk maksimum 255 aksara.',
        'keterangan.string' => 'Keterangan mestilah teks.',
        'tarikh_masa_program.required' => 'Tarikh & masa program diperlukan.',
        'tarikh_masa_program.date' => 'Tarikh & masa program tidak sah.',
        'gambar_banner.image' => 'Gambar banner mestilah fail imej.',
        'gambar_banner.max' => 'Gambar banner maksimum 2MB.',
    ];

    public function mount($program = null)
    {
        if (session('selected_bisnes_id') != 3) {
            return redirect()->route('dashboard');
        }

        if ($program) {
            $this->program = $program;
            $this->isEdit = true;
            $this->tajuk = $program->tajuk;
            $this->keterangan = $program->keterangan;
            $this->tarikh_masa_program = $program->tarikh_masa_program ? $program->tarikh_masa_program->format('Y-m-d\TH:i') : '';
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'tajuk' => $this->tajuk,
            'keterangan' => $this->keterangan ?: null,
            'tarikh_masa_program' => $this->tarikh_masa_program,
        ];

        // Handle file upload
        if ($this->gambar_banner) {
            $filename = $this->gambar_banner->store('program', 'public');
            $data['gambar_banner'] = $filename;
        }

        if ($this->isEdit) {
            $this->program->update($data);
            session()->flash('success', 'Program berjaya dikemaskini.');
        } else {
            Program::create($data);
            session()->flash('success', 'Program berjaya dicipta.');
        }

        return redirect()->route('program.index');
    }

    public function render()
    {
        return view('livewire.program.program-form');
    }
}