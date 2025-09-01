@extends('layouts.app')

@section('title', 'Lihat Jadual Pengajian Masjid')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-4">{{ $jadual->topik_kitab }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p><strong>Hari:</strong> {{ ucfirst($jadual->hari) }}</p>
                    <p><strong>Minggu:</strong> {{ $jadual->minggu }}</p>
                    <p><strong>Masa:</strong> {{ $jadual->masa }}</p>
                    <p><strong>Penceramah/Program:</strong> {{ $jadual->penceramah_program }}</p>
                </div>
                <div>
                    <p><strong>Topik/Kitab:</strong> {{ $jadual->topik_kitab }}</p>
                    <p><strong>Tempat:</strong> {{ $jadual->tempat }}</p>
                </div>
            </div>
            <a href="{{ route('jadual-pengajian.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Kembali ke Senarai</a>
        </div>
    </div>
@endsection