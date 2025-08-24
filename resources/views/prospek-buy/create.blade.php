@extends('layouts.app')

@section('title', 'Rekod Pembelian Baru')

@section('content')
    <div class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1">Rekod Pembelian Baru</h1>
                <p class="text-muted mb-0">Tambah rekod pembelian baharu</p>
            </div>
            <a href="{{ route('prospek-buy.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali ke Senarai
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Maklumat Pembelian</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('prospek-buy.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="prospek_alamat_id" class="form-label">Alamat Prospek</label>
                        <select name="prospek_alamat_id" id="prospek_alamat_id"
                            class="form-select @error('prospek_alamat_id') is-invalid @enderror" required>
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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="produk_id" class="form-label">Produk</label>
                        <select name="produk_id" id="produk_id" class="form-select @error('produk_id') is-invalid @enderror"
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
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="kuantiti" class="form-label">Kuantiti</label>
                        <input type="number" name="kuantiti" id="kuantiti"
                            class="form-control @error('kuantiti') is-invalid @enderror" value="{{ old('kuantiti', 1) }}"
                            min="1" required>
                        @error('kuantiti')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="harga" class="form-label">Harga Seunit (RM)</label>
                        <input type="number" step="0.01" name="harga" id="harga"
                            class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="purchase_date" class="form-label">Tarikh Pembelian</label>
                        <input type="date" name="purchase_date" id="purchase_date"
                            class="form-control @error('purchase_date') is-invalid @enderror"
                            value="{{ old('purchase_date', date('Y-m-d')) }}" required>
                        @error('purchase_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="total" class="form-label">Jumlah (RM)</label>
                        <input type="text" id="total" class="form-control" readonly>
                    </div>

                    <div class="col-12 mb-3">
                        <label for="notes" class="form-label">Nota (Pilihan)</label>
                        <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="text-end">
                    <a href="{{ route('prospek-buy.index') }}" class="btn btn-secondary me-2">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Pembelian
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
