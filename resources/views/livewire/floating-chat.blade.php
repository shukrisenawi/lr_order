<div class="fixed bottom-6 right-6 z-50">
    <!-- Chat Bubble Button -->
    <div x-data="{ isOpen: @entangle('isOpen') }"
         class="relative">

        <!-- Chat Window -->
        <div x-show="isOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
             class="absolute bottom-16 right-0 w-80 h-96 bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden"
             style="display: none;">

            <!-- Chat Header -->
            <div class="bg-gradient-to-r from-blue-500 to-purple-600 text-white p-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-robot text-sm"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-sm">AI Assistant</h3>
                        <p class="text-xs text-white/80">Online</p>
                    </div>
                </div>
                <button wire:click="closeChat"
                        class="text-white/80 hover:text-white transition-colors">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>

            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3 h-64">
                @foreach ($messages as $msg)
                    <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs px-3 py-2 rounded-lg text-sm
                                    {{ $msg['role'] === 'user'
                                        ? 'bg-blue-500 text-white rounded-br-sm'
                                        : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">
                            {{ $msg['content'] }}
                        </div>
                    </div>
                @endforeach

                @if ($isTyping)
                    <div class="flex justify-start">
                        <div class="bg-gray-100 text-gray-800 px-3 py-2 rounded-lg rounded-bl-sm">
                            <div class="flex space-x-1">
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Chat Input -->
            <div class="border-t border-gray-200 p-3">
                <form wire:submit.prevent="sendMessage" class="flex space-x-2">
                    <input wire:model="newMessage"
                           type="text"
                           placeholder="Tulis mesej..."
                           class="flex-1 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                           wire:keydown.enter.prevent="sendMessage">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors disabled:opacity-50">
                        <i class="fas fa-paper-plane text-sm"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Floating Button -->
        <button wire:click="toggleChat"
                class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center relative group">

            <!-- Notification Badge -->
            <div class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                <span class="text-xs">!</span>
            </div>

            <!-- Icon -->
            <i class="fas fa-comments text-lg transition-transform duration-300"
               :class="{ 'rotate-180': isOpen }"></i>

            <!-- Pulse Animation -->
            <div class="absolute inset-0 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 animate-ping opacity-20"></div>
        </button>
    </div>
</div>

<script>
document.addEventListener('alpine:initialized', () => {
    // Listen for typing events
    Livewire.on('typing', (duration) => {
        // Typing animation is handled by Livewire
    });
});

// Listen for redirect events
document.addEventListener('livewire:loaded', () => {
    Livewire.on('redirect-to-invoice', (data) => {
        window.location.href = data.url;
    });
});
</script>