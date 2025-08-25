@extends('layouts.app')

@section('title', 'Rekod Pembelian Baru')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Rekod Pembelian Baru</h1>
                    <p class="text-gray-600">Tambah rekod pembelian baharu</p>
                </div>
                <a href="{{ route('prospek-buy.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Pembelian</h3>
                <p class="text-gray-600 text-sm mt-1">Sila isi semua maklumat yang diperlukan</p>
            </div>

            <form method="POST" action="{{ route('prospek-buy.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Alamat Prospek -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Prospek <span
                                    class="text-red-500">*</span></label>
                            <select name="prospek_alamat_id" id="prospek_alamat_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-300 @error('prospek_alamat_id') border-red-500 bg-red-50 @enderror">
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
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Produk -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Produk <span
                                    class="text-red-500">*</span></label>
                            <select name="produk_id" id="produk_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-300 @error('produk_id') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Produk</option>
                                @foreach ($produk as $product)
                                    <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                        {{ old('produk_id') == $product->id ? 'selected' : '' }}>
                                        {{ $product->name }} - RM {{ number_format($product->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Kuantiti -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Kuantiti <span
                                    class="text-red-500">*</span></label>
                            <input type="number" name="kuantiti" id="kuantiti" value="{{ old('kuantiti', 1) }}"
                                min="1" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-300 @error('kuantiti') border-red-500 bg-red-50 @enderror">
                            @error('kuantiti')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Harga Seunit (RM) <span
                                    class="text-red-500">*</span></label>
                            <input type="number" step="0.01" name="harga" id="harga" value="{{ old('harga') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-300 @error('harga') border-red-500 bg-red-50 @enderror">
                            @error('harga')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Tarikh Pembelian -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Pembelian <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="purchase_date" id="purchase_date"
                                value="{{ old('purchase_date', date('Y-m-d')) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-300 @error('purchase_date') border-red-500 bg-red-50 @enderror">
                            @error('purchase_date')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Jumlah -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Jumlah (RM)</label>
                            <input type="text" id="total" readonly
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl bg-gray-50 text-gray-500">
                        </div>
                    </div>

                    <!-- Nota -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nota (Pilihan)</label>
                        <textarea name="notes" id="notes" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-rose-100 focus:border-rose-500 transition-all duration-300 @error('notes') border-red-500 bg-red-50 @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('prospek-buy.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-medium rounded-xl shadow-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
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
