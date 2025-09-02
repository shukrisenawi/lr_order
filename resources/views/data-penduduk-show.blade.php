@extends('layouts.app')

@section('title', 'Lihat Data Penduduk')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $dataPenduduk->nama_pemilih }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <p><strong>Nama DM:</strong> {{ $dataPenduduk->nama_dm }}</p>
                    <p><strong>Kod Lokaliti:</strong> {{ $dataPenduduk->kod_lokaliti }}</p>
                    <p><strong>Nama Lokaliti:</strong> {{ $dataPenduduk->nama_lokaliti }}</p>
                    <p><strong>No. Rumah:</strong> {{ $dataPenduduk->no_rumah }}</p>
                    <p><strong>No. Siri:</strong> {{ $dataPenduduk->no_siri }}</p>
                </div>
                <div>
                    <p><strong>No. K/P Baru:</strong> {{ $dataPenduduk->no_kp_baru }}</p>
                    <p><strong>No. K/P Lama:</strong> {{ $dataPenduduk->no_kp_lama }}</p>
                    <p><strong>Nama Pemilih:</strong> {{ $dataPenduduk->nama_pemilih }}</p>
                    <p><strong>Tarikh Lahir:</strong> {{ $dataPenduduk->tarikh_lahir ? $dataPenduduk->tarikh_lahir->format('d/m/Y') : '-' }}</p>
                    <p><strong>Jantina:</strong> {{ $dataPenduduk->jantina }}</p>
                </div>
                <div>
                    <p><strong>Bangsa:</strong> {{ $dataPenduduk->bangsa }}</p>
                    <p><strong>Kod Cula:</strong> {{ $dataPenduduk->kod_cula }}</p>
                    <p><strong>Tel. Rumah:</strong> {{ $dataPenduduk->tel_rumah }}</p>
                    <p><strong>Tel. Bimbit:</strong> {{ $dataPenduduk->tel_bimbit }}</p>
                </div>
            </div>
            <div class="mt-6">
                <p><strong>Alamat K/P:</strong> {{ $dataPenduduk->alamat_kp }}</p>
                <p><strong>Alamat Kediaman:</strong> {{ $dataPenduduk->alamat_kediaman }}</p>
                <p><strong>Catatan:</strong> {{ $dataPenduduk->catatan }}</p>
            </div>
            <a href="{{ route('data-penduduk.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Kembali ke Senarai</a>
        </div>
    </div>
@endsection