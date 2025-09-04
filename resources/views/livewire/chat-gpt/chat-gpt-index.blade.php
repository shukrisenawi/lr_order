@if ($embedded)
    <div class="p-4">
    @else
        <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
@endif
@unless ($embedded)
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-robot text-green-600 mr-3"></i>
                    ChatGPT
                </h1>
                <p class="text-gray-600">Bercakap dengan AI untuk mendapatkan bantuan dan maklumat</p>
            </div>
            <div class="flex items-center space-x-4">
                <!-- Model Selection -->
                <div class="flex items-center space-x-2">
                    <label class="text-sm font-medium text-gray-700">Model:</label>
                    <select wire:model="selectedModel"
                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @foreach ($availableModels as $modelKey => $modelName)
                            <option value="{{ $modelKey }}" {{ $selectedModel === $modelKey ? 'selected' : '' }}>
                                {{ $modelName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button wire:click="clearChat"
                    class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fas fa-trash mr-2"></i>
                    Kosongkan Chat
                </button>
            </div>
        </div>
    </div>
@endunless

@unless ($embedded)
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-6 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif
@endunless

<!-- Chat Container -->
<div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-6">
    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
        <h3 class="text-xl font-semibold text-gray-900">
            <i class="fas fa-comments text-blue-600 mr-2"></i>
            Perbualan dengan AI
        </h3>
        <p class="text-gray-600 text-sm mt-1">Tanya apa sahaja kepada AI</p>
    </div>

    <!-- Messages Area -->
    <div id="chat-messages" class="{{ $embedded ? 'h-64' : 'h-96' }} overflow-y-auto p-6 space-y-4">
        @foreach ($messages as $message)
            <div class="w-full flex {{ $message['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                <div
                    class="max-w-full lg:max-w-md px-4 py-2 rounded-lg {{ $message['role'] === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }}">
                    <p class="text-sm whitespace-pre-wrap">{{ $message['content'] }}</p>
                    <p class="text-xs mt-1 opacity-70">{{ $message['timestamp'] }}</p>
                </div>
            </div>
        @endforeach

        @if ($isTyping)
            <div class="flex justify-start">
                <div class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg">
                    <div class="flex items-center space-x-2">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.1s">
                            </div>
                            <div class="w-2 h-2 bg-gray-500 rounded-full animate-bounce" style="animation-delay: 0.2s">
                            </div>
                        </div>
                        <span class="text-sm">AI sedang menaip...</span>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if ($errorMessage)
        <div class="px-6 pb-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                    <div>
                        <p class="font-medium">Ralat</p>
                        <p class="text-sm">{{ $errorMessage }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Input Area -->
    <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 fixed">
        <form class="flex space-x-4">
            <div class="flex-1">
                <textarea wire:model="newMessage" rows="2" placeholder="Tulis mesej anda di sini..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 resize-none @error('newMessage') border-red-500 bg-red-50 @enderror"></textarea>
                <p class="mt-1 text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    Tekan <kbd class="px-1 py-0.5 bg-gray-200 rounded text-xs">Enter</kbd> untuk hantar mesej,
                    <kbd class="px-1 py-0.5 bg-gray-200 rounded text-xs">Shift+Enter</kbd> untuk baris baru
                </p>
                @error('newMessage')
                    <p class="mt-2 text-sm text-red-600 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i>
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="flex flex-col justify-end">
                <button wire:click.prevent="sendMessage" id="send-btn" type="button"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Hantar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript for UI enhancements -->
<script>
    // Function to scroll to bottom
    function scrollToBottom() {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) {
            chatMessages.scrollTo({
                top: chatMessages.scrollHeight,
                behavior: 'smooth'
            });
        }
    }

    // Listen for Livewire updates to handle scrolling (when AI responds)
    document.addEventListener('livewire:updated', function() {
        setTimeout(scrollToBottom, 200);
    });

    // Handle Enter and Shift+Enter for textarea
    document.addEventListener('keydown', function(e) {
        const textarea = e.target;
        if (textarea && textarea.tagName === 'TEXTAREA' && textarea === document.querySelector(
                'textarea[wire\\:model="newMessage"]')) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                if (textarea.value.trim() === '') {
                    return;
                }
                textarea.disabled = true;
                @this.set('newMessage', textarea.value.trim());
                @this.sendMessage().then(() => {
                    textarea.disabled = false;
                    textarea.value = '';
                });
            } else if (e.key === 'Enter' && e.shiftKey) {
                e.preventDefault();
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                textarea.value = textarea.value.substring(0, start) + '\n' + textarea.value.substring(end);
                textarea.selectionStart = textarea.selectionEnd = start + 1;
                textarea.dispatchEvent(new Event('input', {
                    bubbles: true
                }));
            }
        }
    });

    // Remove MutationObserver and related code to prevent duplicate rendering
    // Livewire already handles DOM updates, so extra observation is not needed
</script>
</div>
