@extends('layouts.app')

@section('title', 'Tambah Alamat Prospek Baru')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Tambah Alamat Prospek Baru</h1>
                    <p class="text-gray-600">Cipta alamat baru untuk prospek</p>
                </div>
                <a href="{{ route('prospek-alamat.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('error'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('message'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div
                class="mb-8 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <span>Sila betulkan ralat berikut:</span>
                </div>
                <ul class="list-disc list-inside mt-2 ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Alamat</h3>
                <p class="text-gray-600 text-sm mt-1">Sila isi semua maklumat yang diperlukan</p>
            </div>

            <form method="POST" action="{{ route('prospek-alamat.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Prospek -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Prospek <span
                                    class="text-red-500">*</span></label>
                            <select name="prospek_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('prospek_id') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Prospek</option>
                                @foreach ($prospek as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('prospek_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->gelaran }} - {{ $item->no_tel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prospek_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Nama Penerima -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Penerima <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_penerima" value="{{ old('nama_penerima') }}" required
                                placeholder="Contoh: Ahmad bin Ali"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('nama_penerima') border-red-500 bg-red-50 @enderror">
                            @error('nama_penerima')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" required placeholder="Contoh: No. 12, Jalan Setia 3"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('alamat') border-red-500 bg-red-50 @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Bandar -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Bandar <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="bandar" value="{{ old('bandar') }}" required
                                placeholder="Contoh: Kuala Lumpur"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('bandar') border-red-500 bg-red-50 @enderror">
                            @error('bandar')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Poskod -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="poskod" value="{{ old('poskod') }}" required
                                placeholder="Contoh: 50450" pattern="[0-9]{4,6}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('poskod') border-red-500 bg-red-50 @enderror">
                            @error('poskod')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Negeri -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Negeri <span
                                    class="text-red-500">*</span></label>
                            <select name="negeri" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('negeri') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Negeri</option>
                                <option value="Johor" {{ old('negeri') == 'Johor' ? 'selected' : '' }}>Johor</option>
                                <option value="Kedah" {{ old('negeri') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                <option value="Kelantan" {{ old('negeri') == 'Kelantan' ? 'selected' : '' }}>Kelantan
                                </option>
                                <option value="Melaka" {{ old('negeri') == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                <option value="Negeri Sembilan" {{ old('negeri') == 'Negeri Sembilan' ? 'selected' : '' }}>
                                    Negeri Sembilan</option>
                                <option value="Pahang" {{ old('negeri') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                <option value="Perak" {{ old('negeri') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perlis" {{ old('negeri') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                <option value="Pulau Pinang" {{ old('negeri') == 'Pulau Pinang' ? 'selected' : '' }}>Pulau
                                    Pinang</option>
                                <option value="Sabah" {{ old('negeri') == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                <option value="Sarawak" {{ old('negeri') == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                <option value="Selangor" {{ old('negeri') == 'Selangor' ? 'selected' : '' }}>Selangor
                                </option>
                                <option value="Terengganu" {{ old('negeri') == 'Terengganu' ? 'selected' : '' }}>Terengganu
                                </option>
                                <option value="Kuala Lumpur" {{ old('negeri') == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala
                                    Lumpur</option>
                                <option value="Labuan" {{ old('negeri') == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                <option value="Putrajaya" {{ old('negeri') == 'Putrajaya' ? 'selected' : '' }}>Putrajaya
                                </option>
                            </select>
                            @error('negeri')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- No Telefon -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No Telefon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_tel" value="{{ old('no_tel') }}" required
                                placeholder="Contoh: 012-3456789 atau +60123456789"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('no_tel') border-red-500 bg-red-50 @enderror">
                            @error('no_tel')
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
                    <a href="{{ route('prospek-alamat.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
