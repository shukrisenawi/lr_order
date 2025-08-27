@extends('layouts.app')

@section('title', 'View Purchase')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Pembelian</h1>
                    <p class="text-gray-600">Maklumat terperinci untuk pembelian</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customer-buy.edit', $customerBuy) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-medium rounded-xl shadow-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('customer-buy.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Purchase Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Pembelian</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Prospect Info -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Pelanggan</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customerBuy->customerAlamat && $customerBuy->customerAlamat->customer)
                                <p class="text-gray-900 font-medium">{{ $customerBuy->customerAlamat->customer->gelaran }}
                                </p>
                                <p class="text-gray-600 text-sm">{{ $customerBuy->customerAlamat->customer->no_tel }}</p>
                                @if ($customerBuy->customerAlamat->customer->bisnes)
                                    <p class="text-gray-500 text-xs">
                                        {{ $customerBuy->customerAlamat->customer->bisnes->nama_bines }}</p>
                                @endif
                            @else
                                <p class="text-gray-500">Tiada pelanggan</p>
                            @endif
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Produk</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customerBuy->produk)
                                <p class="text-gray-900 font-medium">{{ $customerBuy->produk->name }}</p>
                                <p class="text-gray-600 text-sm">
                                    {{ $customerBuy->produk->description ?? 'Tiada keterangan' }}</p>
                            @else
                                <p class="text-gray-500">Tiada produk</p>
                            @endif
                        </div>
                    </div>

                    <!-- Quantity -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Kuantiti</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $customerBuy->kuantiti ?? 1 }}</p>
                        </div>
                    </div>

                    <!-- Unit Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Harga Seunit</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">RM {{ number_format($customerBuy->harga ?? 0, 2) }}</p>
                        </div>
                    </div>

                    <!-- Total Amount -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Jumlah Keseluruhan</label>
                        <div class="px-4 py-3 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-gray-900 font-bold text-lg">
                                RM {{ number_format(($customerBuy->kuantiti ?? 1) * ($customerBuy->harga ?? 0), 2) }}
                            </p>
                        </div>
                    </div>

                    <!-- Purchase Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Pembelian</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                {{ optional($customerBuy->purchase_date)->format('d/m/Y') ?? 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if ($customerBuy->notes)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nota</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $customerBuy->notes }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Created Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Rekod Dicipta</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                {{ $customerBuy->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Updated Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Kemaskini Terakhir</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-check text-gray-500 mr-2"></i>
                                {{ $customerBuy->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Purchase Summary -->
        <div class="mt-8 bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Ringkasan Pembelian</h3>
            </div>
            <div class="p-6">
                <div class="bg-gradient-to-br from-rose-50 to-pink-50 border border-rose-200 rounded-xl p-6">
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-rose-100">
                        <span class="text-rose-900 font-medium">Produk:</span>
                        <span class="font-medium text-rose-900">{{ $customerBuy->produk->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-rose-100">
                        <span class="text-rose-900 font-medium">Kuantiti:</span>
                        <span class="font-medium text-rose-900">{{ $customerBuy->kuantiti ?? 1 }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-4 pb-4 border-b border-rose-100">
                        <span class="text-rose-900 font-medium">Harga Seunit:</span>
                        <span class="font-medium text-rose-900">RM {{ number_format($customerBuy->harga ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4">
                        <span class="text-rose-900 font-bold text-lg">Jumlah Keseluruhan:</span>
                        <span class="font-bold text-rose-900 text-2xl">RM
                            {{ number_format(($customerBuy->kuantiti ?? 1) * ($customerBuy->harga ?? 0), 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('customer-buy.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                Kembali
            </a>
            <a href="{{ route('customer-buy.edit', $customerBuy) }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-medium rounded-xl shadow-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                <i class="fas fa-edit mr-2"></i>
                Edit Pembelian
            </a>
            <form method="POST" action="{{ route('customer-buy.destroy', $customerBuy) }}" class="inline"
                onsubmit="return confirm('Adakah anda pasti mahu memadamkan pembelian ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-trash mr-2"></i>
                    Padam Pembelian
                </button>
            </form>
        </div>
    </div>
@endsection
