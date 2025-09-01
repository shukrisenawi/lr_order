@extends('layouts.app')

@section('title', 'Lihat Pengajian')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden p-6">
            <h1 class="text-2xl font-bold mb-4">Pengajian - {{ $pengajian->kitabPengajian->nama_kitab ?? 'N/A' }}</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p><strong>Hari:</strong> {{ ucfirst($pengajian->hari) }}</p>
                    <p><strong>Minggu:</strong> {{ $pengajian->minggu }}</p>
                    <p><strong>Masa:</strong> {{ $pengajian->masa }}</p>
                    <p><strong>Tenaga Pengajar:</strong> {{ $pengajian->tenagaPengajar->nama ?? 'N/A' }}</p>
                </div>
                <div>
                    <p><strong>Kitab Pengajian:</strong> {{ $pengajian->kitabPengajian->nama_kitab ?? 'N/A' }}</p>
                    <p><strong>Tempat:</strong> {{ $pengajian->tempat }}</p>
                </div>
            </div>
            <a href="{{ route('pengajian.index') }}" class="mt-6 inline-block bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Kembali ke Senarai</a>
        </div>
    </div>
@endsection