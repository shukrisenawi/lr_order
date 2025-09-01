@extends('layouts.app')

@section('title', 'Cipta Iklan Baru')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-100 relative overflow-hidden">
        <!-- Animated Background Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div
                class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-purple-600/20 rounded-full blur-3xl animate-pulse">
            </div>
            <div
                class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-tr from-indigo-400/20 to-pink-600/20 rounded-full blur-3xl animate-pulse delay-1000">
            </div>
            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-gradient-to-r from-cyan-400/10 to-blue-600/10 rounded-full blur-3xl animate-spin"
                style="animation-duration: 20s;"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 py-8 max-w-7xl">
            <!-- Header Section -->
            <div class="text-center mb-12">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 rounded-3xl shadow-2xl mb-6 transform hover:scale-105 transition-all duration-300">
                    <i class="fas fa-magic text-white text-3xl"></i>
                </div>
                <h1
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-gray-900 via-blue-800 to-indigo-800 bg-clip-text text-transparent mb-4">
                    Cipta Iklan AI Pintar
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    Buat iklan yang menarik dengan teknologi AI terkini. Sistem kami akan membantu mengoptimumkan iklan anda
                    untuk hasil yang maksimum.
                </p>

                <!-- Feature Badges -->
                <div class="flex flex-wrap justify-center items-center gap-4 mt-8">
                    <div
                        class="group flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-blue-200/50 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-brain text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-blue-800">AI Smart Generation</span>
                    </div>
                    <div
                        class="group flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-purple-200/50 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-chart-line text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-purple-800">Auto Optimization</span>
                    </div>
                    <div
                        class="group flex items-center px-6 py-3 bg-white/80 backdrop-blur-sm rounded-full shadow-lg border border-emerald-200/50 hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-green-600 rounded-full flex items-center justify-center mr-3 group-hover:rotate-12 transition-transform duration-300">
                            <i class="fas fa-rocket text-white text-sm"></i>
                        </div>
                        <span class="font-semibold text-emerald-800">Real-time Analytics</span>
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-center mb-8">
                <div class="flex gap-4">
                    <a href="{{ route('iklan.index') }}"
                        class="group flex items-center px-6 py-3 bg-white/90 backdrop-blur-sm hover:bg-white text-gray-700 font-semibold rounded-2xl shadow-lg border border-gray-200/60 transition-all duration-300 hover:shadow-xl hover:scale-105">
                        <i class="fas fa-list mr-3 group-hover:scale-110 transition-transform duration-200"></i>
                        <span>Semua Iklan</span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-500/0 via-blue-500/5 to-blue-500/0 rounded-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <a href="{{ route('iklan.index') }}"
                        class="group flex items-center px-6 py-3 bg-gradient-to-r from-slate-600 to-slate-800 hover:from-slate-700 hover:to-slate-900 text-white font-semibold rounded-2xl shadow-xl transition-all duration-300 hover:shadow-2xl hover:scale-105">
                        <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-200"></i>
                        <span>Kembali</span>
                    </a>
                </div>
            </div>

            <!-- Main Form Container -->
            <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-50 via-white to-purple-50 px-8 py-6 border-b border-gray-200/60">
                    <div class="flex items-center">
                        <div
                            class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg mr-6">
                            <i class="fas fa-ad text-white text-2xl"></i>
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 mb-2">Maklumat Iklan</h2>
                            <p class="text-gray-600">Lengkapkan maklumat di bawah untuk mencipta iklan yang berkesan</p>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('iklan.store') }}" class="p-8">
                    @csrf

                    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
                        <!-- Left Column - Main Form Fields -->
                        <div class="xl:col-span-2 space-y-8">
                            <!-- Nama Iklan -->
                            <div class="group">
                                <label class="flex items-center text-lg font-bold text-gray-800 mb-4">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-tag text-white"></i>
                                    </div>
                                    Nama Iklan
                                    <span class="text-red-500 ml-2">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                        <i class="fas fa-ad text-gray-400 text-xl"></i>
                                    </div>
                                    <input type="text" name="nama_iklan" value="{{ old('nama_iklan') }}" required
                                        placeholder="Contoh: Promosi Hebat Produk Terbaru 2024"
                                        class="w-full pl-16 pr-6 py-4 text-lg border-2 border-gray-200 rounded-2xl bg-white hover:bg-gray-50 focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100/50 focus:outline-none transition-all duration-300 shadow-sm hover:shadow-md @error('nama_iklan') border-red-500 bg-red-50 @enderror">
                                </div>
                                @error('nama_iklan')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-3 text-sm text-gray-500">Gunakan nama yang menarik dan mudah diingati untuk
                                    iklan anda</p>
                            </div>

                            <!-- Hari Tayangan -->
                            <div class="group">
                                <label class="flex items-center text-lg font-bold text-gray-800 mb-4">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-calendar-day text-white"></i>
                                    </div>
                                    Hari Tayangan
                                    <span class="text-red-500 ml-2">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                                        <i class="fas fa-hashtag text-gray-400 text-xl"></i>
                                    </div>
                                    <input type="number" step="1" min="1" name="hari"
                                        value="{{ old('hari', $latestDay + 1) }}" required placeholder="1"
                                        class="w-full pl-16 pr-6 py-4 text-lg border-2 border-gray-200 rounded-2xl bg-white hover:bg-gray-50 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-100/50 focus:outline-none transition-all duration-300 shadow-sm hover:shadow-md @error('hari') border-red-500 bg-red-50 @enderror">
                                </div>
                                @error('hari')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-3 text-sm text-gray-500">Tentukan hari ke berapa iklan ini akan ditayangkan
                                    dalam kempen anda</p>
                            </div>

                            <!-- Keterangan Iklan -->
                            <div class="group">
                                <label class="flex items-center text-lg font-bold text-gray-800 mb-4">
                                    <div
                                        class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                    Keterangan Iklan
                                    <span class="text-red-500 ml-2">*</span>
                                </label>
                                <div class="relative">
                                    <textarea name="keterangan" id="info_textarea_create" required
                                        class="w-full px-6 py-4 pr-16 text-lg border-2 border-gray-200 rounded-2xl bg-white hover:bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring-4 focus:ring-purple-100/50 focus:outline-none transition-all duration-300 resize-y shadow-sm hover:shadow-md @error('keterangan') border-red-500 bg-red-50 @enderror"
                                        rows="12"
                                        placeholder="Tulis keterangan iklan yang menarik dan informatif...

