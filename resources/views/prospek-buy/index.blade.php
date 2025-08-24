@extends('layouts.app')

@section('title', 'Senarai Pembelian Prospek')

@section('content')
    <div style="margin-bottom: 20px;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h1 style="font-size: 24px; font-weight: bold; color: #333; margin: 0;">Senarai Pembelian Prospek</h1>
                <p style="color: #666; margin: 5px 0 0 0;">Rekod semua pembelian prospek</p>
            </div>
            <a href="{{ route('prospek-buy.create') }}"
                style="background-color: #007bff; color: white; padding: 8px 16px; text-decoration: none; display: inline-block;">
                + Tambah Pembelian Baru
            </a>
        </div>
    </div>

    <!-- Jadual Senarai -->
    <div style="background-color: white; border: 1px solid #ddd;">
        <div style="padding: 16px; border-bottom: 1px solid #ddd;">
            <h3 style="margin: 0; font-size: 18px; font-weight: bold;">Rekod Pembelian</h3>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa; border-bottom: 1px solid #ddd;">
                        <th style="padding: 12px; text-align: left; font-weight: bold;">Tarikh</th>
                        <th style="padding: 12px; text-align: left; font-weight: bold;">Prospek</th>
                        <th style="padding: 12px; text-align: left; font-weight: bold;">Produk</th>
                        <th style="padding: 12px; text-align: center; font-weight: bold;">Kuantiti</th>
                        <th style="padding: 12px; text-align: right; font-weight: bold;">Harga</th>
                        <th style="padding: 12px; text-align: right; font-weight: bold;">Jumlah</th>
                        <th style="padding: 12px; text-align: center; font-weight: bold;">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($prospekBuys as $buy)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 12px;">{{ $buy->purchase_date->format('d/m/Y') }}</td>
                            <td style="padding: 12px;">
                                {{ $buy->prospekAlamat->prospek->gelaran ?? '' }}<br>
                                <small style="color: #666;">{{ $buy->prospekAlamat->prospek->no_tel ?? '' }}</small>
                            </td>
                            <td style="padding: 12px;">{{ $buy->produk->name ?? '' }}</td>
                            <td style="padding: 12px; text-align: center;">{{ $buy->kuantiti }}</td>
                            <td style="padding: 12px; text-align: right;">RM {{ number_format($buy->harga, 2) }}</td>
                            <td style="padding: 12px; text-align: right; font-weight: bold;">
                                RM {{ number_format($buy->kuantiti * $buy->harga, 2) }}
                            </td>
                            <td style="padding: 12px; text-align: center;">
                                <div style="display: flex; gap: 5px; justify-content: center;">
                                    <a href="{{ route('prospek-buy.edit', $buy->id) }}"
                                        style="background-color: #ffc107; color: #212529; padding: 4px 8px; text-decoration: none; font-size: 12px;">
                                        Edit
                                    </a>
                                    <form action="{{ route('prospek-buy.destroy', $buy->id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            style="background-color: #dc3545; color: white; padding: 4px 8px; border: none; font-size: 12px; cursor: pointer;"
                                            onclick="return confirm('Adakah anda pasti ingin padam rekod ini?')">
                                            Padam
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="padding: 20px; text-align: center; color: #666;">
                                Tiada rekod pembelian ditemui.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($prospekBuys->hasPages())
            <div style="padding: 16px; border-top: 1px solid #ddd; text-align: center;">
                {{ $prospekBuys->links() }}
            </div>
        @endif
    </div>

    <!-- Ringkasan Jumlah -->
    <div style="margin-top: 20px; background-color: white; border: 1px solid #ddd; padding: 16px;">
        <h4 style="margin: 0 0 10px 0; font-size: 16px; font-weight: bold;">Ringkasan</h4>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <strong>Jumlah Rekod:</strong> {{ $prospekBuys->total() }}
            </div>
            <div>
                <strong>Jumlah Keseluruhan:</strong> RM {{ number_format($totalAmount, 2) }}
            </div>
        </div>
    </div>
@endsection
