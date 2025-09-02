<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $isEdit ? 'Edit Program' : 'Tambah Program Baru' }}
                </h1>
                <p class="text-gray-600">
                    {{ $isEdit ? 'Kemaskini maklumat program' : 'Cipta program baru' }}
                </p>
            </div>
            <a href="{{ route('program.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-semibold text-gray-900">Maklumat Program</h3>
            <p class="text-gray-600 text-sm mt-1">
                {{ $isEdit ? 'Kemaskini maklumat program di bawah' : 'Sila isi semua maklumat program yang diperlukan' }}
            </p>
        </div>

        <form wire:submit.prevent="save" class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Tajuk -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Tajuk Program
                        </label>
                        <input type="text" wire:model="tajuk" placeholder="Masukkan tajuk program"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tajuk') border-red-500 bg-red-50 @enderror">
                        @error('tajuk')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Gambar Banner -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Gambar Banner
                        </label>
                        <input type="file" wire:model="gambar_banner"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('gambar_banner') border-red-500 bg-red-50 @enderror">
                        @if($gambar_banner)
                            <div class="mt-2">
                                <img src="{{ $gambar_banner->temporaryUrl() }}" alt="Preview" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @elseif($isEdit && $program && $program->gambar_banner)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $program->gambar_banner) }}" alt="Current Banner" class="w-32 h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        @error('gambar_banner')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Keterangan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Keterangan
                        </label>
                        <textarea wire:model="keterangan" rows="4" placeholder="Masukkan keterangan program"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('keterangan') border-red-500 bg-red-50 @enderror"></textarea>
                        @error('keterangan')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Tarikh & Masa Program -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Tarikh & Masa Program
                        </label>
                        <input type="datetime-local" wire:model="tarikh_masa_program"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('tarikh_masa_program') border-red-500 bg-red-50 @enderror">
                        @error('tarikh_masa_program')
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
                <a href="{{ route('program.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEdit ? 'Kemaskini Program' : 'Simpan Program' }}
                </button>
            </div>
        </form>
    </div>
</div>