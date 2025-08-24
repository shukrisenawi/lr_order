@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
                <p class="text-gray-600">Kemaskini maklumat produk</p>
            </div>
            <a href="{{ route('produk.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Maklumat Produk</h3>
        </div>

        <form method="POST" action="{{ route('produk.update', $produk) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $produk->nama) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                    <input type="number" step="0.01" name="harga" id="harga"
                        value="{{ old('harga', $produk->harga) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('harga') border-red-500 @enderror">
                    @error('harga')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Stok -->
                <div>
                    <label for="stok" class="block text-sm font-medium text-gray-700 mb-2">Stok</label>
                    <input type="number" name="stok" id="stok" value="{{ old('stok', $produk->stok) }}" required
                        min="0"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('stok') border-red-500 @enderror">
                    @error('stok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label for="gambar_id" class="block text-sm font-medium text-gray-700 mb-2">Gambar (Pilihan)</label>
                    <select name="gambar_id" id="gambar_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gambar_id') border-red-500 @enderror">
                        <option value="">Pilih Gambar</option>
                        @foreach ($gambar as $img)
                            <option value="{{ $img->id }}"
                                {{ old('gambar_id', $produk->gambar_id) == $img->id ? 'selected' : '' }}>
                                {{ $img->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('gambar_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('produk.index') }}"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Kemaskini Produk
                </button>
            </div>
        </form>
    </div>
@endsection
