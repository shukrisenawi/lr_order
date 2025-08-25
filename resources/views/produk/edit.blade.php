@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Edit Produk</h1>
                    <p class="text-gray-600">Kemaskini maklumat produk</p>
                </div>
                <a href="{{ route('produk.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Produk</h3>
                <p class="text-gray-600 text-sm mt-1">Kemaskini maklumat produk di bawah</p>
            </div>

            <form method="POST" action="{{ route('produk.update', $produk) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Produk <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $produk->nama) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('nama') border-red-500 bg-red-50 @enderror">
                            @error('nama')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Harga <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">RM</span>
                                </div>
                                <input type="number" step="0.01" name="harga"
                                    value="{{ old('harga', $produk->harga) }}" required
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('harga') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('harga')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Stok -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Stok <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', $produk->stok) }}" required
                                min="0"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('stok') border-red-500 bg-red-50 @enderror">
                            @error('stok')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Gambar -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Gambar (Pilihan)</label>
                            <select name="gambar_id"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('gambar_id') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Gambar</option>
                                @foreach ($gambar as $img)
                                    <option value="{{ $img->id }}"
                                        {{ old('gambar_id', $produk->gambar_id) == $img->id ? 'selected' : '' }}>
                                        {{ $img->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('gambar_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('produk.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Kemaskini Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
