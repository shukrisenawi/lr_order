<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $isEdit ? 'Edit Pengajian' : 'Tambah Pengajian Baru' }}
                </h1>
                <p class="text-gray-600">
                    {{ $isEdit ? 'Kemaskini maklumat pengajian' : 'Cipta pengajian baru' }}
                </p>
            </div>
            <a href="{{ route('pengajian.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-semibold text-gray-900">Maklumat Pengajian</h3>
            <p class="text-gray-600 text-sm mt-1">
                {{ $isEdit ? 'Kemaskini maklumat pengajian di bawah' : 'Sila isi semua maklumat pengajian yang diperlukan' }}
            </p>
        </div>

        <form wire:submit.prevent="save" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Hari -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Hari
                        </label>
                        <select wire:model="hari"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('hari') border-red-500 bg-red-50 @enderror">
                            <option value="">Pilih Hari</option>
                            <option value="ahad">Ahad</option>
                            <option value="isnin">Isnin</option>
                            <option value="selasa">Selasa</option>
                            <option value="rabu">Rabu</option>
                            <option value="khamis">Khamis</option>
                            <option value="jumaat">Jumaat</option>
                            <option value="sabtu">Sabtu</option>
                        </select>
                        @error('hari')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Minggu -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Minggu
                        </label>
                        <select wire:model="minggu"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('minggu') border-red-500 bg-red-50 @enderror">
                            <option value="">Pilih Minggu</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                        @error('minggu')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Masa -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Masa
                        </label>
                        <input type="text" wire:model="masa" value="{{ old('masa', $masa) }}" placeholder="Contoh: Selepas Solat Maghrib"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('masa') border-red-500 bg-red-50 @enderror">
                        @error('masa')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Kitab Pengajian -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Kitab Pengajian
                        </label>
                        <select wire:model="kitab_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('kitab_id') border-red-500 bg-red-50 @enderror">
                            <option value="">Pilih Kitab Pengajian</option>
                            @foreach($kitabPengajians as $kitab)
                                <option value="{{ $kitab->id }}">{{ $kitab->nama_kitab }}</option>
                            @endforeach
                        </select>
                        @error('kitab_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tempat -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Tempat
                        </label>
                        <input type="text" wire:model="tempat" value="{{ old('tempat', $tempat) }}" placeholder="Contoh: Masjid Al-Halimi Batu 5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tempat') border-red-500 bg-red-50 @enderror">
                        @error('tempat')
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
                <a href="{{ route('pengajian.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEdit ? 'Kemaskini Pengajian' : 'Simpan Pengajian' }}
                </button>
            </div>
        </form>
    </div>
</div>