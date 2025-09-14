<div class="flex flex-col h-[800px] bg-gray-50">
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 text-green-800 px-3 py-2 rounded-lg mx-4 mt-4 text-sm border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white border-b border-gray-200 px-4 py-3 flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-robot text-white text-sm"></i>
            </div>
            <div>
                <h1 class="text-lg font-semibold text-gray-800">Chat</h1>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-xs text-gray-600">Online</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button wire:click="clearChat" wire:confirm="Adakah anda pasti mahu menghapuskan semua mesej?"
                class="text-gray-600 hover:text-gray-800 p-1 rounded transition-colors" title="Clear Messages">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Chat Body -->
    <div class="flex-1 overflow-y-auto p-3 space-y-2 flex flex-col-reverse" id="chat-messages">
        @foreach (array_reverse($messages) as $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }} mb-2 message-enter">
                <div class="max-w-xs lg:max-w-md xl:max-w-4xl">
                    @if ($msg['role'] === 'user')
                        <!-- User Message -->
                        <div class="bg-blue-500 text-white px-3 py-2 rounded-2xl rounded-br-md shadow-sm">
                            <div class="text-sm leading-relaxed">
                                {{ is_array($msg['content']) ? $msg['content'][0]['text'] ?? '' : $msg['content'] }}
                            </div>
                        </div>
                        <div class="text-xs text-blue-300 mt-1 px-1 text-right">
                            {{ $msg['timestamp'] }}
                        </div>
                    @else
                        <!-- Assistant Message -->
                        <div
                            class="bg-white text-gray-800 px-3 py-2 rounded-2xl rounded-bl-md shadow-sm border border-gray-200">
                            <div class="text-sm leading-relaxed">
                                {!! app(\Parsedown::class)->text(is_array($msg['content']) ? $msg['content'][0]['text'] ?? '' : $msg['content']) !!}
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-1 px-1 text-left">
                            {{ $msg['timestamp'] }}
                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <!-- Typing Indicator -->
        <div class="flex justify-start mb-2" wire:poll.500ms="checkTypingStatus" x-show="$wire.isTyping" x-transition>
            <div class="bg-white text-gray-800 px-3 py-2 rounded-2xl rounded-bl-md shadow-sm border border-gray-200">
                <div class="flex space-x-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Input Area -->
    <div class="bg-white border-t border-gray-200 p-3">
        <form wire:submit.prevent="sendMessage" class="flex gap-2 items-end">
            <div class="flex-1 relative">
                <textarea wire:model="newMessage" placeholder="Tulis mesej anda..."
                    class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none text-sm leading-relaxed"
                    rows="1"
                    onkeydown="if(event.key === 'Enter' && !event.shiftKey){ event.preventDefault(); this.closest('form').dispatchEvent(new Event('submit', {cancelable: true})); }"
                    oninput="this.style.height = 'auto'; this.style.height = this.scrollHeight + 'px';"></textarea>
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


    <!-- JavaScript for handling redirects -->
    <script>
        document.addEventListener('livewire:loaded', () => {
            Livewire.on('redirect-to-invoice', (data) => {
                window.location.href = data.url;
            });

            // Auto-scroll to bottom when new message is added
            Livewire.on('scroll-to-bottom', () => {
                const chatBody = document.getElementById('chat-messages');
                if (chatBody) {
                    setTimeout(() => {
                        chatBody.scrollTop = chatBody.scrollHeight;
                    }, 100);
                }
            });

            // Scroll to bottom on page load
            setTimeout(() => {
                const chatBody = document.getElementById('chat-messages');
                if (chatBody) {
                    chatBody.scrollTop = chatBody.scrollHeight;
                }
            }, 500);
        });

        // Add smooth scrolling for better UX
        document.addEventListener('DOMContentLoaded', () => {
            const chatBody = document.getElementById('chat-messages');
            if (chatBody) {
                chatBody.style.scrollBehavior = 'smooth';
            }
        });
    </script>

    <style>
        /* Custom scrollbar */
        #chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        #chat-messages::-webkit-scrollbar-track {
            background: #f9fafb;
            border-radius: 10px;
        }

        #chat-messages::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        #chat-messages::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* Message animations */
        .message-enter {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

    </style>
</div>
