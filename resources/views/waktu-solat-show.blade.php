@extends('layouts.app')

@section('title', 'Lihat Waktu Solat Masjid')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-4">Waktu Solat untuk {{ $waktu->hari }}, {{ $waktu->tarikh ? \Carbon\Carbon::parse($waktu->tarikh)->format('d/m/Y') : '-' }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p><strong>Tarikh:</strong> {{ $waktu->tarikh ? \Carbon\Carbon::parse($waktu->tarikh)->format('d/m/Y') : '-' }}</p>
                    <p><strong>Tarikh Hijrah:</strong> {{ $waktu->tarikh_hijrah }}</p>
                    <p><strong>Hari:</strong> {{ ucfirst($waktu->hari) }}</p>
                    <p><strong>Imsak:</strong> {{ $waktu->imsak }}</p>
                    <p><strong>Subuh:</strong> {{ $waktu->subuh }}</p>
                </div>
                <div>
                    <p><strong>Syuruk:</strong> {{ $waktu->syuruk }}</p>
                    <p><strong>Zohor:</strong> {{ $waktu->zohor }}</p>
                    <p><strong>Asar:</strong> {{ $waktu->asar }}</p>
                    <p><strong>Maghrib:</strong> {{ $waktu->maghrib }}</p>
                    <p><strong>Isyak:</strong> {{ $waktu->isyak }}</p>
                </div>
            </div>
            <a href="{{ route('waktu-solat.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Kembali ke Senarai</a>
        </div>
    </div>
@endsection