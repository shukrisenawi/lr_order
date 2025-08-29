@extends('layouts.app')

@section('title', 'Tambah Prospek Baru')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Tambah Prospek Baru</h1>
                    <p class="text-gray-600">Cipta prospek baru</p>
                </div>
                <a href="{{ route('prospek.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Prospek</h3>
                <p class="text-gray-600 text-sm mt-1">Sila isi semua maklumat yang diperlukan</p>
            </div>

            <form method="POST" action="{{ route('customer.store') }}" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Whatsapp ID <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="whatsapp_id" value="{{ old('whatsapp_id') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('whatsapp_id') border-red-500 bg-red-50 @enderror">
                            @error('whatsapp_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Penerima <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}" required
                                placeholder="Contoh: Encik Ahmad"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('nama_penerima') border-red-500 bg-red-50 @enderror">
                            @error('nama_penerima')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="gelaran" value="{{ old('gelaran') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('gelaran') border-red-500 bg-red-50 @enderror">
                            @error('gelaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('email') border-red-500 bg-red-50 @enderror">
                            @error('email')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama/Gelaran <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="gelaran" value="{{ old('gelaran') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('gelaran') border-red-500 bg-red-50 @enderror">
                            @error('gelaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('alamat') border-red-500 bg-red-50 @enderror">
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No Tel</label>
                            <input type="text" name="no_tel" value="{{ old('no_tel') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('no_tel') border-red-500 bg-red-50 @enderror">
                            @error('no_tel')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Catatan</label>
                            <input type="text" name="catatan" value="{{ old('catatan') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('catatan') border-red-500 bg-red-50 @enderror">
                            @error('catatan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('prospek.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Prospek
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
