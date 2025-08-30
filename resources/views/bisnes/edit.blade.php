@extends('layouts.app')

@section('title', 'Edit Business')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-edit text-orange-500 mr-3"></i>
                        Edit Business
                    </h1>
                    <p class="text-gray-600">Update business information for {{ $bisnes->nama_bisnes }}</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-orange-100 to-red-100 text-orange-800 border border-orange-200">
                            <i class="fas fa-clock mr-2"></i>
                            Last Updated: {{ $bisnes->updated_at->format('d M Y H:i') }}
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            <i class="fas fa-building mr-2"></i>
                            Business ID: {{ $bisnes->id }}
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('bisnes.show', $bisnes) }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-eye mr-1"></i>
                        View Details
                    </a>
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-red-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-orange-500 to-red-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">Update Business Information</h3>
                        <p class="text-gray-600 text-sm mt-1">Modify business details and AI settings below</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('bisnes.update', $bisnes) }}" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Business Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Bisnes <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_bisnes" value="{{ old('nama_bisnes', $bisnes->nama_bisnes) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_bisnes') border-red-500 bg-red-50 @enderror">
                            @error('nama_bisnes')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Syarikat <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="nama_syarikat"
                                value="{{ old('nama_syarikat', $bisnes->nama_syarikat) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('nama_syarikat') border-red-500 bg-red-50 @enderror">
                            @error('nama_syarikat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Registration Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No. Pendaftaran</label>
                            <input type="text" name="no_pendaftaran"
                                value="{{ old('no_pendaftaran', $bisnes->no_pendaftaran) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_pendaftaran') border-red-500 bg-red-50 @enderror">
                            @error('no_pendaftaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Tamat <span
                                    class="text-red-500">*</span></label>
                            <input type="date" name="exp_date" value="{{ old('exp_date', $bisnes->exp_date) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('exp_date') border-red-500 bg-red-50 @enderror">
                            @error('exp_date')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Prefix </label>
                            <input type="text" name="prefix" value="{{ old('prefix', $bisnes->prefix) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('prefix') border-red-500 bg-red-50 @enderror">
                            @error('prefix')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <label class="block text-sm font-semibold text-gray-800 mb-2">On AI </label>
                            <input type="checkbox" name="on" value="1"
                                {{ old('on', $bisnes->on) ? 'checked' : '' }}
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
                        <!-- Phone Number -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No. Telefon <span
                                    class="text-red-500">*</span></label>
                            <input type="tel" name="no_tel" value="{{ old('no_tel', $bisnes->no_tel) }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('no_tel') border-red-500 bg-red-50 @enderror">
                            @error('no_tel')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="poskod" value="{{ old('poskod', $bisnes->poskod) }}" required
                                maxlength="5"
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('poskod') border-red-500 bg-red-50 @enderror">
                            @error('poskod')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Bisnes <span
                                    class="text-red-500">*</span></label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('alamat') border-red-500 bg-red-50 @enderror">{{ old('alamat', $bisnes->alamat) }}</textarea>
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Jenis Sistem <span
                                    class="text-red-500">*</span></label>
                            <select name="type_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 @error('gambar_id') border-red-500 bg-red-50 @enderror">
                                <option value="">Pilih Jenis Sistem</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}"
                                        {{ old('type_id', $bisnes->type_id) == $type->id ? 'selected' : '' }}>
                                        {{ $type->type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Image -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Logo Bisnes (Pilihan)</label>
                            <div class="mt-1 flex items-center">
                                @if ($bisnes->gambar)
                                    <div class="flex-shrink-0">
                                        <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) }}"
                                            alt="{{ $bisnes->nama_bisnes }}"
                                            class="w-16 h-16 object-cover rounded-lg border border-gray-300">
                                    </div>
                                @else
                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center border border-gray-300">
                                            <i class="fas fa-building text-gray-400"></i>
                                        </div>
                                    </div>
                                @endif
                                <div class="ml-5">
                                    <input type="file" name="gambar" accept="image/*"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('gambar') border-red-500 bg-red-50 @enderror">
                                </div>
                            </div>
                            @error('gambar')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Format yang disokong: JPG, JPEG, PNG. Saiz maksimum: 2MB
                            </p>
                            <p class="mt-1 text-sm text-gray-500">Biarkan kosong untuk mengekalkan imej semasa</p>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Arahan AI<span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <textarea name="system_message" id="system_message_textarea_edit" required
                            placeholder="Contoh: Anda adalah pembantu yang membantu pengguna dengan pertanyaan mereka."
                            class="w-full px-4 py-3 pr-12 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 resize-both min-h-[100px] max-h-[400px]"
                            rows="100">{{ old('system_message', $bisnes->system_message) }}</textarea>

                        <!-- Emoji Picker Button -->
                        <button type="button" onclick="toggleEmojiPickerEdit()"
                            class="absolute top-3 right-3 p-2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none">
                            <i class="fas fa-smile text-lg"></i>
                        </button>

                        <!-- Emoji Picker Dropdown -->
                        <div id="emojiPickerEdit"
                            class="absolute top-12 right-0 z-50 bg-white border border-gray-300 rounded-lg shadow-lg p-3 hidden w-64 max-h-48 overflow-y-auto">
                            <div class="grid grid-cols-8 gap-1">
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😀')">😀</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😃')">😃</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😄')">😄</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😁')">😁</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😆')">😆</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😅')">😅</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤣')">🤣</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😂')">😂</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🙂')">🙂</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🙃')">🙃</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😉')">😉</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😊')">😊</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😇')">😇</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🥰')">🥰</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😍')">😍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤩')">🤩</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😘')">😘</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😗')">😗</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😚')">😚</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😙')">😙</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🥲')">🥲</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😋')">😋</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😛')">😛</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😜')">😜</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤪')">🤪</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😝')">😝</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤑')">🤑</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤗')">🤗</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤭')">🤭</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤫')">🤫</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤔')">🤔</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤐')">🤐</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤨')">🤨</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😐')">😐</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😑')">😑</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😶')">😶</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😏')">😏</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😒')">😒</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🙄')">🙄</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😬')">😬</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤥')">🤥</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😔')">😔</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😕')">😕</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🙁')">🙁</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('☹️')">☹️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😣')">😣</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😖')">😖</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😫')">😫</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😩')">😩</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🥺')">🥺</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😢')">😢</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😭')">😭</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😤')">😤</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😠')">😠</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😡')">😡</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤬')">🤬</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤯')">🤯</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😳')">😳</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🥵')">🥵</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🥶')">🥶</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😱')">😱</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😨')">😨</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😰')">😰</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😥')">😥</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('😓')">😓</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤝')">🤝</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👍')">👍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👎')">👎</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👌')">👌</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('✌️')">✌️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤞')">🤞</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤟')">🤟</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤘')">🤘</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤙')">🤙</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👈')">👈</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👉')">👉</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👆')">👆</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👇')">👇</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('☝️')">☝️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👏')">👏</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🙌')">🙌</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👐')">👐</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤲')">🤲</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤜')">🤜</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤛')">🤛</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('✊')">✊</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👊')">👊</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤚')">🤚</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('👋')">👋</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤏')">🤏</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('✍️')">✍️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💪')">💪</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('❤️')">❤️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💕')">💕</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💖')">💖</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💗')">💗</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💙')">💙</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💚')">💚</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💛')">💛</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🧡')">🧡</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💜')">💜</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🖤')">🖤</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤍')">🤍</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('🤎')">🤎</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💔')">💔</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('❣️')">❣️</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('💟')">💟</button>
                                <button type="button" class="emoji-btn p-1 hover:bg-gray-100 rounded text-lg"
                                    onclick="insertEmojiEdit('♥️')">♥️</button>
                            </div>
                        </div>
                    </div>
                    @error('system_message')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500">Textarea boleh dibesarkan/dikecilkan dengan menarik sudut kanan
                        bawah. Klik ikon emoji untuk menambah emoji.</p>
                </div>
                <!-- Action Buttons -->
                <div class="mt-10">
                    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-slate-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-gray-500 to-slate-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-save text-white"></i>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Ready to Update</h3>
                                    <p class="text-gray-600 text-sm mt-1">Review your changes and update the business information</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-6">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                                <!-- Help Text -->
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                        <i class="fas fa-info-circle text-blue-600 text-xs"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-gray-600">
                                            <strong>Note:</strong> Changes will be saved immediately. Make sure all information is correct before updating.
                                        </p>
                                    </div>
                                </div>

                                <!-- Buttons -->
                                <div class="flex flex-col sm:flex-row gap-3">
                                    <a href="{{ route('bisnes.show', $bisnes) }}"
                                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View Current
                                    </a>
                                    <a href="{{ route('bisnes.index') }}"
                                        class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                                        <i class="fas fa-times mr-2"></i>
                                        Cancel
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-orange-500 to-red-600 text-white font-semibold rounded-xl shadow-lg hover:from-orange-600 hover:to-red-700 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-orange-200 focus:ring-offset-2 transform hover:scale-105">
                                        <i class="fas fa-save mr-2"></i>
                                        Update Business
                                        <i class="fas fa-arrow-right ml-2"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

<script>
    function toggleEmojiPickerEdit() {
        const emojiPicker = document.getElementById('emojiPickerEdit');
        emojiPicker.classList.toggle('hidden');
    }

    function insertEmojiEdit(emoji) {
        const textarea = document.getElementById('system_message_textarea_edit');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);

        textarea.value = before + emoji + after;
        textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
        textarea.focus();

        // Hide emoji picker
        document.getElementById('emojiPickerEdit').classList.add('hidden');
    }

    // Close emoji picker when clicking outside
    document.addEventListener('click', function(event) {
        const emojiPicker = document.getElementById('emojiPickerEdit');
        const emojiButton = event.target.closest('button[onclick="toggleEmojiPickerEdit()"]');
        const emojiPickerElement = event.target.closest('#emojiPickerEdit');

        if (!emojiButton && !emojiPickerElement && !emojiPicker.classList.contains('hidden')) {
            emojiPicker.classList.add('hidden');
        }
    });
</script>
