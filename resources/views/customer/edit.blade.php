@extends('layouts.app')

@section('title', 'Edit Pelanggan')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Kemaskini Data Pelanggan</h1>
                <p class="text-gray-600">Kemaskini maklumat pelanggan</p>
                <div class="flex items-center mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-hashtag mr-1"></i>
                        ID: {{ $customer->id }}
                    </span>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('customer.show', $customer) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat
                </a>
                <a href="{{ route('customer.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-8 p-4 bg-gradient-to-r from-red-50 to-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-edit mr-3"></i>
                Kemaskini Maklumat Pelanggan
            </h2>
        </div>

        <form method="POST" action="{{ route('customer.update', $customer) }}" class="p-6">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="nama_penerima"
                            value="{{ old('nama_penerima', $customer->nama_penerima) }}" required
                            placeholder="Contoh: Encik Ahmad"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm @error('nama_penerima') border-red-500 bg-red-50 @enderror">
                        @error('nama_penerima')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-tag mr-2 text-purple-500"></i>
                            Nama/Gelaran
                        </label>
                        <input type="text" name="gelaran" value="{{ old('gelaran', $customer->gelaran) }}"
                            placeholder="Contoh: Encik, Puan, Tn, dll"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm @error('gelaran') border-red-500 bg-red-50 @enderror">
                        @error('gelaran')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-mailbox mr-2 text-yellow-500"></i>
                            Poskod <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="poskod" value="{{ old('poskod', $customer->poskod) }}" required
                            placeholder="Contoh: 12345"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm @error('poskod') border-red-500 bg-red-50 @enderror">
                        @error('poskod')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-envelope mr-2 text-indigo-500"></i>
                            Email
                        </label>
                        <input type="email" name="email" value="{{ old('email', $customer->email) }}"
                            placeholder="Contoh: customer@example.com"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm @error('email') border-red-500 bg-red-50 @enderror">
                        @error('email')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alamat" rows="3" required
                            placeholder="Masukkan alamat lengkap"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm resize-none @error('alamat') border-red-500 bg-red-50 @enderror">{{ old('alamat', $customer->alamat) }}</textarea>
                        @error('alamat')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-phone mr-2 text-green-500"></i>
                            No Tel <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="no_tel" required
                            value="{{ old('no_tel', $customer->no_tel) }}"
                            placeholder="Contoh: 0123456789"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm @error('no_tel') border-red-500 bg-red-50 @enderror">
                        @error('no_tel')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-sticky-note mr-2 text-orange-500"></i>
                            Catatan
                        </label>
                        <textarea name="catatan" rows="3" value="{{ old('catatan', $customer->catatan) }}"
                            placeholder="Catatan tambahan (pilihan)"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm resize-none @error('catatan') border-red-500 bg-red-50 @enderror">{{ old('catatan', $customer->catatan) }}</textarea>
                        @error('catatan')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('customer.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Kemaskini Pelanggan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
