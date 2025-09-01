<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                    {{ $kitabPengajian->exists ? 'Edit Kitab Pengajian' : 'Tambah Kitab Pengajian Baru' }}
                </h1>
                <p class="text-sm text-gray-600">
                    {{ $kitabPengajian->exists ? 'Kemaskini maklumat kitab pengajian' : 'Masukkan maklumat kitab pengajian baru' }}
                </p>
            </div>
            <a href="{{ route('kitab-pengajian.index') }}"
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
                <!-- Tenaga Pengajar -->
                <div>
                    <label for="tenaga_pengajar_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Tenaga Pengajar <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="tenaga_pengajar_id" id="tenaga_pengajar_id"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('tenaga_pengajar_id') border-red-500 @enderror">
                        <option value="">Pilih Tenaga Pengajar</option>
                        @foreach($tenagaPengajars as $tenagaPengajar)
                            <option value="{{ $tenagaPengajar->id }}">{{ $tenagaPengajar->nama }}</option>
                        @endforeach
                    </select>
                    @error('tenaga_pengajar_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama Kitab -->
                <div>
                    <label for="nama_kitab" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kitab <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nama_kitab" id="nama_kitab"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('nama_kitab') border-red-500 @enderror"
                        placeholder="Masukkan nama kitab">
                    @error('nama_kitab')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Gambar Kitab Rumi -->
                <div>
                    <label for="gambar_kitab_rumi" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Kitab Rumi
                    </label>
                    <div class="flex items-center space-x-4">
                        @if($kitabPengajian->gambar_kitab_rumi)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $kitabPengajian->gambar_kitab_rumi) }}" alt="Current Image Rumi" class="w-20 h-20 rounded-lg object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="gambar_kitab_rumi" id="gambar_kitab_rumi" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            <p class="mt-1 text-sm text-gray-500">Pilih gambar (max 2MB)</p>
                            @error('gambar_kitab_rumi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Gambar Kitab Jawi -->
                <div>
                    <label for="gambar_kitab_jawi" class="block text-sm font-medium text-gray-700 mb-2">
                        Gambar Kitab Jawi
                    </label>
                    <div class="flex items-center space-x-4">
                        @if($kitabPengajian->gambar_kitab_jawi)
                            <div class="flex-shrink-0">
                                <img src="{{ asset('storage/' . $kitabPengajian->gambar_kitab_jawi) }}" alt="Current Image Jawi" class="w-20 h-20 rounded-lg object-cover">
                            </div>
                        @endif
                        <div class="flex-1">
                            <input type="file" wire:model="gambar_kitab_jawi" id="gambar_kitab_jawi" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors">
                            <p class="mt-1 text-sm text-gray-500">Pilih gambar (max 2MB)</p>
                            @error('gambar_kitab_jawi')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Link Kitab Rumi -->
                <div>
                    <label for="link_kitab_rumi" class="block text-sm font-medium text-gray-700 mb-2">
                        Link Kitab Rumi
                    </label>
                    <input type="url" wire:model="link_kitab_rumi" id="link_kitab_rumi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('link_kitab_rumi') border-red-500 @enderror"
                        placeholder="https://example.com">
                    @error('link_kitab_rumi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link Kitab Jawi -->
                <div>
                    <label for="link_kitab_jawi" class="block text-sm font-medium text-gray-700 mb-2">
                        Link Kitab Jawi
                    </label>
                    <input type="url" wire:model="link_kitab_jawi" id="link_kitab_jawi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors @error('link_kitab_jawi') border-red-500 @enderror"
                        placeholder="https://example.com">
                    @error('link_kitab_jawi')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catatan -->
                <div class="md:col-span-2">
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea wire:model="catatan" id="catatan" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors"
                        placeholder="Masukkan catatan"></textarea>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 flex justify-end space-x-3">
                <a href="{{ route('kitab-pengajian.index') }}"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                    Batal
                </a>
                <button type="submit"
                    class="px-6 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg shadow-md hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $kitabPengajian->exists ? 'Kemaskini' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</div>