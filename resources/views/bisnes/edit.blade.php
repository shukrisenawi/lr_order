@extends('layouts.app')

@section('title', 'Edit Bisnes')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-light text-gray-800 mb-2">Edit Bisnes</h1>
            <p class="text-gray-500">Kemaskini maklumat bisnes untuk {{ $bisnes->nama_bines }}</p>
        </div>

        <!-- Form -->
        <div class="bg-white border border-gray-200">
            <div class="p-8">
                <form method="POST" action="{{ route('bisnes.update', $bisnes) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Business Name -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Nama Bisnes *</label>
                            <input type="text" name="nama_bines" value="{{ old('nama_bines', $bisnes->nama_bines) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('nama_bines') border-red-300 bg-red-50 @enderror">
                            @error('nama_bines')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Nama Syarikat *</label>
                            <input type="text" name="nama_syarikat"
                                value="{{ old('nama_syarikat', $bisnes->nama_syarikat) }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('nama_syarikat') border-red-300 bg-red-50 @enderror">
                            @error('nama_syarikat')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Registration Number -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Registration Number *</label>
                            <input type="text" name="no_pendaftaran"
                                value="{{ old('no_pendaftaran', $bisnes->no_pendaftaran) }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('no_pendaftaran') border-red-300 bg-red-50 @enderror">
                            @error('no_pendaftaran')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Business Type -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Business Type *</label>
                            <select name="jenis_bisnes" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('jenis_bisnes') border-red-300 bg-red-50 @enderror">
                                <option value="">Select Type</option>
                                <option value="Sdn Bhd"
                                    {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Sdn Bhd' ? 'selected' : '' }}>Sdn Bhd
                                </option>
                                <option value="Enterprise"
                                    {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Enterprise' ? 'selected' : '' }}>
                                    Enterprise</option>
                                <option value="Partnership"
                                    {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Partnership' ? 'selected' : '' }}>
                                    Partnership</option>
                                <option value="Sole Proprietorship"
                                    {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Sole Proprietorship' ? 'selected' : '' }}>
                                    Sole Proprietorship</option>
                                <option value="Others"
                                    {{ old('jenis_bisnes', $bisnes->jenis_bisnes) == 'Others' ? 'selected' : '' }}>Others
                                </option>
                            </select>
                            @error('jenis_bisnes')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Expiry Date *</label>
                            <input type="date" name="exp_date" value="{{ old('exp_date', $bisnes->exp_date) }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('exp_date') border-red-300 bg-red-50 @enderror">
                            @error('exp_date')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Phone Number *</label>
                            <input type="tel" name="no_tel" value="{{ old('no_tel', $bisnes->no_tel) }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('no_tel') border-red-300 bg-red-50 @enderror">
                            @error('no_tel')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Postal Code *</label>
                            <input type="text" name="poskod" value="{{ old('poskod', $bisnes->poskod) }}" required
                                maxlength="5"
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('poskod') border-red-300 bg-red-50 @enderror">
                            @error('poskod')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Business Address *</label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('alamat') border-red-300 bg-red-50 @enderror">{{ old('alamat', $bisnes->alamat) }}</textarea>
                            @error('alamat')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Business Logo (Optional)</label>
                            @if ($bisnes->gambar)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/bisnes/' . $bisnes->gambar) }}"
                                        alt="{{ $bisnes->nama_bines }}"
                                        class="w-16 h-16 object-cover border border-gray-200">
                                    <p class="text-xs text-gray-500 mt-1">Current image</p>
                                </div>
                            @endif
                            <input type="file" name="gambar" accept="image/*"
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('gambar') border-red-300 bg-red-50 @enderror">
                            @error('gambar')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Leave empty to keep current image</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('bisnes.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white hover:bg-gray-900">Kemaskini
                            Bisnes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
