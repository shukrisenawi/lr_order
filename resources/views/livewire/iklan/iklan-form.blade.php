<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Header -->
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <div class="flex items-center">
                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-ad text-white"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-semibold text-gray-900">
                        {{ $iklan ? 'Kemaskini Iklan' : 'Cipta Iklan Baru' }}
                    </h3>
                    <p class="text-gray-600 text-sm mt-1">
                        {{ $iklan ? 'Kemaskini maklumat iklan' : 'Tambah iklan baru dengan ciri AI' }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit="save" class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column - Basic Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Nama Iklan -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-tag text-blue-500 mr-2"></i>
                            Nama Iklan
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-ad text-gray-400"></i>
                            </div>
                            <input type="text" wire:model="nama_iklan" required
                                placeholder="Contoh: Promosi Produk ABC"
                                class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-lg @error('nama_iklan') border-red-500 bg-red-50 @enderror">
                        </div>
                        @error('nama_iklan')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Hari -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-calendar-day text-green-500 mr-2"></i>
                            Hari Tayangan
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-hashtag text-gray-400"></i>
                            </div>
                            <input type="number" step="1" min="1" wire:model="hari" required
                                placeholder="1"
                                class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-lg @error('hari') border-red-500 bg-red-50 @enderror">
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Hari ke berapa iklan ini akan ditayangkan</p>
                        @error('hari')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Keterangan -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-file-alt text-purple-500 mr-2"></i>
                            Keterangan Iklan
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <textarea wire:model="keterangan" required
                                class="w-full px-4 py-4 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 resize-both min-h-[120px] max-h-[400px] text-lg @error('keterangan') border-red-500 bg-red-50 @enderror"
                                rows="6" placeholder="Jelaskan kandungan iklan anda..."></textarea>

                            <!-- Emoji Picker Button -->
                            <button type="button" onclick="toggleEmojiPicker()"
                                class="absolute top-3 right-3 p-2 text-gray-400 hover:text-purple-600 transition-colors duration-200 focus:outline-none rounded-lg hover:bg-purple-100">
                                <i class="fas fa-smile text-lg"></i>
                            </button>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">Klik ikon emoji untuk menambah emoji ke dalam keterangan</p>
                        @error('keterangan')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Right Column - Settings -->
                <div class="space-y-6">
                    <!-- AI Settings Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-robot text-white text-sm"></i>
                            </div>
                            <h4 class="ml-3 text-sm font-semibold text-gray-900">Tetapan AI</h4>
                        </div>

                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Aktifkan AI</p>
                                    <p class="text-xs text-gray-600 mt-1">Benarkan AI mengurus iklan ini</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:model="on"
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Tips Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-200">
                        <div class="flex items-center mb-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-lightbulb text-white text-sm"></i>
                            </div>
                            <h4 class="ml-3 text-sm font-semibold text-gray-900">Petua Iklan</h4>
                        </div>

                        <div class="space-y-3">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-check text-blue-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-700">Gunakan nama yang menarik dan mudah diingati</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-check text-blue-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-700">Jelaskan faedah produk dalam keterangan</p>
                                </div>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-check text-blue-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-700">Aktifkan AI untuk pengurusan automatik</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Emoji Picker Dropdown -->
            <div id="emojiPicker"
                class="absolute top-12 right-0 z-50 bg-white border border-gray-300 rounded-lg shadow-lg p-3 hidden w-64 max-h-48 overflow-y-auto">
                <div class="grid grid-cols-8 gap-1">
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('😀')">😀</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('🤖')">🤖</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('💡')">💡</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('📝')">📝</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('✅')">✅</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('🚀')">🚀</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('🎯')">🎯</button>
                    <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                        onclick="insertEmoji('💪')">💪</button>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('iklan.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    <i class="fas fa-times mr-2"></i>
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105">
                    <i class="fas fa-{{ $iklan ? 'save' : 'plus' }} mr-2"></i>
                    {{ $iklan ? 'Kemaskini Iklan' : 'Cipta Iklan' }}
                </button>
            </div>
        </form>
    </div>

    <!-- JavaScript for Emoji Picker -->
    <script>
        function toggleEmojiPicker() {
            const picker = document.getElementById('emojiPicker');
            picker.classList.toggle('hidden');
        }

        function insertEmoji(emoji) {
            const textarea = document.querySelector('textarea[wire\\:model="keterangan"]');
            if (textarea) {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = textarea.value;
                const before = text.substring(0, start);
                const after = text.substring(end, text.length);
                textarea.value = before + emoji + after;
                textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
                textarea.focus();
            }
            document.getElementById('emojiPicker').classList.add('hidden');
        }
    </script>
</div>
