@extends('layouts.app')

@section('content')
<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Maklumat Kumpulan</h1>
                <p class="text-sm text-gray-600">Butiran lengkap kumpulan</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('kumpulan.edit', $kumpulan) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-100 hover:bg-indigo-200 text-indigo-700 font-medium rounded-lg transition-colors duration-200">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('kumpulan.index') }}"
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
            <!-- Nama -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kumpulan</label>
                <p class="text-lg font-semibold text-gray-900">{{ $kumpulan->nama }}</p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <p class="text-lg text-gray-600">{{ $kumpulan->description ?? '-' }}</p>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $kumpulan->on ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $kumpulan->on ? 'Aktif' : 'Tidak Aktif' }}
                </span>
            </div>

            <!-- Dibuat Pada -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Dibuat Pada</label>
                <p class="text-lg text-gray-600">{{ $kumpulan->created_at->format('d F Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Anak Khariah in this Group -->
    <div class="mt-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Anak Khariah dalam Kumpulan Ini</h2>
                    <p class="text-sm text-gray-600">Senarai anak khariah yang menyertai kumpulan {{ $kumpulan->nama }}</p>
                </div>
                <div class="text-sm text-gray-500">
                    Jumlah: {{ $kumpulan->anakKhariahs->count() }}
                </div>
            </div>

            @if($kumpulan->anakKhariahs->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($kumpulan->anakKhariahs as $anak)
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 hover:border-indigo-300 transition-colors duration-200">
                            <div class="flex items-center space-x-3">
                                <!-- Avatar -->
                                <div class="flex-shrink-0">
                                    @if($anak->gambar)
                                        <img src="{{ asset('storage/' . $anak->gambar) }}" alt="Avatar {{ $anak->nama }}" class="w-12 h-12 rounded-full object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-user text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>

                                <!-- Name and Details -->
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900 truncate">{{ $anak->nama }}</p>
                                    @if($anak->gelaran)
                                        <p class="text-xs text-gray-500 truncate">{{ $anak->gelaran }}</p>
                                    @endif
                                    @if($anak->no_tel)
                                        <p class="text-xs text-gray-500">{{ $anak->no_tel }}</p>
                                    @endif
                                </div>
                            </div>

                            <!-- View Detail Button -->
                            <div class="mt-3">
                                <a href="{{ route('anak-khariah.show', $anak) }}"
                                    class="inline-flex items-center justify-center w-full px-3 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-md hover:bg-indigo-100 transition-colors duration-200">
                                    <i class="fas fa-eye mr-2"></i>
                                    View Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="bg-gray-100 rounded-full p-3 mb-4 inline-block">
                        <i class="fas fa-users text-gray-400 text-xl"></i>
                    </div>
                    <h3 class="text-base font-medium text-gray-900 mb-2">Tiada anak khariah dalam kumpulan ini</h3>
                    <p class="text-sm text-gray-500">Tambah anak khariah ke kumpulan ini melalui menu pengurusan anak khariah.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection