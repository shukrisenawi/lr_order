<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $isEdit ? 'Edit Data Penduduk' : 'Tambah Data Penduduk Baru' }}
                </h1>
                <p class="text-gray-600">
                    {{ $isEdit ? 'Kemaskini maklumat data penduduk' : 'Cipta data penduduk baru' }}
                </p>
            </div>
            <a href="{{ route('data-penduduk.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-semibold text-gray-900">Maklumat Data Penduduk</h3>
            <p class="text-gray-600 text-sm mt-1">
                {{ $isEdit ? 'Kemaskini maklumat data penduduk di bawah' : 'Sila isi semua maklumat data penduduk yang diperlukan' }}
            </p>
        </div>

        <form wire:submit.prevent="save" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Nama DM -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Nama DM
                    </label>
                    <input type="text" wire:model="nama_dm" placeholder="Nama DM"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_dm') border-red-500 bg-red-50 @enderror">
                    @error('nama_dm')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Kod Lokaliti -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Kod Lokaliti
                    </label>
                    <input type="text" wire:model="kod_lokaliti" placeholder="Kod Lokaliti"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('kod_lokaliti') border-red-500 bg-red-50 @enderror">
                    @error('kod_lokaliti')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Lokaliti -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Nama Lokaliti
                    </label>
                    <input type="text" wire:model="nama_lokaliti" placeholder="Nama Lokaliti"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_lokaliti') border-red-500 bg-red-50 @enderror">
                    @error('nama_lokaliti')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No. Rumah -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        No. Rumah
                    </label>
                    <input type="text" wire:model="no_rumah" placeholder="No. Rumah"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_rumah') border-red-500 bg-red-50 @enderror">
                    @error('no_rumah')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No. Siri -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        No. Siri
                    </label>
                    <input type="text" wire:model="no_siri" placeholder="No. Siri"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_siri') border-red-500 bg-red-50 @enderror">
                    @error('no_siri')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No. K/P Baru -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        No. K/P Baru
                    </label>
                    <input type="text" wire:model="no_kp_baru" placeholder="No. K/P Baru"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_kp_baru') border-red-500 bg-red-50 @enderror">
                    @error('no_kp_baru')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- No. K/P Lama -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        No. K/P Lama
                    </label>
                    <input type="text" wire:model="no_kp_lama" placeholder="No. K/P Lama"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_kp_lama') border-red-500 bg-red-50 @enderror">
                    @error('no_kp_lama')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Nama Pemilih -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Nama Pemilih
                    </label>
                    <input type="text" wire:model="nama_pemilih" placeholder="Nama Pemilih"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_pemilih') border-red-500 bg-red-50 @enderror">
                    @error('nama_pemilih')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tarikh Lahir -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Tarikh Lahir
                    </label>
                    <input type="date" wire:model="tarikh_lahir"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tarikh_lahir') border-red-500 bg-red-50 @enderror">
                    @error('tarikh_lahir')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Jantina -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Jantina
                    </label>
                    <select wire:model="jantina"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('jantina') border-red-500 bg-red-50 @enderror">
                        <option value="">Pilih Jantina</option>
                        <option value="L">Lelaki</option>
                        <option value="P">Perempuan</option>
                    </select>
                    @error('jantina')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Bangsa -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Bangsa
                    </label>
                    <input type="text" wire:model="bangsa" placeholder="Bangsa"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('bangsa') border-red-500 bg-red-50 @enderror">
                    @error('bangsa')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Kod Cula -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Kod Cula
                    </label>
                    <input type="text" wire:model="kod_cula" placeholder="Kod Cula"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('kod_cula') border-red-500 bg-red-50 @enderror">
                    @error('kod_cula')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tel. Rumah -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Tel. Rumah
                    </label>
                    <input type="text" wire:model="tel_rumah" placeholder="Tel. Rumah"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tel_rumah') border-red-500 bg-red-50 @enderror">
                    @error('tel_rumah')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Tel. Bimbit -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        Tel. Bimbit
                    </label>
                    <input type="text" wire:model="tel_bimbit" placeholder="Tel. Bimbit"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tel_bimbit') border-red-500 bg-red-50 @enderror">
                    @error('tel_bimbit')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>

            <!-- Alamat K/P -->
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Alamat K/P
                </label>
                <textarea wire:model="alamat_kp" rows="3" placeholder="Alamat K/P"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('alamat_kp') border-red-500 bg-red-50 @enderror"></textarea>
                @error('alamat_kp')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Alamat Kediaman -->
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Alamat Kediaman
                </label>
                <textarea wire:model="alamat_kediaman" rows="3" placeholder="Alamat Kediaman"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('alamat_kediaman') border-red-500 bg-red-50 @enderror"></textarea>
                @error('alamat_kediaman')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Catatan -->
            <div class="mt-6">
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    Catatan
                </label>
                <textarea wire:model="catatan" rows="3" placeholder="Catatan"
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('catatan') border-red-500 bg-red-50 @enderror"></textarea>
                @error('catatan')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('data-penduduk.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEdit ? 'Kemaskini Data' : 'Simpan Data' }}
                </button>
            </div>
        </form>
    </div>
</div>
