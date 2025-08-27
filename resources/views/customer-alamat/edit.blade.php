@extends('layouts.app')

@section('title', 'Kemaskini Alamat Customer')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Kemaskini Alamat Customer</h1>
                    <p class="text-gray-600">Kemaskini maklumat alamat customer</p>
                </div>
                <a href="{{ route('customer-alamat.index') }}"
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

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Alamat</h3>
                <p class="text-gray-600 text-sm mt-1">Kemaskini maklumat alamat customer di bawah</p>
            </div>

            <form method="POST" action="{{ route('customer-alamat.update', $customerAlamat) }}" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Customer -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Customer <span
                                    class="text-red-500">*</span></label>
                            <select name="customer_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('customer_id') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Customer</option>
                                @foreach ($customer as $prospect)
                                    <option value="{{ $prospect->id }}"
                                        {{ old('customer_id', $customerAlamat->customer_id) == $prospect->id ? 'selected' : '' }}>
                                        {{ $prospect->gelaran }} - {{ $prospect->no_tel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_id')
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
                            <input type="text" name="nama_penerima"
                                value="{{ old('nama_penerima', $customerAlamat->nama_penerima) }}" required
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
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-amber-100 focus:border-amber-500 transition-all duration-300 @error('alamat') border-red-500 bg-red-50 @enderror">{{ old('alamat', $customerAlamat->alamat) }}</textarea>
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
                            <input type="text" name="bandar" value="{{ old('bandar', $customerAlamat->bandar) }}"
                                required
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
                            <input type="text" name="poskod" value="{{ old('poskod', $customerAlamat->poskod) }}"
                                required
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
                                <option value="Johor"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Johor' ? 'selected' : '' }}>Johor
                                </option>
                                <option value="Kedah"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Kedah' ? 'selected' : '' }}>Kedah
                                </option>
                                <option value="Kelantan"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Kelantan' ? 'selected' : '' }}>Kelantan
                                </option>
                                <option value="Melaka"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Melaka' ? 'selected' : '' }}>Melaka
                                </option>
                                <option value="Negeri Sembilan"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Negeri Sembilan' ? 'selected' : '' }}>
                                    Negeri Sembilan</option>
                                <option value="Pahang"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Pahang' ? 'selected' : '' }}>Pahang
                                </option>
                                <option value="Perak"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Perak' ? 'selected' : '' }}>Perak
                                </option>
                                <option value="Perlis"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Perlis' ? 'selected' : '' }}>Perlis
                                </option>
                                <option value="Pulau Pinang"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Pulau Pinang' ? 'selected' : '' }}>Pulau
                                    Pinang</option>
                                <option value="Sabah"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Sabah' ? 'selected' : '' }}>Sabah
                                </option>
                                <option value="Sarawak"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Sarawak' ? 'selected' : '' }}>Sarawak
                                </option>
                                <option value="Selangor"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Selangor' ? 'selected' : '' }}>Selangor
                                </option>
                                <option value="Terengganu"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Terengganu' ? 'selected' : '' }}>
                                    Terengganu</option>
                                <option value="Kuala Lumpur"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala
                                    Lumpur</option>
                                <option value="Labuan"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Labuan' ? 'selected' : '' }}>Labuan
                                </option>
                                <option value="Putrajaya"
                                    {{ old('negeri', $customerAlamat->negeri) == 'Putrajaya' ? 'selected' : '' }}>Putrajaya
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
                            <input type="text" name="no_tel" value="{{ old('no_tel', $customerAlamat->no_tel) }}"
                                required
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
                    <a href="{{ route('customer-alamat.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Kemaskini Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
