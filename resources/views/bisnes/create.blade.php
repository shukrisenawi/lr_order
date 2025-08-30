@extends('layouts.app')

@section('title', 'Create New Business')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-plus-circle text-blue-500 mr-3"></i>
                        Create New Business
                    </h1>
                    <p class="text-gray-600">Set up a new business entity with AI integration</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            <i class="fas fa-building mr-2"></i>
                            Business Setup
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200">
                            <i class="fas fa-robot mr-2"></i>
                            AI Integration
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-list mr-1"></i>
                        View All
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
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Business Information</h3>
                <p class="text-gray-600 text-sm mt-1">Fill in all required business details and configure AI settings</p>
            </div>

            <form method="POST" action="{{ route('bisnes.store') }}" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Basic Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Business Name -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-building text-blue-500 mr-2"></i>
                                Business Name
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-store text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_bisnes" value="{{ old('nama_bisnes') }}" required
                                    placeholder="e.g., Kedai Runcit Maju"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-lg @error('nama_bisnes') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('nama_bisnes')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Company Name -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-briefcase text-green-500 mr-2"></i>
                                Company Name
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-industry text-gray-400"></i>
                                </div>
                                <input type="text" name="nama_syarikat" value="{{ old('nama_syarikat') }}" required
                                    placeholder="e.g., Kedai Runcit Maju Sdn Bhd"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-lg @error('nama_syarikat') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('nama_syarikat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Registration Number -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-id-card text-purple-500 mr-2"></i>
                                Registration Number
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                </div>
                                <input type="text" name="no_pendaftaran" value="{{ old('no_pendaftaran') }}"
                                    placeholder="e.g., 1234567890"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 text-lg @error('no_pendaftaran') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('no_pendaftaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Prefix -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-tag text-indigo-500 mr-2"></i>
                                Prefix
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-code text-gray-400"></i>
                                </div>
                                <input type="text" name="prefix" value="{{ old('prefix') }}"
                                    placeholder="e.g., INV, ORD"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-300 text-lg @error('prefix') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('prefix')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Expiry Date -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-calendar-times text-red-500 mr-2"></i>
                                Expiry Date
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-calendar-alt text-gray-400"></i>
                                </div>
                                <input type="date" name="exp_date" value="{{ old('exp_date') }}"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-300 text-lg @error('exp_date') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('exp_date')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Contact & Settings -->
                    <div class="space-y-6">
                        <!-- Phone Number -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-phone text-green-500 mr-2"></i>
                                Phone Number
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-mobile-alt text-gray-400"></i>
                                </div>
                                <input type="tel" name="no_tel" value="{{ old('no_tel') }}" required
                                    placeholder="e.g., 012-3456789"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-lg @error('no_tel') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('no_tel')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Address -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                Business Address
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-4 left-4 text-gray-400">
                                    <i class="fas fa-map-pin text-lg"></i>
                                </div>
                                <textarea name="alamat" rows="3" required
                                    placeholder="e.g., No. 12, Jalan Setia 3, Taman Setia, 50450 Kuala Lumpur"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-300 text-lg @error('alamat') border-red-500 bg-red-50 @enderror">{{ old('alamat') }}</textarea>
                            </div>
                            @error('alamat')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Postal Code -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-mailbox text-orange-500 mr-2"></i>
                                Postal Code
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-envelope text-gray-400"></i>
                                </div>
                                <input type="text" name="poskod" value="{{ old('poskod') }}" required maxlength="5"
                                    placeholder="e.g., 50450"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all duration-300 text-lg @error('poskod') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('poskod')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- System Type -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-cogs text-emerald-500 mr-2"></i>
                                System Type
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-sliders-h text-gray-400"></i>
                                </div>
                                <select name="type_id" required
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-emerald-100 focus:border-emerald-500 transition-all duration-300 text-lg @error('type_id') border-red-500 bg-red-50 @enderror">
                                    <option value="">Select System Type</option>
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('type_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Business Logo -->
                        <div class="bg-gradient-to-br from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-gray-500 to-slate-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-image text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">Business Logo</h4>
                            </div>

                            <div class="space-y-4">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                                        <i class="fas fa-building text-gray-400 text-xl"></i>
                                    </div>
                                    <div class="flex-1">
                                        <input type="file" name="gambar" accept="image/*"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300 @error('gambar') border-red-500 bg-red-50 @enderror">
                                        <p class="mt-2 text-sm text-gray-500">Supported formats: JPG, JPEG, PNG. Max size: 2MB</p>
                                    </div>
                                </div>
                                @error('gambar')
                                    <p class="text-sm text-red-600 flex items-center">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- AI Settings -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">AI Integration</h4>
                            </div>

                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Enable AI Features</p>
                                    <p class="text-xs text-gray-600 mt-1">Allow AI to assist with business operations</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="on" value="1" {{ old('on') ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-600"></div>
                                </label>
                            </div>
                            @error('on')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- AI System Message -->
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-200">
                    <div class="flex items-center mb-6">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-brain text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">AI System Instructions</h3>
                            <p class="text-gray-600 text-sm mt-1">Configure how the AI assistant should behave for this business</p>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-comment-dots text-purple-500 mr-2"></i>
                            System Message
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute top-4 left-4 text-gray-400">
                                <i class="fas fa-quote-left text-2xl"></i>
                            </div>
                            <textarea name="system_message" id="system_message_textarea_create" required
                                placeholder="e.g., You are a helpful assistant for Kedai Runcit Maju business. Help customers with their orders, provide product information, and assist with any inquiries they may have."
                                class="w-full pl-12 pr-12 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 resize-both min-h-[120px] max-h-[400px] text-lg @error('system_message') border-red-500 bg-red-50 @enderror"
                                rows="6">{{ old('system_message') }}</textarea>
                            <div class="absolute bottom-4 right-12 text-gray-400">
                                <i class="fas fa-quote-right text-2xl"></i>
                            </div>

                            <!-- Emoji Picker Button -->
                            <button type="button" onclick="toggleEmojiPickerCreate()"
                                class="absolute top-4 right-4 p-2 text-gray-400 hover:text-purple-600 transition-colors duration-200 focus:outline-none rounded-lg hover:bg-purple-100">
                                <i class="fas fa-smile text-lg"></i>
                            </button>
                        </div>

                        <!-- Emoji Picker Dropdown -->
                        <div id="emojiPickerCreate"
                            class="absolute top-16 right-4 z-50 bg-white border border-gray-300 rounded-lg shadow-lg p-3 hidden w-64 max-h-48 overflow-y-auto">
                            <div class="grid grid-cols-8 gap-1">
                                <!-- Keeping the emoji picker as is since it's functional -->
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

                        @error('system_message')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <!-- Help Text -->
                        <div class="mt-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-info-circle text-blue-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>AI Instructions:</strong> Define how the AI should interact with customers. Be specific about your business type, products, and communication style.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Create Business
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection


<script>
    function toggleEmojiPickerCreate() {
        const emojiPicker = document.getElementById('emojiPickerCreate');
        emojiPicker.classList.toggle('hidden');
    }

    function insertEmojiCreate(emoji) {
        const textarea = document.getElementById('system_message_textarea_create');
        const start = textarea.selectionStart;
        const end = textarea.selectionEnd;
        const text = textarea.value;
        const before = text.substring(0, start);
        const after = text.substring(end, text.length);

        textarea.value = before + emoji + after;
        textarea.selectionStart = textarea.selectionEnd = start + emoji.length;
        textarea.focus();

        // Hide emoji picker
        document.getElementById('emojiPickerCreate').classList.add('hidden');
    }

    // Close emoji picker when clicking outside
    document.addEventListener('click', function(event) {
        const emojiPicker = document.getElementById('emojiPickerCreate');
        const emojiButton = event.target.closest('button[onclick="toggleEmojiPickerCreate()"]');
        const emojiPickerElement = event.target.closest('#emojiPickerCreate');

        if (!emojiButton && !emojiPickerElement && !emojiPicker.classList.contains('hidden')) {
            emojiPicker.classList.add('hidden');
        }
    });
</script>
