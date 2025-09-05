@php
    $isChatGPTPage = request()->routeIs('chatgpt.index');
@endphp

<!-- Flash Message -->
@if (session()->has('message'))
    <div class="fixed top-6 right-6 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-sm">
        <span class="block sm:inline">{{ session('message') }}</span>
    </div>
@endif

<div class="fixed bottom-6 right-6 z-50 {{ $isChatGPTPage ? 'hidden' : '' }}">
    <!-- Chat Bubble Button -->
    <div x-data="{ isOpen: @entangle('isOpen') }" x-on:click.away="isOpen = false" class="relative">

        <!-- Chat Window -->
        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
             class="absolute bottom-16 right-0 w-96 h-[28rem] bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden"
             style="display: none;">
            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-3 flex items-center justify-between">
                <div class="flex items-center space-x-2">
                    <div class="w-6 h-6 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-xs"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-xs">AI Assistant</h3>
                        <p class="text-xs text-white/80">Online - {{ $selectedModel }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <button wire:click="openSystemMessageModal" class="text-white/80 hover:text-white transition-colors p-1 rounded">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </button>
                    <button wire:click="closeChat"
                            class="text-white/80 hover:text-white transition-colors p-1 rounded">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3 h-80 flex flex-col-reverse" id="chat-messages">
                @foreach (array_reverse($messages) as $msg)
                    <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div
                            class="max-w-xs px-3 py-2 rounded-lg text-sm
                                    {{ $msg['role'] === 'user' ? 'bg-blue-500 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">
                            {{ $msg['content'] }}
                        </div>
                    </div>
                @endforeach

                @if ($isTyping)
                    <div class="flex justify-start">
                        <div class="bg-gray-100 text-gray-800 px-3 py-2 rounded-lg rounded-bl-sm">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"
                                    style="animation-delay: 0.2s"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Chat Input -->
            <div class="border-t border-gray-200 p-3">
                <form wire:submit.prevent="sendMessage" class="flex space-x-2">
                    <input wire:model="newMessage" type="text" placeholder="Tulis mesej..."
                        class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                        wire:keydown.enter.prevent="sendMessage">
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors disabled:opacity-50">
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Floating Button -->
        <button wire:click="toggleChat" x-on:click.stop=""
            class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center relative group">

            <!-- Notification Badge -->
            <div
                class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-xs">!</span>
            </div>

            <!-- Icon -->
            <i class="fas fa-comments text-lg transition-transform duration-300" :class="{ 'rotate-180': isOpen }"></i>

            <!-- Pulse Animation -->
            <div
                class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 animate-ping opacity-20">
            </div>
        </button>
    </div>

    <!-- System Message Modal -->
    @if($showSystemMessageModal)
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-2xl mx-4">
            <h3 class="text-lg font-semibold mb-4">Settings</h3>

            <!-- Model Selection -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Model AI</label>
                <select wire:model.live="selectedModel" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                    @foreach($availableModels as $key => $model)
                        <option value="{{ $key }}" {{ $selectedModel === $key ? 'selected' : '' }}>
                            {{ $model }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- System Message -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">System Message</label>
                <textarea wire:model="systemMessage" rows="8" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-blue-500 focus:ring-blue-500" placeholder="Masukkan system message..."></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-4">
                <button wire:click="closeSystemMessageModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400">Batal</button>
                <button wire:click="updateSystemMessage" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
            </div>
        </div>
    </div>
    @endif
</div>

<script>
document.addEventListener('alpine:initialized', () => {
    // Listen for typing events
    Livewire.on('typing', (duration) => {
        // Typing animation is handled by Livewire
    });
});

// Listen for redirect events and scroll events
document.addEventListener('livewire:loaded', () => {
    Livewire.on('redirect-to-invoice', (data) => {
        window.location.href = data.url;
    });

    // Auto-scroll to bottom when new message is added
    Livewire.on('scroll-to-bottom', () => {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) {
            setTimeout(() => {
                chatMessages.scrollTop = 0; // Scroll to top because of flex-col-reverse
            }, 100);
        }
    });

    // Scroll to bottom when chat is opened
    const observer = new MutationObserver(() => {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages && chatMessages.offsetParent !== null) { // Check if visible
            setTimeout(() => {
                chatMessages.scrollTop = 0; // Scroll to top because of flex-col-reverse
            }, 200);
        }
    });

    // Observe changes to the chat messages container
    setTimeout(() => {
        const chatMessages = document.getElementById('chat-messages');
        if (chatMessages) {
            observer.observe(chatMessages, { childList: true, subtree: true });
        }
    }, 500);
});
</script>
