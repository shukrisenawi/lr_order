<div class="w-full px-2 sm:px-3 lg:px-4 py-2 bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="mb-3">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h1
                        class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-600 bg-clip-text text-transparent">
                        {{ $isEdit ? 'Edit Bisnes' : 'Tambah Bisnes Baru' }}
                    </h1>
                </div>
                <p class="text-gray-600 text-xs mt-0.5">
                    {{ $isEdit ? 'Kemaskini maklumat bisnes untuk ' . $nama_bisnes : 'Cipta entiti bisnes baru' }}
                </p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('bisnes.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save" enctype="multipart/form-data" class="space-y-2">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            <!-- Left Column -->
            <div class="space-y-2">
                <!-- Business Name -->
                <div class="form-group">
                    <label class="form-label">Nama Bisnes <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_bisnes" placeholder="Contoh: Kedai Runcit Maju"
                        class="form-input @error('nama_bisnes') border-red-500 bg-red-50 @enderror">
                    @error('nama_bisnes')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Company Name -->
                <div class="form-group">
                    <label class="form-label">Nama Syarikat <span class="text-red-500">*</span></label>
                    <input type="text" wire:model="nama_syarikat" placeholder="Contoh: Kedai Runcit Maju Sdn Bhd"
                        class="form-input @error('nama_syarikat') border-red-500 bg-red-50 @enderror">
                    @error('nama_syarikat')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Registration Number -->
                <div class="form-group">
                    <label class="form-label">No. Pendaftaran</label>
                    <input type="text" wire:model="no_pendaftaran" placeholder="Contoh: 1234567890"
                        class="form-input @error('no_pendaftaran') border-red-500 bg-red-50 @enderror">
                    @error('no_pendaftaran')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Expiry Date -->
                <div class="form-group">
                    <label class="form-label">Tarikh Tamat <span class="text-red-500">*</span></label>
                    <input type="date" wire:model="exp_date"
                        class="form-input @error('exp_date') border-red-500 bg-red-50 @enderror">
                    @error('exp_date')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- AI Toggle -->
                <div class="form-group">
                    <label class="form-label">On AI</label>
                    <input type="checkbox" wire:model="on" value="1"
                        class="toggle toggle-success @error('on') border-red-500 bg-red-50 @enderror">
                    @error('on')
                        <div class="form-error">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- System Message Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-base font-semibold text-white flex items-center">
                            <i class="fas fa-robot mr-2"></i>
                            Arahan AI
                        </h2>
                    </div>

                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label">Arahan AI</label>
                            <div class="relative">
                                <textarea wire:model="system_message" id="system_message_textarea"
                                    placeholder="Contoh: Anda adalah pembantu yang membantu pengguna dengan pertanyaan mereka."
                                    class="form-textarea resize-both min-h-[80px] max-h-[300px] @error('system_message') border-red-500 bg-red-50 @enderror"
                                    rows="100"></textarea>

                                <!-- Emoji Picker Button -->
                                <button type="button" onclick="toggleEmojiPicker()"
                                    class="absolute top-2 right-2 p-1 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none">
                                    <i class="fas fa-smile text-sm"></i>
                                </button>

                                <!-- Emoji Picker Dropdown -->
                                <div id="emojiPicker"
                                    class="absolute top-8 right-0 z-50 bg-white border border-gray-300 rounded shadow p-2 hidden w-56 max-h-40 overflow-y-auto">
                                    <div class="grid grid-cols-7 gap-1">
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😀')">😀</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😃')">😃</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😄')">😄</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😁')">😁</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😆')">😆</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😅')">😅</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤣')">🤣</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😂')">😂</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🙂')">🙂</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🙃')">🙃</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😉')">😉</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😊')">😊</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😇')">😇</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🥰')">🥰</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😍')">😍</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤩')">🤩</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😘')">😘</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😗')">😗</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😚')">😚</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😙')">😙</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🥲')">🥲</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😋')">😋</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😛')">😛</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😜')">😜</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤪')">🤪</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('😝')">😝</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤑')">🤑</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤗')">🤗</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤝')">🤝</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👍')">👍</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👎')">👎</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👌')">👌</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('✌️')">✌️</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤞')">🤞</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤟')">🤟</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤘')">🤘</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤙')">🤙</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👈')">👈</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👉')">👉</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👆')">👆</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🖕')">🖕</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👇')">👇</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('☝️')">☝️</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👏')">👏</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🙌')">🙌</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👐')">👐</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤲')">🤲</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤜')">🤜</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤛')">🤛</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('✊')">✊</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👊')">👊</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤚')">🤚</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👋')">👋</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🤏')">🤏</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('✍️')">✍️</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('💪')">💪</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦾')">🦾</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦿')">🦿</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦵')">🦵</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦶')">🦶</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👂')">👂</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦻')">🦻</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👃')">👃</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🧠')">🧠</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🫀')">🫀</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🫁')">🫁</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦷')">🦷</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🦴')">🦴</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👀')">👀</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👁️')">👁️</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👅')">👅</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('👄')">👄</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('💋')">💋</button>
                                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-sm"
                                            onclick="insertEmoji('🩸')">🩸</button>
                                    </div>
                                </div>
                            </div>
                            @error('system_message')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Textarea boleh dibesarkan/dikecilkan dengan menarik
                                sudut kanan bawah. Klik ikon emoji untuk menambah emoji.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-2">
                <!-- Contact Information Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-base font-semibold text-white flex items-center">
                            <i class="fas fa-address-book mr-2"></i>
                            Maklumat Hubungan
                        </h2>
                    </div>

                    <div class="form-card-body">
                        <div class="space-y-3">
                            <!-- Phone Number -->
                            <div class="form-group">
                                <label class="form-label">No. Telefon <span class="text-red-500">*</span></label>
                                <input type="tel" wire:model="no_tel" placeholder="Contoh: 012-3456789"
                                    class="form-input @error('no_tel') border-red-500 bg-red-50 @enderror">
                                @error('no_tel')
                                    <div class="form-error">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div class="form-group">
                                <label class="form-label">Alamat Bisnes <span class="text-red-500">*</span></label>
                                <textarea wire:model="alamat" rows="1"
                                    placeholder="Contoh: No. 12, Jalan Setia 3, Taman Setia, 50450 Kuala Lumpur"
                                    class="form-textarea @error('alamat') border-red-500 bg-red-50 @enderror"></textarea>
                                @error('alamat')
                                    <div class="form-error">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div class="form-group">
                                <label class="form-label">Poskod <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="poskod" maxlength="5" placeholder="Contoh: 50450"
                                    class="form-input @error('poskod') border-red-500 bg-red-50 @enderror">
                                @error('poskod')
                                    <div class="form-error">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Upload Card -->
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-base font-semibold text-white flex items-center">
                            <i class="fas fa-image mr-2"></i>
                            Logo Bisnes
                        </h2>
                    </div>

                    <div class="form-card-body">
                        <div class="form-group">
                            <label class="form-label">Logo Bisnes (Pilihan)</label>
                            <div class="flex items-center">
                                @if ($existing_gambar && !$gambar)
                                    <div class="flex-shrink-0">
                                        <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($existing_gambar) }}"
                                            alt="{{ $nama_bisnes }}"
                                            class="w-12 h-12 object-cover rounded border border-gray-300">
                                    </div>
                                @else
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center border border-gray-300">
                                            <i class="fas fa-building text-gray-400 text-sm"></i>
                                        </div>
                                    </div>
                                @endif
                                <div class="ml-3">
                                    <input type="file" wire:model="gambar" accept="image/*"
                                        class="form-input @error('gambar') border-red-500 bg-red-50 @enderror">
                                </div>
                            </div>
                            @error('gambar')
                                <div class="form-error">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Format yang disokong: JPG, JPEG, PNG. Saiz maksimum:
                                2MB</p>
                            @if ($isEdit)
                                <p class="mt-1 text-xs text-gray-500">Biarkan kosong untuk mengekalkan imej semasa</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-base font-semibold text-white flex items-center">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Tindakan
                        </h2>
                    </div>
                    <div class="form-card-body">
                        <div class="flex flex-col sm:flex-row gap-3 justify-end">
                            <a href="{{ route('bisnes.index') }}" class="btn-secondary">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium px-4 py-2 rounded-lg shadow-md hover:shadow-lg transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                <i class="fas fa-save mr-1"></i>
                                {{ $isEdit ? 'Kemaskini Bisnes' : 'Simpan Bisnes' }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>

<script>
    function toggleEmojiPicker() {
        const emojiPicker = document.getElementById('emojiPicker');
        emojiPicker.classList.toggle('hidden');
    }

    function insertEmoji(emoji) {
        const textarea = document.getElementById('system_message_textarea');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);

        textarea.value = before + emoji + after;
        textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
        textarea.focus();

        // Trigger Livewire update
        textarea.dispatchEvent(new Event('input'));

        // Hide emoji picker
        document.getElementById('emojiPicker').classList.add('hidden');
    }

    // Close emoji picker when clicking outside
    document.addEventListener('click', function(event) {
        const emojiPicker = document.getElementById('emojiPicker');
        const emojiButton = event.target.closest('button[onclick="toggleEmojiPicker()"]');
        const emojiPickerElement = event.target.closest('#emojiPicker');

        if (!emojiButton && !emojiPickerElement && !emojiPicker.classList.contains('hidden')) {
            emojiPicker.classList.add('hidden');
        }
    });
</script>
