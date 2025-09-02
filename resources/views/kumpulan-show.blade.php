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
</div>
@endsection