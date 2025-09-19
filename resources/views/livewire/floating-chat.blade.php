@php
    $isChatGPTPage = request()->routeIs('chatgpt.index');
@endphp

<div>
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div
            class="fixed top-6 right-6 z-50 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative max-w-sm">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="fixed bottom-6 right-6 z-50 {{ $isChatGPTPage ? 'hidden' : '' }}">
    <!-- Chat Bubble Button -->
    <div x-data="{ isOpen: @entangle('isOpen') }" x-on:click.away="isOpen = false" class="relative">

        <!-- Chat Window -->
        <div x-show="isOpen" x-transition:enter="transition ease-out duration-300"
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
                        <p class="text-xs text-white/80">Online</p>
                    </div>
                </div>
                <div class="flex items-center space-x-1">
                    <button wire:click="clearChat" wire:confirm="Adakah anda pasti mahu menghapuskan semua mesej?"
                        class="text-white/80 hover:text-white transition-colors p-1 rounded" title="Clear Messages">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                    <button wire:click="closeChat" class="text-white/80 hover:text-white transition-colors p-1 rounded"
                        title="Close Chat">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
            </div>
            <!-- Chat Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-3 h-80 flex flex-col-reverse" id="chat-messages">
                @foreach (array_reverse($messages) as $msg)
                    <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-xs">
                            <div
                                class="px-3 py-2 rounded-lg text-sm
                                         {{ $msg['role'] === 'user' ? 'bg-blue-500 text-white rounded-br-sm' : 'bg-gray-100 text-gray-800 rounded-bl-sm' }}">
                                @if ($msg['role'] === 'assistant')
                                    {!! app(\Parsedown::class)->text($msg['content']) !!}
                                @else
                                    {{ $msg['content'] }}
                                @endif
                            </div>
                            <div class="text-xs text-gray-500 mt-1 px-1 {{ $msg['role'] === 'user' ? 'text-right' : 'text-left' }}">
                                {{ $msg['timestamp'] }}
                            </div>
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
                <form wire:submit.prevent="sendMessage" class="flex gap-2 items-end">
                    <div class="flex-1 relative">
                        <textarea wire:model="newMessage" placeholder="Tulis mesej anda..."
                            class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none text-sm leading-relaxed"
                            rows="3"
                            style="height: 3rem; overflow-y: auto;"
                            onkeydown="if(event.key === 'Enter' && !event.shiftKey){ event.preventDefault(); this.closest('form').dispatchEvent(new Event('submit', {cancelable: true})); }"></textarea>
                    </div>
                    <button type="submit"
                        class="bg-blue-500 text-white p-2 rounded-full hover:bg-blue-600 transition-all duration-200 shadow-sm hover:shadow-md disabled:opacity-50"
                        wire:loading.attr="disabled" wire:target="sendMessage">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <!-- Floating Button -->
        <button wire:click="toggleChat" x-on:click.stop=""
            class="w-14 h-14 bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-110 flex items-center justify-center relative group">

            <!-- Icon -->
            <i class="fas fa-comments text-lg transition-transform duration-300" :class="{ 'rotate-180': isOpen }"></i>
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
                observer.observe(chatMessages, {
                    childList: true,
                    subtree: true
                });
            }
        }, 500);
    });
    </script>
</div>
