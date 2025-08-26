@extends('layouts.app')

@section('title', 'Edit Bisnes')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Edit Bisnes</h1>
                    <p class="text-gray-600">Kemaskini maklumat bisnes untuk {{ $bisnes->nama_bisnes }}</p>
                </div>
                <a href="{{ route('bisnes.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Bisnes</h3>
                <p class="text-gray-600 text-sm mt-1">Kemaskini maklumat bisnes di bawah</p>
            </div>

            <form method="POST" action="{{ route('bisnes.update', $bisnes) }}" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Business Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Bisnes <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_bines" value="{{ old('nama_bines', $bisnes->nama_bines) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_bisnes') border-red-500 bg-red-50 @enderror">
                            @error('nama_bisnes')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Syarikat <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_syarikat"
                                value="{{ old('nama_syarikat', $bisnes->nama_syarikat) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_syarikat') border-red-500 bg-red-50 @enderror">
                            @error('nama_syarikat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Registration Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No. Pendaftaran</label>
                            <input type="text" name="no_pendaftaran"
                                value="{{ old('no_pendaftaran', $bisnes->no_pendaftaran) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_pendaftaran') border-red-500 bg-red-50 @enderror">
                            @error('no_pendaftaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Business Type -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Jenis Bisnes <span
                                    class="text-red-500">*</span></label>
                            <select name="jenis_bisnes" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('jenis_bisnes') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Jenis</option>
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
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Tamat <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="exp_date" value="{{ old('exp_date', $bisnes->exp_date) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('exp_date') border-red-500 bg-red-50 @enderror">
                            @error('exp_date')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>


                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">On AI </label>
                            <input type="checkbox" name="on" value="{{ old('no_tel', $bisnes->no_tel) }}"
                                {{ old('on', $bisnes->on) ? 'checked' : '' }}
                                class="toggle toggle-success @error('on') border-red-500 bg-red-50 @enderror">
                            @error('on')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No. Telefon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_tel" value="{{ old('no_tel', $bisnes->no_tel) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_tel') border-red-500 bg-red-50 @enderror">
                            @error('no_tel')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="poskod" value="{{ old('poskod', $bisnes->poskod) }}" required
                                maxlength="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('poskod') border-red-500 bg-red-50 @enderror">
                            @error('poskod')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Bisnes <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('alamat') border-red-500 bg-red-50 @enderror">{{ old('alamat', $bisnes->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Logo Bisnes (Pilihan)</label>
                            <div class="mt-1 flex items-center">
                                @if ($bisnes->gambar)
                                    <div class="flex-shrink-0">
                                        <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) }}"
                                            alt="{{ $bisnes->nama_bisnes }}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-300">
                                    </div>
                                @else
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center border border-gray-300">
                                            <i class="fas fa-building text-gray-400"></i>
                                        </div>
                                    </div>
                                @endif
                                <div class="ml-5">
                                    <input type="file" name="gambar" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gambar') border-red-500 bg-red-50 @enderror">
                                </div>
                            </div>
                            @error('gambar')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Format yang disokong: JPG, JPEG, PNG. Saiz maksimum: 2MB
                            </p>
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong untuk mengekalkan imej semasa</p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Kemaskini Bisnes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
