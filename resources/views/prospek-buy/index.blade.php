@extends('layouts.app')

@section('title', 'Senarai Pembelian Prospek')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Senarai Pembelian Prospek</h1>
                <p class="text-gray-600">Rekod semua pembelian prospek</p>
            </div>
            <a href="{{ route('prospek-buy.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pembelian Baru
            </a>
        </div>
    </div>

    <!-- Jadual Senarai -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Rekod Pembelian</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tarikh
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Prospek
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Produk
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kuantiti
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Harga
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jumlah
                        </th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tindakan
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($prospekBuys as $buy)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ optional($buy->purchase_date)->format('d/m/Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $buy->prospekAlamat->prospek->gelaran ?? '' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $buy->prospekAlamat->prospek->no_tel ?? '' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $buy->produk->name ?? '' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-center">
                                {{ $buy->kuantiti ?? 0 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">
                                RM {{ number_format($buy->harga ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-right">
                                RM {{ number_format(($buy->kuantiti ?? 0) * ($buy->harga ?? 0), 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('prospek-buy.show', $buy->id) }}"
                                        class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('prospek-buy.edit', $buy->id) }}"
                                        class="text-yellow-600 hover:text-yellow-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('prospek-buy.destroy', $buy->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Adakah anda pasti ingin padam rekod ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-shopping-cart text-4xl text-gray-300 mb-4"></i>
                                    <p>Tiada rekod pembelian ditemui.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($prospekBuys->hasPages())
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200">
                {{ $prospekBuys->links() }}
            </div>
        @endif
    </div>

    <!-- Ringkasan Jumlah -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-blue-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-blue-600">Jumlah Rekod</div>
                <div class="text-2xl font-bold text-blue-900">{{ $prospekBuys->total() }}</div>
            </div>
            <div class="bg-green-50 p-4 rounded-lg">
                <div class="text-sm font-medium text-green-600">Jumlah Keseluruhan</div>
                <div class="text-2xl font-bold text-green-900">RM {{ number_format($totalAmount ?? 0, 2) }}</div>
            </div>
        </div>
    </div>
@endsection
