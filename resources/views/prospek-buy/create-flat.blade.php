@extends('layouts.app')

@section('title', 'Rekod Pembelian Baru (Ringkas)')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-semibold text-gray-900">Rekod Pembelian Baru</h1>
                    <p class="text-sm text-gray-600 mt-1">Versi ringkas - isi maklumat asas sahaja</p>
                </div>
                <a href="{{ route('prospek-buy.index') }}"
                    class="inline-flex items-center px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

        <!-- Simple Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('prospek-buy.store') }}" class="p-4" id="purchaseForm">
                @csrf

                <!-- Basic Fields -->
                <div class="space-y-4">

                    <!-- Alamat Prospek -->
                    <div>
                        <label for="prospek_alamat_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Pelanggan
                        </label>
                        <select name="prospek_alamat_id" id="prospek_alamat_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('prospek_alamat_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih pelanggan...</option>
                            @foreach ($prospekAlamat as $alamat)
                                <option value="{{ $alamat->id }}"
                                    {{ old('prospek_alamat_id') == $alamat->id ? 'selected' : '' }}>
                                    {{ $alamat->prospek->gelaran ?? '' }} - {{ $alamat->prospek->no_tel ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('prospek_alamat_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Produk -->
                    <div>
                        <label for="produk_id" class="block text-sm font-medium text-gray-700 mb-1">
                            Produk
                        </label>
                        <select name="produk_id" id="produk_id"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('produk_id') border-red-500 @enderror"
                            required>
                            <option value="">Pilih produk...</option>
                            @foreach ($produk as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                    {{ old('produk_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} - RM {{ number_format($product->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                        @error('produk_id')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kuantiti & Harga in one row -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="kuantiti" class="block text-sm font-medium text-gray-700 mb-1">
                                Kuantiti
                            </label>
                            <input type="number" name="kuantiti" id="kuantiti" value="{{ old('kuantiti', 1) }}"
                                min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('kuantiti') border-red-500 @enderror"
                                required>
                            @error('kuantiti')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                                Harga
                            </label>
                            <input type="number" step="0.01" name="harga" id="harga" value="{{ old('harga') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 @error('harga') border-red-500 @enderror"
                                required>
                            @error('harga')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Total Display -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Jumlah
                        </label>
                        <div class="px-3 py-2 bg-gray-50 border border-gray-300 rounded-md">
                            <span id="total" class="text-lg font-semibold text-gray-900">RM 0.00</span>
                        </div>
                    </div>

                    <!-- Hidden purchase date (auto today) -->
                    <input type="hidden" name="purchase_date" value="{{ date('Y-m-d') }}">
                </div>

                <!-- Simple Actions -->
                <div class="mt-6 flex items-center justify-end space-x-2">
                    <a href="{{ route('prospek-buy.index') }}"
                        class="px-3 py-1.5 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-4 py-1.5 text-sm text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Simple calculation
        function calculateTotal() {
            const quantity = parseFloat(document.getElementById('kuantiti').value) || 0;
            const price = parseFloat(document.getElementById('harga').value) || 0;
            const total = quantity * price;
            document.getElementById('total').textContent = 'RM ' + total.toFixed(2);
        }

        // Auto-fill price when product selected
        document.getElementById('produk_id').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            if (price) {
                document.getElementById('harga').value = price;
                calculateTotal();
            }
        });

        // Calculate on input change
        document.getElementById('kuantiti').addEventListener('input', calculateTotal);
        document.getElementById('harga').addEventListener('input', calculateTotal);

        // Form submission with SweetAlert2
        document.getElementById('purchaseForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = this;
            const formData = new FormData(form);

            // Validate required fields
            const customerId = document.getElementById('prospek_alamat_id').value;
            const productId = document.getElementById('produk_id').value;
            const quantity = document.getElementById('kuantiti').value;
            const price = document.getElementById('harga').value;

            if (!customerId || !productId || !quantity || !price) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Sila lengkapkan semua maklumat yang diperlukan',
                    confirmButtonColor: '#f39c12',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Show loading
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Sedang menyimpan data pembelian',
                allowOutsideClick: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berjaya!',
                            text: 'Pembelian berjaya disimpan',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = "{{ route('prospek-buy.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ralat!',
                            text: data.message || 'Gagal menyimpan pembelian',
                            confirmButtonColor: '#d33'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ralat!',
                        text: 'Berlaku ralat semasa menyimpan data',
                        confirmButtonColor: '#d33'
                    });
                    console.error('Error:', error);
                });
        });

        // Initial calculation
        calculateTotal();
    </script>
@endsection
