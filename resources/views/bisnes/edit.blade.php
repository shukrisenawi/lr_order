@extends('layouts.app')

@section('title', 'Edit Business')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Business</h1>
                <p class="text-gray-600">Update business information for {{ $bisnes->nama_bines }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('bisnes.show', $bisnes) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-eye mr-2"></i>
                    View Details
                </a>
                <a href="{{ route('bisnes.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-indigo-600 to-indigo-700 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Update Business Information
            </h2>
        </div>

        <form method="POST" action="{{ route('bisnes.update', $bisnes) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Bisnes -->
                <div>
                    <label for="nama_bines" class="block text-sm font-medium text-gray-700 mb-2">
                        Business Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_bines" 
                           name="nama_bines" 
                           value="{{ old('nama_bines', $bisnes->nama_bines) }}" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_bines') border-red-500 @enderror">
                    @error('nama_bines')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Syarikat -->
                <div>
                    <label for="nama_syarikat" class="block text-sm font-medium text-gray-700 mb-2">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="nama_syarikat" 
                           name="nama_syarikat" 
                           value="{{ old('nama_syarikat', $bisnes->nama_syarikat) }}" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('nama_syarikat') border-red-500 @enderror">
                    @error('nama_syarikat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Pendaftaran -->
                <div>
                    <label for="no_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Registration Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="no_pendaftaran" 
                           name="no_pendaftaran" 
                           value="{{ old('no_pendaftaran', $bisnes->no_pendaftaran) }}" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('no_pendaftaran') border-red-500 @enderror">
                    @error('no_pendaftaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Bisnes -->
                <div>
                    <label for="jenis_bisnes" class="block text-sm font-medium text-gray-700 mb-2">
                        Business Type <span class="text-red-500">*</span>
                    </label>
                    <select id="jenis_bisnes" 
                            name="jenis_bisnes" 
                            required
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('jenis_bisnes') border-red-500 @enderror">
                        <option value="">Select Business Type</option>
                        <option value="Sdn Bhd" {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Sdn Bhd' ? 'selected' : '' }}>Sdn Bhd</option>
                        <option value="Enterprise" {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Enterprise' ? 'selected' : '' }}>Enterprise</option>
                        <option value="Partnership" {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                        <option value="Sole Proprietorship" {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                        <option value="Others" {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Others' ? 'selected' : '' }}>Others</option>
                    </select>
                    @error('jenis_bisnes')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tarikh Tamat -->
                <div>
                    <label for="exp_date" class="block text-sm font-medium text-gray-700 mb-2">
                        Expiry Date <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="exp_date" 
                           name="exp_date" 
                           value="{{ old('exp_date', $bisnes->exp_date) }}" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('exp_date') border-red-500 @enderror">
                    @error('exp_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telefon -->
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" 
                           id="no_tel" 
                           name="no_tel" 
                           value="{{ old('no_tel', $bisnes->no_tel) }}" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('no_tel') border-red-500 @enderror">
                    @error('no_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poskod -->
                <div>
                    <label for="poskod" class="block text-sm font-medium text-gray-700 mb-2">
                        Postal Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="poskod" 
                           name="poskod" 
                           value="{{ old('poskod', $bisnes->poskod) }}" 
                           required
                           maxlength="5"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('poskod') border-red-500 @enderror">
                    @error('poskod')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar -->
                <div>
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                        Business Logo/Image
                        <span class="text-gray-500 text-xs">(Optional)</span>
                    </label>
                    @if ($bisnes->gambar)
                        <div class="mb-3">
                            <img src="{{ asset('images/bisnes/' . $bisnes->gambar) }}" 
                                 alt="{{ $bisnes->nama_bines }}"
                                 class="w-20 h-20 rounded-lg object-cover border border-gray-200">
                            <p class="text-xs text-gray-500 mt-1">Current image</p>
                        </div>
                    @endif
                    <input type="file" 
                           id="gambar" 
                           name="gambar" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('gambar') border-red-500 @enderror">
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Leave empty to keep current image</p>
                </div>
            </div>

            <!-- Alamat (Full Width) -->
            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Business Address <span class="text-red-500">*</span>
                </label>
                <textarea id="alamat" 
                          name="alamat" 
                          rows="3" 
                          required
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $bisnes->alamat) }}</textarea>
                @error('alamat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-3 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('bisnes.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg flex items-center transition-colors duration-200">
                    <i class="fas fa-times mr-2"></i>
                    Cancel
                </a>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg flex items-center transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Update Business
                </button>
            </div>
        </form>
    </div>
@endsection
