@extends('layouts.app')

@section('title', 'Edit Gambar')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Muat Naik Gambar Baru</h1>
                    <p class="text-gray-600">Tambah gambar baru ke galeri anda</p>
                </div>
                <a href="{{ route('gambar.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Galeri
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Gambar</h3>
            </div>

            <form method="POST" action="{{ route('gambar.update', $gambar) }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-8">
                    <!-- Form Fields -->
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-800 mb-2">Nama Gambar <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama', $gambar->nama) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label for="keterangan" class="block text-sm font-semibold text-gray-800 mb-2">Keterangan
                            </label>
                            <input type="text" name="keterangan" id="keterangan"
                                value="{{ old('keterangan', $gambar->keterangan) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 @error('keterangan') border-red-500 @enderror">
                            @error('keterangan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Carian AI </label>
                            <input type="checkbox" name="ai_search" value="1"
                                {{ old('ai_search', $gambar->ai_search) ? 'checked' : '' }}
                                class="toggle toggle-success @error('ai_search') border-red-500 bg-red-50 @enderror">
                            @error('ai_search')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <!-- Image Files -->
                        <div>
                            <img src="{{ $gambar->path }}" alt="{{ $gambar->nama ?? 'Gambar' }}" class="max-w-xl">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('gambar.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <i class="fas fa-upload mr-2"></i>
                        Kemaskini Gambar
                    </button>
                </div>
        </div>

        </form>
    </div>

@endsection
