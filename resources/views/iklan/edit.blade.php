@extends('layouts.app')

@section('title', 'Kemaskini Iklan')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                            <i class="fas fa-edit text-blue-500 mr-4"></i>
                            Kemaskini Iklan
                        </h1>
                        <p class="text-gray-600 text-lg">Kemaskini maklumat iklan #{{ $iklan->id }} dengan teknologi AI terkini</p>
                        <div class="flex items-center gap-4 mt-6">
                            <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-2 border-blue-200 shadow-sm">
                                <i class="fas fa-hashtag mr-2 text-blue-600"></i>
                                Iklan #{{ $iklan->id }}
                            </div>
                            <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200 shadow-sm">
                                <i class="fas fa-calendar-day mr-2 text-green-600"></i>
                                Hari {{ $iklan->hari }}
                            </div>
                            <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold
                                {{ $iklan->on ? 'bg-green-100 text-green-800 border-2 border-green-200' : 'bg-gray-100 text-gray-800 border-2 border-gray-200' }} shadow-sm">
                                <i class="fas fa-{{ $iklan->on ? 'robot' : 'pause' }} mr-2"></i>
                                {{ $iklan->on ? 'AI Aktif' : 'AI Tidak Aktif' }}
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('iklan.show', $iklan) }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl shadow-lg border-2 border-gray-200 transition-all duration-300 hover:shadow-xl">
                            <i class="fas fa-eye mr-2"></i>
                            Lihat Iklan
                        </a>
                        <a href="{{ route('iklan.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-bold rounded-xl shadow-xl hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-gray-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                            <i class="fas fa-arrow-left mr-3"></i>
                            Kembali ke Senarai
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                            <i class="fas fa-edit text-white text-xl"></i>
                        </div>
                        <div class="ml-6">
                            <h3 class="text-2xl font-bold text-gray-900">Maklumat Iklan</h3>
                            <p class="text-gray-600 text-lg mt-1">Kemaskini maklumat iklan dengan teliti menggunakan teknologi AI</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('iklan.update', $iklan) }}" class="p-8">
                    @csrf
                    @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Basic Information -->
                    <div class="lg:col-span-2 space-y-6">
                            <!-- Nama Iklan -->
                            <div class="relative">
                                <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-tag text-white text-sm"></i>
                                    </div>
                                    Nama Iklan
                                    <span class="text-red-500 ml-2 text-xl">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <i class="fas fa-ad text-gray-400 text-lg"></i>
                                    </div>
                                    <input type="text" name="nama_iklan" value="{{ old('nama_iklan', $iklan->nama_iklan) }}"
                                        required placeholder="Contoh: Promosi Produk ABC"
                                        class="w-full pl-14 pr-6 py-5 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-xl font-medium shadow-sm hover:shadow-md @error('nama_iklan') border-red-500 bg-red-50 @enderror">
                                </div>
                                @error('nama_iklan')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Hari -->
                            <div class="relative">
                                <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-calendar-day text-white text-sm"></i>
                                    </div>
                                    Hari Tayangan
                                    <span class="text-red-500 ml-2 text-xl">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
                                        <i class="fas fa-hashtag text-gray-400 text-lg"></i>
                                    </div>
                                    <input type="number" step="1" min="1" name="hari"
                                        value="{{ old('hari', $iklan->hari) }}" required placeholder="1"
                                        class="w-full pl-14 pr-6 py-5 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-xl font-medium shadow-sm hover:shadow-md @error('hari') border-red-500 bg-red-50 @enderror">
                                </div>
                                <p class="mt-3 text-sm text-gray-600 font-medium">Hari ke berapa iklan ini akan ditayangkan</p>
                                @error('hari')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Keterangan -->
                            <div class="relative">
                                <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center">
                                    <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3">
                                        <i class="fas fa-file-alt text-white text-sm"></i>
                                    </div>
                                    Keterangan Iklan
                                    <span class="text-red-500 ml-2 text-xl">*</span>
                                </label>
                                <div class="relative">
                                    <textarea name="keterangan" id="info_textarea_edit" required
                                        class="w-full px-6 py-5 pr-14 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 resize-both min-h-[140px] max-h-[400px] text-xl font-medium shadow-sm hover:shadow-md @error('keterangan') border-red-500 bg-red-50 @enderror"
                                        rows="6" placeholder="Jelaskan kandungan iklan anda...">{{ old('keterangan', $iklan->keterangan) }}</textarea>

                                    <!-- Emoji Picker Button -->
                                    <button type="button" onclick="toggleEmojiPickerEdit()"
                                        class="absolute top-4 right-16 p-3 text-gray-400 hover:text-purple-600 transition-colors duration-200 focus:outline-none rounded-xl hover:bg-purple-100 shadow-sm">
                                        <i class="fas fa-smile text-xl"></i>
                                    </button>

                                    <!-- External Image Button -->
                                    <button type="button" onclick="insertImageEdit()"
                                        class="absolute top-4 right-8 p-3 text-gray-400 hover:text-blue-600 transition-all duration-200 focus:outline-none rounded-xl hover:bg-blue-100 shadow-sm hover:shadow-md">
                                        <i class="fas fa-image text-xl"></i>
                                    </button>

                                    <!-- Select Uploaded Image Button -->
                                    <button type="button" onclick="toggleImagePickerEdit()"
                                        class="absolute top-4 right-4 p-3 text-gray-400 hover:text-green-600 transition-all duration-200 focus:outline-none rounded-xl hover:bg-green-100 shadow-sm hover:shadow-md">
                                        <i class="fas fa-images text-xl"></i>
                                    </button>
                                </div>

                                <!-- Live Preview Area -->
                                <div class="mt-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-eye text-purple-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Pratonton:</span>
                                    </div>
                                    <div id="live-preview-edit" class="w-full min-h-[100px] p-4 border-2 border-gray-200 rounded-2xl bg-gray-50 text-gray-800 text-lg leading-relaxed">
                                        <!-- Preview content will be rendered here -->
                                    </div>
                                </div>

                                <p class="mt-3 text-sm text-gray-600 font-medium">Klik ikon emoji untuk menambah emoji ke dalam keterangan</p>
                                @error('keterangan')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                    </div>

                    <!-- Right Column - Settings -->
                    <div class="space-y-6">
                            <!-- AI Settings Card -->
                            <div class="bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 rounded-3xl p-8 border-2 border-purple-200 shadow-lg">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-brain text-white text-lg"></i>
                                    </div>
                                    <h4 class="ml-4 text-lg font-bold text-gray-900">Tetapan AI Canggih</h4>
                                </div>

                                <div class="space-y-6">
                                    <div class="flex items-center justify-between p-4 bg-white/60 rounded-2xl border border-purple-100">
                                        <div>
                                            <p class="text-base font-bold text-gray-900">Aktifkan AI Pintar</p>
                                            <p class="text-sm text-gray-600 mt-1">Benarkan AI mengurus dan mengoptimumkan iklan ini secara automatik</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="on" value="1"
                                                {{ old('on', $iklan->on) ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-pink-600 shadow-md"></div>
                                        </label>
                                    </div>
                                </div>
                                @error('on')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Info Card -->
                            <div class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-3xl p-8 border-2 border-blue-200 shadow-lg">
                                <div class="flex items-center mb-6">
                                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-info-circle text-white text-lg"></i>
                                    </div>
                                    <h4 class="ml-4 text-lg font-bold text-gray-900">Maklumat Iklan</h4>
                                </div>

                                <div class="space-y-4">
                                    <div class="flex items-center justify-between p-4 bg-white/60 rounded-2xl border border-blue-100">
                                        <div class="flex items-center">
                                            <i class="fas fa-hashtag text-blue-500 mr-3"></i>
                                            <span class="text-sm text-gray-600">ID Iklan:</span>
                                        </div>
                                        <span class="text-lg font-bold text-blue-600">#{{ $iklan->id }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-white/60 rounded-2xl border border-blue-100">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-plus text-green-500 mr-3"></i>
                                            <span class="text-sm text-gray-600">Dicipta:</span>
                                        </div>
                                        <span class="text-lg font-bold text-green-600">{{ $iklan->created_at->format('d M Y') }}</span>
                                    </div>
                                    <div class="flex items-center justify-between p-4 bg-white/60 rounded-2xl border border-blue-100">
                                        <div class="flex items-center">
                                            <i class="fas fa-{{ $iklan->on ? 'robot' : 'pause' }} text-{{ $iklan->on ? 'purple' : 'gray' }}-500 mr-3"></i>
                                            <span class="text-sm text-gray-600">Status:</span>
                                        </div>
                                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold
                                            {{ $iklan->on ? 'bg-green-100 text-green-800 border-2 border-green-200' : 'bg-gray-100 text-gray-800 border-2 border-gray-200' }} shadow-sm">
                                            {{ $iklan->on ? 'AI Aktif' : 'AI Tidak Aktif' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <!-- Emoji Picker Dropdown -->
                <div id="emojiPickerEdit"
                    class="bg-white border border-gray-300 rounded-lg shadow-lg p-3 hidden w-64 max-h-48 overflow-y-auto"
                    style="position: fixed !important; top: 48px !important; right: 0px !important; z-index: 9999 !important;">
                    <div class="grid grid-cols-8 gap-1">
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('😀')">😀</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('🤖')">🤖</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('💡')">💡</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('📝')">📝</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('✅')">✅</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('🚀')">🚀</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('🎯')">🎯</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiEdit('💪')">💪</button>
                    </div>
                </div>

                <!-- Image Picker Modal -->
                <div id="imagePickerEdit"
                    class="bg-white/95 backdrop-blur-sm border-2 border-green-200 rounded-2xl shadow-2xl p-4 hidden w-96 max-h-96 overflow-y-auto"
                    style="position: fixed !important; top: 64px !important; right: 16px !important; z-index: 9999 !important;">
                    <div class="mb-3">
                        <h4 class="font-bold text-gray-800 text-center">Pilih Gambar dari Upload</h4>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        @if($gambar->count() > 0)
                            @foreach($gambar as $img)
                                <div class="group cursor-pointer p-2 hover:bg-green-100 rounded-xl transition-all duration-200"
                                     onclick="event.stopPropagation(); selectUploadedImageEdit('{{ asset($img->path) }}')">
                                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-2">
                                        <img src="{{ asset($img->path) }}" alt="{{ $img->nama }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-200"
                                             onclick="event.stopPropagation();">
                                    </div>
                                    <p class="text-xs text-gray-600 text-center truncate">{{ $img->nama }}</p>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-2 text-center py-8">
                                <i class="fas fa-images text-gray-400 text-3xl mb-2"></i>
                                <p class="text-gray-500 text-sm">Tiada gambar yang diupload</p>
                                <a href="{{ route('gambar.create') }}" class="text-blue-500 text-sm hover:underline">Upload gambar baru</a>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Actions -->
                <div class="mt-12 flex flex-col sm:flex-row justify-end space-y-6 sm:space-y-0 sm:space-x-6">
                    <a href="{{ route('iklan.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-sm hover:shadow-md">
                        <i class="fas fa-times mr-3 text-lg"></i>
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-10 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                        <i class="fas fa-save mr-3 text-lg"></i>
                        Kemaskini Iklan
                    </button>
                </div>
            </form>
        </div>

        <!-- Modals moved outside form for proper fixed positioning -->
    </div>

    <script>
        // Enhanced Emoji Picker Functions for Edit
        function toggleEmojiPickerEdit() {
            const emojiPicker = document.getElementById('emojiPickerEdit');
            const isHidden = emojiPicker.classList.contains('hidden');

            if (isHidden) {
                emojiPicker.classList.remove('hidden');
                emojiPicker.style.opacity = '0';
                emojiPicker.style.transform = 'translateY(-10px) scale(0.95)';

                setTimeout(() => {
                    emojiPicker.style.transition = 'all 0.3s ease';
                    emojiPicker.style.opacity = '1';
                    emojiPicker.style.transform = 'translateY(0) scale(1)';
                }, 10);
            } else {
                emojiPicker.style.transition = 'all 0.3s ease';
                emojiPicker.style.opacity = '0';
                emojiPicker.style.transform = 'translateY(-10px) scale(0.95)';

                setTimeout(() => {
                    emojiPicker.classList.add('hidden');
                }, 300);
            }
        }

        function insertEmojiEdit(emoji) {
            const textarea = document.getElementById('info_textarea_edit');
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);

            textarea.value = textBefore + emoji + ' ' + textAfter;
            textarea.focus();
            textarea.setSelectionRange(cursorPos + emoji.length + 1, cursorPos + emoji.length + 1);

            // Add a nice animation effect
            textarea.style.transform = 'scale(1.02)';
            setTimeout(() => {
                textarea.style.transform = 'scale(1)';
            }, 150);

            // Update live preview
            updateLivePreviewEdit();
        }

        function insertImageEdit() {
            const url = prompt('Masukkan URL gambar (external link yang boleh diakses dari luar):');
            if (url && url.trim() !== '') {
                const textarea = document.getElementById('info_textarea_edit');
                const cursorPos = textarea.selectionStart;
                const textBefore = textarea.value.substring(0, cursorPos);
                const textAfter = textarea.value.substring(cursorPos);

                const imageMarkdown = `![Gambar](${url.trim()}) `;
                textarea.value = textBefore + imageMarkdown + textAfter;
                textarea.focus();
                textarea.setSelectionRange(cursorPos + imageMarkdown.length, cursorPos + imageMarkdown.length);

                // Add a nice animation effect
                textarea.style.transform = 'scale(1.02)';
                setTimeout(() => {
                    textarea.style.transform = 'scale(1)';
                }, 150);

                // Update live preview
                updateLivePreviewEdit();
            }
        }

        function selectUploadedImageEdit(url) {
            console.log('Image selected (edit):', url); // Debug log
            const textarea = document.getElementById('info_textarea_edit');
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);

            const imageMarkdown = `![Gambar](${url}) `;
            textarea.value = textBefore + imageMarkdown + textAfter;
            textarea.focus();
            textarea.setSelectionRange(cursorPos + imageMarkdown.length, cursorPos + imageMarkdown.length);

            // Close the picker
            toggleImagePickerEdit();

            // Add a nice animation effect
            textarea.style.transform = 'scale(1.02)';
            setTimeout(() => {
                textarea.style.transform = 'scale(1)';
            }, 150);

            // Update live preview
            updateLivePreviewEdit();
        }

        function toggleImagePickerEdit() {
            const imagePicker = document.getElementById('imagePickerEdit');
            const isHidden = imagePicker.classList.contains('hidden');

            if (isHidden) {
                imagePicker.classList.remove('hidden');
                imagePicker.style.opacity = '0';
                imagePicker.style.transform = 'translateY(-10px) scale(0.95)';

                setTimeout(() => {
                    imagePicker.style.transition = 'all 0.3s ease';
                    imagePicker.style.opacity = '1';
                    imagePicker.style.transform = 'translateY(0) scale(1)';
                }, 10);
            } else {
                imagePicker.style.transition = 'all 0.3s ease';
                imagePicker.style.opacity = '0';
                imagePicker.style.transform = 'translateY(-10px) scale(0.95)';

                setTimeout(() => {
                    imagePicker.classList.add('hidden');
                }, 300);
            }
        }

        function updateLivePreviewEdit() {
            const textarea = document.getElementById('info_textarea_edit');
            const preview = document.getElementById('live-preview-edit');
            const content = textarea.value;

            // Convert markdown images to HTML
            let html = content
                .replace(/\!\[([^\]]*)\]\(([^)]+)\)/g, '<img src="$2" alt="$1" class="max-w-full h-auto rounded-lg shadow-sm my-2" style="max-height: 200px;">')
                .replace(/\n/g, '<br>');

            // If no content, show placeholder
            if (!content.trim()) {
                html = '<span class="text-gray-400 italic">Pratonton akan muncul di sini...</span>';
            }

            preview.innerHTML = html;
        }

        // Close emoji picker and image picker when clicking outside
        document.addEventListener('click', function(event) {
            const emojiPicker = document.getElementById('emojiPickerEdit');
            const imagePicker = document.getElementById('imagePickerEdit');
            const emojiButton = event.target.closest('button[onclick="toggleEmojiPickerEdit()"]');
            const imageButton = event.target.closest('button[onclick="toggleImagePickerEdit()"]');
            const emojiPickerElement = event.target.closest('#emojiPickerEdit');
            const imagePickerElement = event.target.closest('#imagePickerEdit');

            if (!emojiButton && !emojiPickerElement && !emojiPicker.classList.contains('hidden')) {
                emojiPicker.style.transition = 'all 0.3s ease';
                emojiPicker.style.opacity = '0';
                emojiPicker.style.transform = 'translateY(-10px) scale(0.95)';

                setTimeout(() => {
                    emojiPicker.classList.add('hidden');
                }, 300);
            }

            if (!imageButton && !imagePickerElement && !imagePicker.classList.contains('hidden')) {
                imagePicker.style.transition = 'all 0.3s ease';
                imagePicker.style.opacity = '0';
                imagePicker.style.transform = 'translateY(-10px) scale(0.95)';

                setTimeout(() => {
                    imagePicker.classList.add('hidden');
                }, 300);
            }
        });

        // Form Enhancement Functions
        document.addEventListener('DOMContentLoaded', function() {
            // Add floating label effect
            const inputs = document.querySelectorAll('input[type="text"], input[type="number"], textarea');

            inputs.forEach(input => {
                // Add focus and blur effects
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });

                // Add typing animation effect
                input.addEventListener('input', function() {
                    this.style.transform = 'scale(1.01)';
                    setTimeout(() => {
                        this.style.transform = 'scale(1)';
                    }, 100);
                });
            });

            // Add form validation feedback
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const submitButton = form.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;

                submitButton.innerHTML = `
                    <div class="flex items-center">
                        <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Mengemaskini...
                    </div>
                `;
                submitButton.disabled = true;
            });

            // Add character counter for textarea
            const textarea = document.getElementById('info_textarea_edit');
            if (textarea) {
                const counterDiv = document.createElement('div');
                counterDiv.className = 'text-sm text-gray-500 mt-2 text-right';
                counterDiv.id = 'char-counter-edit';
                textarea.parentElement.appendChild(counterDiv);

                function updateCounter() {
                    const count = textarea.value.length;
                    const maxLength = 1000; // Suggested max length
                    counterDiv.textContent = `${count}/${maxLength} aksara`;

                    if (count > maxLength * 0.9) {
                        counterDiv.className = 'text-sm text-orange-500 mt-2 text-right font-medium';
                    } else if (count > maxLength) {
                        counterDiv.className = 'text-sm text-red-500 mt-2 text-right font-medium';
                    } else {
                        counterDiv.className = 'text-sm text-gray-500 mt-2 text-right';
                    }
                }

                textarea.addEventListener('input', updateCounter);
                textarea.addEventListener('input', updateLivePreviewEdit); // Add live preview update
                updateCounter(); // Initial count
                updateLivePreviewEdit(); // Initial preview
            }

            // Add smooth scroll to form errors
            const errorElements = document.querySelectorAll('.text-red-600');
            if (errorElements.length > 0) {
                errorElements[0].scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            }
        });

        // Add some nice hover effects for cards
        document.querySelectorAll('.group').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });

            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>

    <style>
        /* Ensure image picker items are clickable */
        #imagePickerEdit .cursor-pointer {
            cursor: pointer !important;
            pointer-events: auto !important;
        }

        #imagePickerEdit img {
            pointer-events: none !important; /* Prevent img click from interfering */
        }
    </style>
@endsection
