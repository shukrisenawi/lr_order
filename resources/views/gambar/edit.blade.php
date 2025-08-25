@extends('layouts.app')

@section('title', 'Edit Gambar')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Edit Gambar</h1>
                    <p class="text-gray-600">Kemaskini maklumat gambar</p>
                </div>
                <a href="{{ route('gambar.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Galeri
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Gambar</h3>
                <p class="text-gray-600 text-sm mt-1">Kemaskini maklumat gambar di bawah</p>
            </div>

            <form method="POST" action="{{ route('gambar.update', $gambar) }}" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column - Current Image and Replace Option -->
                    <div class="space-y-6">
                        <!-- Current Image Preview -->
                        @if ($gambar->path)
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Gambar Semasa</label>
                                <div class="rounded-xl overflow-hidden border border-gray-200 shadow-sm">
                                    <img src="{{ asset('storage/' . $gambar->path) }}" alt="{{ $gambar->nama }}"
                                        class="w-full h-64 object-contain bg-gray-50">
                                </div>
                                <p class="mt-2 text-sm text-gray-500">Gambar semasa akan digunakan jika anda tidak memuat
                                    naik yang baru</p>
                            </div>
                        @endif

                        <!-- Image File -->
                        <div>
                            <label for="gambar" class="block text-sm font-semibold text-gray-800 mb-2">Ganti Gambar
                                (Pilihan)</label>
                            <div
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-400 transition-colors duration-300">
                                <div class="space-y-1 text-center">
                                    <div
                                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                                        <i class="fas fa-sync-alt text-purple-600 text-xl"></i>
                                    </div>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="gambar"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500">
                                            <span>Pilih fail baru</span>
                                            <input id="gambar" name="gambar" type="file" accept="image/*"
                                                class="sr-only">
                                        </label>
                                        <p class="pl-1">atau seret dan lepaskan</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF sehingga 2MB</p>
                                </div>
                            </div>
                            @error('gambar')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Biarkan kosong untuk mengekalkan gambar semasa</p>
                        </div>
                    </div>

                    <!-- Right Column - Form Fields -->
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-800 mb-2">Nama Gambar</label>
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

                        <!-- Description -->
                        <div>
                            <label for="description"
                                class="block text-sm font-semibold text-gray-800 mb-2">Keterangan</label>
                            <textarea name="description" id="description" rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 @error('description') border-red-500 @enderror">{{ old('description', $gambar->description) }}</textarea>
                            @error('description')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Alt Text -->
                        <div>
                            <label for="alt_text" class="block text-sm font-semibold text-gray-800 mb-2">Teks
                                Alternatif</label>
                            <input type="text" name="alt_text" id="alt_text"
                                value="{{ old('alt_text', $gambar->alt_text) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 @error('alt_text') border-red-500 @enderror">
                            @error('alt_text')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
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
                        <i class="fas fa-save mr-2"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