Contoh:
🚀 Produk terbaru dengan teknologi canggih
✨ Diskaun istimewa sehingga 50%
📞 Hubungi kami sekarang untuk tawaran eksklusif
🎯 Terhad untuk 100 pelanggan pertama sahaja

💡 Anda boleh masukkan gambar menggunakan butang imej atau pilih dari gambar yang diupload">{{ old('keterangan') }}</textarea>

                                    <!-- Enhanced Emoji Picker Button -->
                                    <button type="button" onclick="toggleEmojiPickerCreate()"
                                        class="absolute top-4 right-16 p-3 text-gray-400 hover:text-purple-600 transition-all duration-200 focus:outline-none rounded-xl hover:bg-purple-100 shadow-sm hover:shadow-md group">
                                        <i
                                            class="fas fa-smile text-2xl group-hover:scale-110 transition-transform duration-200"></i>
                                    </button>

                                    <!-- External Image Button -->
                                    <button type="button" onclick="insertImageCreate()"
                                        class="absolute top-4 right-8 p-3 text-gray-400 hover:text-blue-600 transition-all duration-200 focus:outline-none rounded-xl hover:bg-blue-100 shadow-sm hover:shadow-md group">
                                        <i
                                            class="fas fa-image text-2xl group-hover:scale-110 transition-transform duration-200"></i>
                                    </button>

                                    <!-- Select Uploaded Image Button -->
                                    <button type="button" onclick="toggleImagePickerCreate()"
                                        class="absolute top-4 right-4 p-3 text-gray-400 hover:text-green-600 transition-all duration-200 focus:outline-none rounded-xl hover:bg-green-100 shadow-sm hover:shadow-md group">
                                        <i
                                            class="fas fa-images text-2xl group-hover:scale-110 transition-transform duration-200"></i>
                                    </button>
                                </div>

                                <!-- Live Preview Area -->
                                <div class="mt-4">
                                    <div class="flex items-center mb-2">
                                        <i class="fas fa-eye text-purple-600 mr-2"></i>
                                        <span class="text-sm font-medium text-gray-700">Pratonton:</span>
                                    </div>
                                    <div id="live-preview" class="w-full min-h-[100px] p-4 border-2 border-gray-200 rounded-2xl bg-gray-50 text-gray-800 text-lg leading-relaxed">
                                        <!-- Preview content will be rendered here -->
                                    </div>
                                </div>

                                @error('keterangan')
                                    <p class="mt-3 text-sm text-red-600 flex items-center font-medium">
                                        <i class="fas fa-exclamation-circle mr-2"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                                <p class="mt-3 text-sm text-gray-500">Jelaskan produk atau perkhidmatan anda dengan menarik.
                                     Gunakan emoji dan gambar (external atau dari upload) untuk menarik perhatian!</p>
                            </div>
                        </div>

                        <!-- Right Column - Settings & Tips -->
                        <div class="space-y-6">
                            <!-- AI Settings Card -->
                            <div
                                class="bg-gradient-to-br from-purple-50 via-pink-50 to-rose-50 rounded-3xl p-6 border-2 border-purple-200/50 shadow-xl hover:shadow-2xl transition-all duration-300 group">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-brain text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-bold text-gray-900">AI Pintar</h3>
                                        <p class="text-sm text-gray-600">Pengoptimuman automatik</p>
                                    </div>
                                </div>

                                <div
                                    class="bg-white/80 backdrop-blur-sm rounded-2xl p-5 border border-purple-100/50 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div class="flex-1">
                                            <h4 class="text-lg font-bold text-gray-900 mb-2">Aktifkan AI</h4>
                                            <p class="text-sm text-gray-600 leading-relaxed">Benarkan sistem AI mengurus
                                                dan mengoptimumkan iklan secara automatik untuk hasil terbaik</p>
                                        </div>
                                        <label class="relative inline-flex items-center cursor-pointer ml-4">
                                            <input type="checkbox" name="on" value="1"
                                                {{ old('on') ? 'checked' : '' }} class="sr-only peer">
                                            <div
                                                class="w-16 h-9 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-7 after:w-7 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-pink-600 shadow-lg hover:shadow-xl transition-all duration-300">
                                            </div>
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

                            <!-- Enhanced Tips Card -->
                            <div
                                class="bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 rounded-3xl p-6 border-2 border-blue-200/50 shadow-xl hover:shadow-2xl transition-all duration-300">
                                <div class="flex items-center mb-6">
                                    <div
                                        class="w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-lightbulb text-white text-xl"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-xl font-bold text-gray-900">Tips Iklan</h3>
                                        <p class="text-sm text-gray-600">Panduan untuk iklan berkesan</p>
                                    </div>
                                </div>

                                <div class="space-y-4">
                                    <div
                                        class="group flex items-start p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-blue-100/50 shadow-sm hover:shadow-md transition-all duration-300">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mt-1 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-check text-white text-sm"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-bold text-gray-800 mb-1">Tajuk Menarik</h4>
                                            <p class="text-sm text-gray-600">Gunakan kata-kata yang kuat dan mudah diingati
                                            </p>
                                        </div>
                                    </div>

                                    <div
                                        class="group flex items-start p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-green-100/50 shadow-sm hover:shadow-md transition-all duration-300">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mt-1 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-star text-white text-sm"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-bold text-gray-800 mb-1">Nilai Produk</h4>
                                            <p class="text-sm text-gray-600">Tekankan faedah dan kelebihan produk anda</p>
                                        </div>
                                    </div>

                                    <div
                                        class="group flex items-start p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-purple-100/50 shadow-sm hover:shadow-md transition-all duration-300">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mt-1 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-magic text-white text-sm"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-bold text-gray-800 mb-1">Gunakan Emoji</h4>
                                            <p class="text-sm text-gray-600">Emoji membantu menarik perhatian dan emosi</p>
                                        </div>
                                    </div>

                                    <div
                                        class="group flex items-start p-4 bg-white/80 backdrop-blur-sm rounded-2xl border border-orange-100/50 shadow-sm hover:shadow-md transition-all duration-300">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-r from-orange-500 to-red-600 rounded-full flex items-center justify-center mt-1 shadow-sm group-hover:scale-110 transition-transform duration-300">
                                            <i class="fas fa-clock text-white text-sm"></i>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="font-bold text-gray-800 mb-1">Call-to-Action</h4>
                                            <p class="text-sm text-gray-600">Sertakan arahan jelas untuk tindakan pelanggan
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Stats Card -->
                            <div
                                class="bg-gradient-to-br from-emerald-50 via-green-50 to-teal-50 rounded-3xl p-6 border-2 border-emerald-200/50 shadow-xl">
                                <div class="flex items-center mb-4">
                                    <div
                                        class="w-12 h-12 bg-gradient-to-r from-emerald-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                                        <i class="fas fa-chart-bar text-white"></i>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-lg font-bold text-gray-900">Statistik Pantas</h3>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="text-center p-3 bg-white/60 rounded-xl">
                                        <div class="text-2xl font-bold text-emerald-600">{{ $latestDay + 1 }}</div>
                                        <div class="text-xs text-gray-600">Hari Seterusnya</div>
                                    </div>
                                    <div class="text-center p-3 bg-white/60 rounded-xl">
                                        <div class="text-2xl font-bold text-blue-600">AI</div>
                                        <div class="text-xs text-gray-600">Powered</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Emoji Picker -->
                    <div id="emojiPickerCreate"
                        class="bg-white/95 backdrop-blur-sm border-2 border-purple-200 rounded-2xl shadow-2xl p-4 hidden w-80 max-h-64 overflow-y-auto"
                        style="position: fixed !important; top: 64px !important; right: 16px !important; z-index: 9999 !important;">
                        <div class="mb-3">
                            <h4 class="font-bold text-gray-800 text-center">Pilih Emoji</h4>
                        </div>
                        <div class="grid grid-cols-8 gap-2">
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('😀')">😀</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('🤖')">🤖</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('💡')">💡</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('📝')">📝</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('✅')">✅</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('🚀')">🚀</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('🎯')">🎯</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('💪')">💪</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('⭐')">⭐</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('🔥')">🔥</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('💎')">💎</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('🎉')">🎉</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('💰')">💰</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('📞')">📞</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('💯')">💯</button>
                            <button type="button"
                                class="emoji-btn p-2 hover:bg-purple-100 rounded-xl text-2xl transition-all duration-200 hover:scale-110"
                                onclick="insertEmojiCreate('❤️')">❤️</button>
                        </div>
                    </div>

                    <!-- Image Picker Modal -->
                    <div id="imagePickerCreate"
                        class="bg-white/95 backdrop-blur-sm border-2 border-green-200 rounded-2xl shadow-2xl p-4 hidden w-96 max-h-96 overflow-y-auto"
                        style="position: fixed !important; top: 64px !important; right: 16px !important; z-index: 9999 !important;">
                        <div class="mb-3">
                            <h4 class="font-bold text-gray-800 text-center">Pilih Gambar dari Upload</h4>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            @if($gambar->count() > 0)
                                @foreach($gambar as $img)
                                    <div class="group cursor-pointer p-2 hover:bg-green-100 rounded-xl transition-all duration-200"
                                         onclick="event.stopPropagation(); selectUploadedImageCreate('{{ asset($img->path) }}')">
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

                    <!-- Action Buttons -->
                    <div class="mt-12 pt-8 border-t border-gray-200">
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('iklan.index') }}"
                                class="group inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-100 to-gray-200 hover:from-gray-200 hover:to-gray-300 text-gray-700 font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                                <i class="fas fa-times mr-3 group-hover:rotate-90 transition-transform duration-200"></i>
                                <span>Batal</span>
                            </a>
                            <button type="submit"
                                class="group relative inline-flex items-center justify-center px-12 py-4 bg-gradient-to-r from-blue-500 via-purple-500 to-indigo-600 hover:from-blue-600 hover:via-purple-600 hover:to-indigo-700 text-white font-bold rounded-2xl shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 overflow-hidden text-lg">
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700">
                                </div>
                                <i
                                    class="fas fa-magic mr-3 group-hover:rotate-12 transition-transform duration-300 relative z-10"></i>
                                <span class="relative z-10">Cipta Iklan Sekarang</span>

