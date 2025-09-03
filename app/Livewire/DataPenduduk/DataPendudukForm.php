<?php

namespace App\Livewire\DataPenduduk;

use Livewire\Component;
use App\Models\DataPenduduk;

class DataPendudukForm extends Component
{
    public $dataPenduduk;
    public $nama_dm = '';
    public $kod_lokaliti = '';
    public $nama_lokaliti = '';
    public $no_rumah = '';
    public $no_siri = '';
    public $no_kp_baru = '';
    public $no_kp_lama = '';
    public $nama_pemilih = '';
    public $tarikh_lahir = '';
    public $jantina = '';
    public $bangsa = '';
    public $kod_cula = '';
    public $catatan = '';
    public $alamat_kp = '';
    public $alamat_kediaman = '';
    public $tel_rumah = '';
    public $tel_bimbit = '';
    public $isEdit = false;

    protected $rules = [
        'nama_dm' => 'nullable|string|max:255',
        'kod_lokaliti' => 'nullable|string|max:255',
        'nama_lokaliti' => 'nullable|string|max:255',
        'no_rumah' => 'nullable|string|max:255',
        'no_siri' => 'nullable|string|max:255',
        'no_kp_baru' => 'nullable|string|max:255',
        'no_kp_lama' => 'nullable|string|max:255',
        'nama_pemilih' => 'nullable|string|max:255',
        'tarikh_lahir' => 'nullable|date',
        'jantina' => 'nullable|in:L,P',
        'bangsa' => 'nullable|string|max:255',
        'kod_cula' => 'nullable|string|max:255',
        'catatan' => 'nullable|string',
        'alamat_kp' => 'nullable|string',
        'alamat_kediaman' => 'nullable|string',
        'tel_rumah' => 'nullable|string|max:255',
        'tel_bimbit' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'nama_dm.required' => 'Nama DM diperlukan.',
        'kod_lokaliti.required' => 'Kod Lokaliti diperlukan.',
        'nama_lokaliti.required' => 'Nama Lokaliti diperlukan.',
        'no_siri.required' => 'No. Siri diperlukan.',
        'no_kp_baru.required' => 'No. K/P Baru diperlukan.',
        'nama_pemilih.required' => 'Nama Pemilih diperlukan.',
        'tarikh_lahir.required' => 'Tarikh Lahir diperlukan.',
        'tarikh_lahir.date' => 'Tarikh Lahir mestilah tarikh yang sah.',
        'jantina.required' => 'Jantina diperlukan.',
        'jantina.in' => 'Jantina mestilah L atau P.',
        'bangsa.required' => 'Bangsa diperlukan.',
        'kod_cula.required' => 'Kod Cula diperlukan.',
        'alamat_kp.required' => 'Alamat K/P diperlukan.',
        'alamat_kediaman.required' => 'Alamat Kediaman diperlukan.',
        'tel_bimbit.required' => 'Tel. Bimbit diperlukan.',
    ];

    public function mount($dataPenduduk = null)
    {
        if (session('selected_bisnes_id') != 4) {
            return redirect()->route('dashboard');
        }

        if ($dataPenduduk) {
            $this->dataPenduduk = $dataPenduduk;
            $this->isEdit = true;
            $this->nama_dm = $dataPenduduk->nama_dm;
            $this->kod_lokaliti = $dataPenduduk->kod_lokaliti;
            $this->nama_lokaliti = $dataPenduduk->nama_lokaliti;
            $this->no_rumah = $dataPenduduk->no_rumah;
            $this->no_siri = $dataPenduduk->no_siri;
            $this->no_kp_baru = $dataPenduduk->no_kp_baru;
            $this->no_kp_lama = $dataPenduduk->no_kp_lama;
            $this->nama_pemilih = $dataPenduduk->nama_pemilih;
            $this->tarikh_lahir = $dataPenduduk->tarikh_lahir ? $dataPenduduk->tarikh_lahir->format('Y-m-d') : '';
            $this->jantina = $dataPenduduk->jantina;
            $this->bangsa = $dataPenduduk->bangsa;
            $this->kod_cula = $dataPenduduk->kod_cula;
            $this->catatan = $dataPenduduk->catatan;
            $this->alamat_kp = $dataPenduduk->alamat_kp;
            $this->alamat_kediaman = $dataPenduduk->alamat_kediaman;
            $this->tel_rumah = $dataPenduduk->tel_rumah;
            $this->tel_bimbit = $dataPenduduk->tel_bimbit;
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'nama_dm' => $this->nama_dm ?: null,
            'kod_lokaliti' => $this->kod_lokaliti ?: null,
            'nama_lokaliti' => $this->nama_lokaliti ?: null,
            'no_rumah' => $this->no_rumah ?: null,
            'no_siri' => $this->no_siri ?: null,
            'no_kp_baru' => $this->no_kp_baru ?: null,
            'no_kp_lama' => $this->no_kp_lama ?: null,
            'nama_pemilih' => $this->nama_pemilih ?: null,
            'tarikh_lahir' => $this->tarikh_lahir ?: null,
            'jantina' => $this->jantina ?: null,
            'bangsa' => $this->bangsa ?: null,
            'kod_cula' => $this->kod_cula ?: null,
            'catatan' => $this->catatan ?: null,
            'alamat_kp' => $this->alamat_kp ?: null,
            'alamat_kediaman' => $this->alamat_kediaman ?: null,
            'tel_rumah' => $this->tel_rumah ?: null,
            'tel_bimbit' => $this->tel_bimbit ?: null,
        ];

        if ($this->isEdit) {
            $this->dataPenduduk->update($data);
            session()->flash('success', 'Data Penduduk berjaya dikemaskini.');
        } else {
            DataPenduduk::create($data);
            session()->flash('success', 'Data Penduduk berjaya dicipta.');
        }

        return redirect()->route('data-penduduk.index');
    }

    public function render()
    {
        return view('livewire.data-penduduk.data-penduduk-form');
    }
}
