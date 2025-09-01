<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $isEdit ? 'Edit Waktu Solat' : 'Tambah Waktu Solat Baru' }}
                </h1>
                <p class="text-gray-600">
                    {{ $isEdit ? 'Kemaskini maklumat waktu solat masjid' : 'Cipta waktu solat masjid baru' }}
                </p>
            </div>
            <a href="{{ route('waktu-solat.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-semibold text-gray-900">Maklumat Waktu Solat</h3>
            <p class="text-gray-600 text-sm mt-1">
                {{ $isEdit ? 'Kemaskini maklumat waktu solat masjid di bawah' : 'Sila isi semua maklumat waktu solat yang diperlukan' }}
            </p>
        </div>

        <form wire:submit.prevent="save" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Tarikh -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Tarikh
                    </label>
                    <input type="date" wire:model="tarikh"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tarikh') border-red-500 bg-red-50 @enderror">
                    @error('tarikh')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tarikh Hijrah -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Tarikh Hijrah
                    </label>
                    <input type="text" wire:model="tarikh_hijrah" placeholder="Contoh: 01-Rej-1446"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tarikh_hijrah') border-red-500 bg-red-50 @enderror">
                    @error('tarikh_hijrah')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Hari -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Hari
                    </label>
                    <select wire:model="hari"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('hari') border-red-500 bg-red-50 @enderror">
                        <option value="">Pilih Hari</option>
                        <option value="Ahad">Ahad</option>
                        <option value="Isnin">Isnin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Khamis">Khamis</option>
                        <option value="Jumaat">Jumaat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                    @error('hari')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Imsak -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Imsak
                    </label>
                    <input type="time" wire:model="imsak"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('imsak') border-red-500 bg-red-50 @enderror">
                    @error('imsak')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Subuh -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Subuh
                    </label>
                    <input type="time" wire:model="subuh"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('subuh') border-red-500 bg-red-50 @enderror">
                    @error('subuh')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Syuruk -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Syuruk
                    </label>
                    <input type="time" wire:model="syuruk"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('syuruk') border-red-500 bg-red-50 @enderror">
                    @error('syuruk')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Zohor -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Zohor
                    </label>
                    <input type="time" wire:model="zohor"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('zohor') border-red-500 bg-red-50 @enderror">
                    @error('zohor')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Asar -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Asar
                    </label>
                    <input type="time" wire:model="asar"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('asar') border-red-500 bg-red-50 @enderror">
                    @error('asar')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Maghrib -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Maghrib
                    </label>
                    <input type="time" wire:model="maghrib"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('maghrib') border-red-500 bg-red-50 @enderror">
                    @error('maghrib')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Isyak -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Isyak
                    </label>
                    <input type="time" wire:model="isyak"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('isyak') border-red-500 bg-red-50 @enderror">
                    @error('isyak')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('waktu-solat.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEdit ? 'Kemaskini Waktu' : 'Simpan Waktu' }}
                </button>
            </div>
        </form>
    </div>
</div>