-10">Cipta Iklan Sekarang</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modals moved outside form for proper fixed positioning -->
    </div>

    <!-- JavaScript for Enhanced Functionality -->
    <script>
        // Enhanced Emoji Picker Functions
        function toggleEmojiPickerCreate() {
            const emojiPicker = document.getElementById('emojiPickerCreate');
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

        function insertEmojiCreate(emoji) {
            const textarea = document.getElementById('info_textarea_create');
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
            updateLivePreview();
        }

        function insertImageCreate() {
            const url = prompt('Masukkan URL gambar (external link yang boleh diakses dari luar):');
            if (url && url.trim() !== '') {
                const textarea = document.getElementById('info_textarea_create');
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
                updateLivePreview();
            }
        }

        function toggleImagePickerCreate() {
            const imagePicker = document.getElementById('imagePickerCreate');
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

        function selectUploadedImageCreate(url) {
            console.log('Image selected:', url); // Debug log
            const textarea = document.getElementById('info_textarea_create');
            const cursorPos = textarea.selectionStart;
            const textBefore = textarea.value.substring(0, cursorPos);
            const textAfter = textarea.value.substring(cursorPos);

            const imageMarkdown = `![Gambar](${url}) `;
            textarea.value = textBefore + imageMarkdown + textAfter;
            textarea.focus();
            textarea.setSelectionRange(cursorPos + imageMarkdown.length, cursorPos + imageMarkdown.length);

            // Close the picker
            toggleImagePickerCreate();

            // Add a nice animation effect
            textarea.style.transform = 'scale(1.02)';
            setTimeout(() => {
                textarea.style.transform = 'scale(1)';
            }, 150);

            // Update live preview
            updateLivePreview();
        }

        function updateLivePreview() {
            const textarea = document.getElementById('info_textarea_create');
            const preview = document.getElementById('live-preview');
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
            const emojiPicker = document.getElementById('emojiPickerCreate');
            const imagePicker = document.getElementById('imagePickerCreate');
            const emojiButton = event.target.closest('button[onclick="toggleEmojiPickerCreate()"]');
            const imageButton = event.target.closest('button[onclick="toggleImagePickerCreate()"]');
            const emojiPickerElement = event.target.closest('#emojiPickerCreate');
            const imagePickerElement = event.target.closest('#imagePickerCreate');

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
                        Sedang Memproses...
                    </div>
                `;
                submitButton.disabled = true;
            });

            // Add character counter for textarea
            const textarea = document.getElementById('info_textarea_create');
            if (textarea) {
                const counterDiv = document.createElement('div');
                counterDiv.className = 'text-sm text-gray-500 mt-2 text-right';
                counterDiv.id = 'char-counter';
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
                textarea.addEventListener('input', updateLivePreview); // Add live preview update
                updateCounter(); // Initial count
                updateLivePreview(); // Initial preview
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
        /* Additional custom styles for enhanced UX */
        .focused {
            transform: scale(1.02);
            transition: transform 0.2s ease;
        }

        /* Smooth animations for all interactive elements */
        * {
            transition: all 0.3s ease;
        }

        /* Custom scrollbar for emoji picker */
        #emojiPickerCreate::-webkit-scrollbar {
            width: 6px;
        }

        #emojiPickerCreate::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #emojiPickerCreate::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
        }

        #emojiPickerCreate::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        /* Floating animation for background elements */
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-10px) rotate(1deg); }
            66% { transform: translateY(5px) rotate(-1deg); }
        }

        /* Pulse animation for important elements */
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
            50% { box-shadow: 0 0 30px rgba(59, 130, 246, 0.6); }
        }

        /* Enhanced gradient animations */
        @keyframes gradient-shift {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }

        .animate-gradient {
            background-size: 200% 200%;
            animation: gradient-shift 3s ease infinite;
        }

        /* Ensure image picker items are clickable */
        #imagePickerCreate .cursor-pointer {
            cursor: pointer !important;
            pointer-events: auto !important;
        }

        #imagePickerCreate img {
            pointer-events: none !important; /* Prevent img click from interfering */
        }
    </style>
@endsection
