@extends('layouts.app')

@section('content')
<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Maklumat Kitab Pengajian</h1>
                <p class="text-sm text-gray-600">Butiran lengkap kitab pengajian</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('kitab-pengajian.edit', $kitabPengajian) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('kitab-pengajian.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Gambar Kitab Rumi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kitab Rumi</label>
                @if($kitabPengajian->gambar_kitab_rumi)
                    <img src="{{ asset('storage/' . $kitabPengajian->gambar_kitab_rumi) }}" alt="Gambar Kitab Rumi" class="w-32 h-32 rounded-lg object-cover shadow-lg">
                @else
                    <div class="w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center shadow-lg">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                @endif
            </div>

            <!-- Gambar Kitab Jawi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Kitab Jawi</label>
                @if($kitabPengajian->gambar_kitab_jawi)
                    <img src="{{ asset('storage/' . $kitabPengajian->gambar_kitab_jawi) }}" alt="Gambar Kitab Jawi" class="w-32 h-32 rounded-lg object-cover shadow-lg">
                @else
                    <div class="w-32 h-32 rounded-lg bg-gray-200 flex items-center justify-center shadow-lg">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                @endif
            </div>

            <!-- Nama Kitab -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kitab</label>
                <p class="text-lg font-semibold text-gray-900">{{ $kitabPengajian->nama_kitab }}</p>
            </div>

            <!-- Tenaga Pengajar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Tenaga Pengajar</label>
                <p class="text-lg text-gray-600">{{ $kitabPengajian->tenagaPengajar->nama ?? '-' }}</p>
            </div>

            <!-- Link Kitab Rumi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link Kitab Rumi</label>
                @if($kitabPengajian->link_kitab_rumi)
                    <a href="{{ $kitabPengajian->link_kitab_rumi }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">{{ $kitabPengajian->link_kitab_rumi }}</a>
                @else
                    <p class="text-lg text-gray-600">-</p>
                @endif
            </div>

            <!-- Link Kitab Jawi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Link Kitab Jawi</label>
                @if($kitabPengajian->link_kitab_jawi)
                    <a href="{{ $kitabPengajian->link_kitab_jawi }}" target="_blank" class="text-blue-600 hover:text-blue-800 underline">{{ $kitabPengajian->link_kitab_jawi }}</a>
                @else
                    <p class="text-lg text-gray-600">-</p>
                @endif
            </div>

            <!-- Catatan -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                <p class="text-lg text-gray-600">{{ $kitabPengajian->catatan ?? '-' }}</p>
            </div>

            <!-- Dibuat Pada -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat Pada</label>
                <p class="text-lg text-gray-600">{{ $kitabPengajian->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection