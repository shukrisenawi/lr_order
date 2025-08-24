@extends('layouts.app')

@section('title', 'Kemaskini Rekod Pembelian')

@section('content')
    <div style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 24px; font-weight: bold; color: #333; margin: 0;">Kemaskini Rekod Pembelian</h1>
                <p style="color: #666; margin: 5px 0 0 0;">Sunting maklumat pembelian</p>
            </div>
            <a href="{{ route('prospek-buy.index') }}"
                style="background-color: #6c757d; color: white; padding: 8px 16px; text-decoration: none; display: inline-block;">
                ← Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Borang Kemaskini -->
    <div style="background-color: white; border: 1px solid #ddd;">
        <div style="padding: 16px; border-bottom: 1px solid #ddd;">
            <h3 style="margin: 0; font-size: 18px; font-weight: bold;">Maklumat Pembelian</h3>
        </div>

        <form method="POST" action="{{ route('prospek-buy.update', $prospekBuy->id) }}" style="padding: 20px;">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <!-- Alamat Prospek -->
                <div>
                    <label for="prospek_alamat_id" style="display: block; margin-bottom: 5px; font-weight: bold;">Alamat
                        Prospek</label>
                    <select name="prospek_alamat_id" id="prospek_alamat_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px;">
                        <option value="">Pilih Alamat Prospek</option>
                        @foreach ($prospekAlamat as $alamat)
                            <option value="{{ $alamat->id }}"
                                {{ old('prospek_alamat_id', $prospekBuy->prospek_alamat_id) == $alamat->id ? 'selected' : '' }}>
                                {{ $alamat->prospek->gelaran ?? '' }} - {{ $alamat->prospek->no_tel ?? '' }}
                                ({{ $alamat->bandar ?? 'Tiada Bandar' }})
                            </option>
                        @endforeach
                    </select>
                    @error('prospek_alamat_id')
                        <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Produk -->
                <div>
                    <label for="produk_id" style="display: block; margin-bottom: 5px; font-weight: bold;">Produk</label>
                    <select name="produk_id" id="produk_id" required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px;">
                        <option value="">Pilih Produk</option>
                        @foreach ($produk as $product)
                            <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                {{ old('produk_id', $prospekBuy->produk_id) == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} - RM {{ number_format($product->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('produk_id')
                        <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kuantiti -->
                <div>
                    <label for="kuantiti" style="display: block; margin-bottom: 5px; font-weight: bold;">Kuantiti</label>
                    <input type="number" name="kuantiti" id="kuantiti"
                        value="{{ old('kuantiti', $prospekBuy->kuantiti) }}" min="1" required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px;">
                    @error('kuantiti')
                        <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Harga -->
                <div>
                    <label for="harga" style="display: block; margin-bottom: 5px; font-weight: bold;">Harga Seunit
                        (RM)</label>
                    <input type="number" step="0.01" name="harga" id="harga"
                        value="{{ old('harga', $prospekBuy->harga) }}" required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px;">
                    @error('harga')
                        <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tarikh Pembelian -->
                <div>
                    <label for="purchase_date" style="display: block; margin-bottom: 5px; font-weight: bold;">Tarikh
                        Pembelian</label>
                    <input type="date" name="purchase_date" id="purchase_date"
                        value="{{ old('purchase_date', $prospekBuy->purchase_date->format('Y-m-d')) }}" required
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px;">
                    @error('purchase_date')
                        <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jumlah (Dikira) -->
                <div>
                    <label for="total" style="display: block; margin-bottom: 5px; font-weight: bold;">Jumlah (RM)</label>
                    <input type="text" id="total" readonly
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; background-color: #f8f9fa; font-size: 14px;">
                </div>

                <!-- Nota -->
                <div style="grid-column: 1 / -1;">
                    <label for="notes" style="display: block; margin-bottom: 5px; font-weight: bold;">Nota
                        (Pilihan)</label>
                    <textarea name="notes" id="notes" rows="3"
                        style="width: 100%; padding: 8px; border: 1px solid #ccc; font-size: 14px; resize: vertical;">{{ old('notes', $prospekBuy->notes) }}</textarea>
                    @error('notes')
                        <p style="color: red; font-size: 12px; margin-top: 5px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Butang Hantar -->
            <div style="margin-top: 20px; text-align: right;">
                <a href="{{ route('prospek-buy.index') }}"
                    style="background-color: #6c757d; color: white; padding: 8px 16px; text-decoration: none; margin-right: 10px;">
                    Batal
                </a>
                <button type="submit"
                    style="background-color: #007bff; color: white; padding: 8px 16px; border: none; cursor: pointer;">
                    Kemaskini Pembelian
                </button>
            </div>
        </form>
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
