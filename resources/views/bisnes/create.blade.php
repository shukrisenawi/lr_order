@extends('layouts.app')

@section('title', 'Add New Business')

@section('content')
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Add New Business</h1>
                <p class="text-gray-600">Create a new business entity for your organization</p>
            </div>
            <a href="{{ route('bisnes.index') }}"
                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-white flex items-center">
                <i class="fas fa-building mr-2"></i>
                Business Information
            </h2>
        </div>

        <form method="POST" action="{{ route('bisnes.store') }}" enctype="multipart/form-data" class="p-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Bisnes -->
                <div>
                    <label for="nama_bines" class="block text-sm font-medium text-gray-700 mb-2">
                        Business Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_bines" name="nama_bines" value="{{ old('nama_bines') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_bines') border-red-500 @enderror">
                    @error('nama_bines')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Syarikat -->
                <div>
                    <label for="nama_syarikat" class="block text-sm font-medium text-gray-700 mb-2">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="nama_syarikat" name="nama_syarikat" value="{{ old('nama_syarikat') }}"
                        required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama_syarikat') border-red-500 @enderror">
                    @error('nama_syarikat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Pendaftaran -->
                <div>
                    <label for="no_pendaftaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Registration Number <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="no_pendaftaran" name="no_pendaftaran" value="{{ old('no_pendaftaran') }}"
                        required placeholder="e.g., 123456-A"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_pendaftaran') border-red-500 @enderror">
                    @error('no_pendaftaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Bisnes -->
                <div>
                    <label for="jenis_bisnes" class="block text-sm font-medium text-gray-700 mb-2">
                        Business Type <span class="text-red-500">*</span>
                    </label>
                    <select id="jenis_bisnes" name="jenis_bisnes" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jenis_bisnes') border-red-500 @enderror">
                        <option value="">Select Business Type</option>
                        <option value="Sdn Bhd" {{ old('jenis_bisnes') == 'Sdn Bhd' ? 'selected' : '' }}>Sdn Bhd</option>
                        <option value="Enterprise" {{ old('jenis_bisnes') == 'Enterprise' ? 'selected' : '' }}>Enterprise
                        </option>
                        <option value="Partnership" {{ old('jenis_bisnes') == 'Partnership' ? 'selected' : '' }}>
                            Partnership</option>
                        <option value="Sole Proprietorship"
                            {{ old('jenis_bisnes') == 'Sole Proprietorship' ? 'selected' : '' }}>Sole Proprietorship
                        </option>
                        <option value="Others" {{ old('jenis_bisnes') == 'Others' ? 'selected' : '' }}>Others</option>
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
                    <input type="date" id="exp_date" name="exp_date" value="{{ old('exp_date') }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('exp_date') border-red-500 @enderror">
                    @error('exp_date')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Telefon -->
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700 mb-2">
                        Phone Number <span class="text-red-500">*</span>
                    </label>
                    <input type="tel" id="no_tel" name="no_tel" value="{{ old('no_tel') }}" required
                        placeholder="e.g., +60123456789"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_tel') border-red-500 @enderror">
                    @error('no_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Poskod -->
                <div>
                    <label for="poskod" class="block text-sm font-medium text-gray-700 mb-2">
                        Postal Code <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="poskod" name="poskod" value="{{ old('poskod') }}" required
                        placeholder="e.g., 50000" maxlength="5"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('poskod') border-red-500 @enderror">
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
                    <div class="relative">
                        <input type="file" id="gambar" name="gambar" accept="image/*"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gambar') border-red-500 @enderror">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <i class="fas fa-image text-gray-400"></i>
                        </div>
                    </div>
                    @error('gambar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Supported formats: JPG, PNG, GIF (Max: 2MB)</p>
                </div>
            </div>

            <!-- Alamat (Full Width) -->
            <div class="mt-6">
                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                    Business Address <span class="text-red-500">*</span>
                </label>
                <textarea id="alamat" name="alamat" rows="3" required placeholder="Enter complete business address..."
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror">{{ old('alamat') }}</textarea>
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
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center transition-colors duration-200">
                    <i class="fas fa-save mr-2"></i>
                    Save Business
                </button>
            </div>
        </form>
    </div>

    <!-- Form Validation Script -->
    <script>
        // Auto-format phone number
        document.getElementById('no_tel').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.startsWith('60')) {
                value = '+' + value;
            } else if (value.startsWith('0')) {
                value = '+6' + value;
            } else if (!value.startsWith('+')) {
                value = '+60' + value;
            }
            e.target.value = value;
        });

        // Auto-format postal code
        document.getElementById('poskod').addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 5);
        });

        // Preview image
        document.getElementById('gambar').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // You can add image preview functionality here
                    console.log('Image selected:', file.name);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
