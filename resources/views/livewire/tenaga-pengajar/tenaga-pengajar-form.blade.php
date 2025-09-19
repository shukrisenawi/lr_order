<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    {{ $tenagaPengajar->exists ? 'Edit Tenaga Pengajar' : 'Tambah Tenaga Pengajar Baru' }}
                </h1>
                <p class="text-sm text-gray-600">
                    {{ $tenagaPengajar->exists ? 'Kemaskini maklumat tenaga pengajar' : 'Masukkan maklumat tenaga pengajar baru' }}
                </p>
            </div>
            <a href="{{ route('tenaga-pengajar.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <form wire:submit="save" enctype="multipart/form-data">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nama" id="nama"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('nama') border-red-500 @enderror"
                        placeholder="Masukkan nama">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- No Tel -->
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700 mb-2">
                        No Telefon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="no_tel" id="no_tel"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('no_tel') border-red-500 @enderror"
                        placeholder="Masukkan nombor telefon">
                    @error('no_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat
                    </label>
                    <textarea wire:model="alamat" id="alamat" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="Masukkan alamat"></textarea>
                </div>

                <!-- Gambar -->
                <div class="md:col-span-2">
                    <label for="gambar" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar
                    </label>
                    <div class="flex items-center space-x-4">
                        @if($tenagaPengajar->gambar)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/tenaga-pengajar/' . $tenagaPengajar->gambar) }}" alt="Current Image" class="w-20 h-20 rounded-lg object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="gambar" id="gambar" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            <p class="mt-1 text-sm text-gray-500">Pilih gambar (max 2MB)</p>
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="status" class="rounded border-gray-300 text-amber-600 shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Aktif</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('tenaga-pengajar.index') }}"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg shadow-md hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $tenagaPengajar->exists ? 'Kemaskini' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>