@extends('layouts.app')

@section('title', 'Rekod Pembelian Baru')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Rekod Pembelian Baru</h1>
                    <p class="text-gray-600 mt-1">Tambah rekod pembelian baharu</p>
                </div>
                <a href="{{ route('prospek-buy.index') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Form Container -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('prospek-buy.store') }}" class="p-6">
                @csrf

                <!-- Form Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Alamat Prospek -->
                    <div>
                        <label for="prospek_alamat_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Prospek
                        </label>
                        <select name="prospek_alamat_id" id="prospek_alamat_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('prospek_alamat_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Alamat Prospek</option>
                            @foreach ($prospekAlamat as $alamat)
                                <option value="{{ $alamat->id }}"
                                    {{ old('prospek_alamat_id') == $alamat->id ? 'selected' : '' }}>
                                    {{ $alamat->prospek->gelaran ?? '' }} - {{ $alamat->prospek->no_tel ?? '' }}
                                    ({{ $alamat->bandar ?? 'Tiada Bandar' }})
                                </option>
                            @endforeach
                        </select>
                        @error('prospek_alamat_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Produk -->
                    <div>
                        <label for="produk_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Produk
                        </label>
                        <select name="produk_id" id="produk_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('produk_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih Produk</option>
                            @foreach ($produk as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                    {{ old('produk_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - RM {{ number_format($product->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('produk_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kuantiti -->
                    <div>
                        <label for="kuantiti" class="block text-sm font-medium text-gray-700 mb-2">
                            Kuantiti
                        </label>
                        <input type="number" name="kuantiti" id="kuantiti" value="{{ old('kuantiti', 1) }}"
                            min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('kuantiti') border-red-500 @enderror"
                            required>
                        @error('kuantiti')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Harga -->
                    <div>
                        <label for="harga" class="block text-sm font-medium text-gray-700 mb-2">
                            Harga Seunit (RM)
                        </label>
                        <input type="number" step="0.01" name="harga" id="harga" value="{{ old('harga') }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('harga') border-red-500 @enderror"
                            required>
                        @error('harga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tarikh Pembelian -->
                    <div>
                        <label for="purchase_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarikh Pembelian
                        </label>
                        <input type="date" name="purchase_date" id="purchase_date"
                            value="{{ old('purchase_date', date('Y-m-d')) }}"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('purchase_date') border-red-500 @enderror"
                            required>
                        @error('purchase_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label for="total" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah (RM)
                        </label>
                        <input type="text" id="total" readonly
                            class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-500">
                    </div>

                    <!-- Nota -->
                    <div class="md:col-span-2">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Nota (Pilihan)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex items-center justify-end space-x-3">
                    <a href="{{ route('prospek-buy.index') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                        </svg>
                        Simpan Pembelian
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Isi harga semasa produk dipilih dan kira jumlah
        document.getElementById('produk_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('harga').value = price;
                calculateTotal();
            }
        });

        // Kira jumlah apabila kuantiti atau harga berubah
        document.getElementById('kuantiti').addEventListener('input', calculateTotal);
        document.getElementById('harga').addEventListener('input', calculateTotal);

        function calculateTotal() {
            const quantity = parseFloat(document.getElementById('kuantiti').value) || 0;
            const price = parseFloat(document.getElementById('harga').value) || 0;
            const total = quantity * price;
            document.getElementById('total').value = 'RM ' + total.toFixed(2);
        }

        // Pengiraan awal
        calculateTotal();
    </script>
@endsection
