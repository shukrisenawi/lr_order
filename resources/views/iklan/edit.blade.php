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
                                        class="absolute top-4 right-4 p-3 text-gray-400 hover:text-purple-600 transition-colors duration-200 focus:outline-none rounded-xl hover:bg-purple-100 shadow-sm">
                                        <i class="fas fa-smile text-xl"></i>
                                    </button>
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
                <!-- Emoji Picker Dropdown (moved here for better organization) -->
                <div id="emojiPickerCreate"
                    class="absolute top-12 right-0 z-50 bg-white border border-gray-300 rounded-lg shadow-lg p-3 hidden w-64 max-h-48 overflow-y-auto">
                    <div class="grid grid-cols-8 gap-1">
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('😀')">😀</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('🤖')">🤖</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('💡')">💡</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('📝')">📝</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('✅')">✅</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('🚀')">🚀</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('🎯')">🎯</button>
                        <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                            onclick="insertEmojiCreate('💪')">💪</button>
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
    </div>
@endsection
