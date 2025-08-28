@extends('layouts.app')

@section('title', 'Kemaskini Iklan')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Cipta Iklan Baru</h1>
                    <p class="text-gray-600">Tambah iklan baru ke inventori</p>
                </div>
                <a href="{{ route('iklan.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Iklan</h3>
                <p class="text-gray-600 text-sm mt-1">Sila isi semua maklumat yang diperlukan</p>
            </div>

            <form method="POST" action="{{ route('iklan.update', $iklan) }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Iklan <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_iklan" value="{{ old('nama_iklan', $iklan->nama_iklan) }}"
                                required placeholder="Contoh: Iklan ABC"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('nama_iklan') border-red-500 bg-red-50 @enderror">
                            @error('nama_iklan')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">On AI </label>
                            <input type="checkbox" name="on" value="1"
                                {{ old('on', $iklan->on) ? 'checked' : '' }}
                                class="toggle toggle-success @error('on') border-red-500 bg-red-50 @enderror">
                            @error('on')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Hari <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">Ke</span>
                                </div>
                                <input type="number" step="0" name="hari" value="{{ old('hari', $iklan->hari) }}"
                                    required placeholder="0"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('hari') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('hari')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                    </div>
                </div>
                <div class="mt-6">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Iklan<span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <textarea name="keterangan" id="info_textarea_create" required
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 resize-both min-h-[100px] max-h-[400px]"
                            rows="100">{{ old('keterangan', $iklan->keterangan) }}</textarea>

                        <!-- Emoji Picker Button -->
                        <button type="button" onclick="toggleEmojiPickerCreate()"
                            class="absolute top-3 right-3 p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-smile text-lg"></i>
                        </button>

                        <!-- Emoji Picker Dropdown -->
                        <div id="emojiPickerCreate"
                            class="absolute top-12 right-0 z-50 bg-white border border-gray-300 rounded-lg shadow-lg p-3 hidden w-64 max-h-48 overflow-y-auto">
                            <div class="grid grid-cols-8 gap-1">
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😀')">😀</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😃')">😃</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😄')">😄</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😁')">😁</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😆')">😆</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😅')">😅</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤣')">🤣</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😂')">😂</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🙂')">🙂</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🙃')">🙃</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😉')">😉</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😊')">😊</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😇')">😇</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🥰')">🥰</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😍')">😍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤩')">🤩</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😘')">😘</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😗')">😗</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😚')">😚</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😙')">😙</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🥲')">🥲</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😋')">😋</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😛')">😛</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😜')">😜</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤪')">🤪</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😝')">😝</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤑')">🤑</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤗')">🤗</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤭')">🤭</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤫')">🤫</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤔')">🤔</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤐')">🤐</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤨')">🤨</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😐')">😐</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😑')">😑</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😶')">😶</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😏')">😏</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😒')">😒</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🙄')">🙄</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😬')">😬</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤥')">🤥</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😔')">😔</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😕')">😕</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🙁')">🙁</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('☹️')">☹️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😣')">😣</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😖')">😖</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😫')">😫</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😩')">😩</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🥺')">🥺</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😢')">😢</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😭')">😭</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😤')">😤</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😠')">😠</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😡')">😡</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤬')">🤬</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤯')">🤯</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😳')">😳</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🥵')">🥵</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🥶')">🥶</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😱')">😱</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😨')">😨</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😰')">😰</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😥')">😥</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('😓')">😓</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤝')">🤝</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👍')">👍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👎')">👎</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👌')">👌</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('✌️')">✌️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤞')">🤞</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤟')">🤟</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤘')">🤘</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤙')">🤙</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👈')">👈</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👉')">👉</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👆')">👆</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👇')">👇</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('☝️')">☝️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👏')">👏</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🙌')">🙌</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👐')">👐</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤲')">🤲</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤜')">🤜</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤛')">🤛</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('✊')">✊</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👊')">👊</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤚')">🤚</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👋')">👋</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤏')">🤏</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('✍️')">✍️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💪')">💪</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('👍')">👍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('❤️')">❤️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💕')">💕</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💖')">💖</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💗')">💗</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💙')">💙</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💚')">💚</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💛')">💛</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🧡')">🧡</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💜')">💜</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🖤')">🖤</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤍')">🤍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('🤎')">🤎</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💔')">💔</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('❣️')">❣️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('💟')">💟</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiCreate('♥️')">♥️</button>
                            </div>
                        </div>
                    </div>
                    @error('keterangan')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Klik ikon emoji untuk menambah emoji.</p>
                </div>
                <!-- Actions -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('iklan.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Cipta Iklan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
