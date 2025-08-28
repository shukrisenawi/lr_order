@extends('layouts.app')

@section('title', 'Kemaskini Prospek')

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

            <form method="POST" action="{{ route('prospek.update', $prospek) }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- No Telefon -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No. Telefon <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="no_tel" value="{{ old('no_tel', $prospek->no_tel) }}" required
                                placeholder="Contoh: 012-3456789"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('no_tel') border-red-500 bg-red-50 @enderror">
                            @error('no_tel')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Gelaran -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama/Gelaran</label>
                            <input type="text" name="gelaran" value="{{ old('gelaran', $prospek->gelaran) }}"
                                placeholder="Contoh: Encik Ahmad"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('gelaran') border-red-500 bg-red-50 @enderror">
                            @error('gelaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Session Id (Pilihan)</label>
                            <input type="text" name="session_id" value="{{ old('session_id', $prospek->session_id) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('session_id') border-red-500 bg-red-50 @enderror">
                            @error('session_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">On AI </label>
                            <input type="checkbox" name="on" value="1"
                                {{ old('on', $prospek->on) ? 'checked' : '' }}
                                class="toggle toggle-success @error('on') border-red-500 bg-red-50 @enderror">
                            @error('on')
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
