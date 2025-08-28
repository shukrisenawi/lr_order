@extends('layouts.app')

@section('title', 'View Product')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Iklan</h1>
                    <p class="text-gray-600">Maklumat terperinci untuk {{ $iklan->name ?? 'N/A' }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('iklan.edit', $iklan) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('iklan.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Iklan</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Iklan</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $iklan->name ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Price -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Harga</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 font-medium">RM {{ number_format($iklan->price ?? 0, 2) }}</p>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Keterangan</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $iklan->description ?? 'Tiada keterangan' }}</p>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Stok</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $iklan->stok ?? 'N/A' }}</p>
                        </div>
                    </div>

                    <!-- Image -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Gambar</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($iklan->gambar)
                                <p class="text-gray-900">{{ $iklan->gambar->nama ?? 'N/A' }}</p>
                            @else
                                <p class="text-gray-500">Tiada gambar</p>
                            @endif
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Dicipta</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                {{ $iklan->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Updated Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Kemaskini</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-check text-gray-500 mr-2"></i>
                                {{ $iklan->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('iklan.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Kembali
                    </a>
                    <a href="{{ route('iklan.edit', $iklan) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Iklan
                    </a>
                    <form method="POST" action="{{ route('iklan.destroy', $iklan) }}" class="inline"
                        onsubmit="return confirm('Adakah anda pasti mahu memadamkan iklan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-trash mr-2"></i>
                            Padam Iklan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
