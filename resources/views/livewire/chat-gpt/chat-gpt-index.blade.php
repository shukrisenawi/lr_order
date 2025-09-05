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
                <h1 class="text-lg font-semibold text-gray-800">AI Chat</h1>
                <div class="flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                    <span class="text-xs text-gray-600">Online</span>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <div class="flex items-center gap-1 bg-gray-100 rounded-full px-2 py-1">
                <button wire:click="openSystemMessageModal"
                    class="text-gray-600 hover:text-gray-800 p-1 rounded transition-colors" title="Settings">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </button>
                <span
                    class="text-xs text-gray-600 truncate max-w-150">{{ $availableModels[$selectedModel] ?? $selectedModel }}</span>
            </div>
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
                    @else
                        <!-- Assistant Message -->
                        <div
                            class="bg-white text-gray-800 px-3 py-2 rounded-2xl rounded-bl-md shadow-sm border border-gray-200">
                            <div class="text-sm leading-relaxed">
                                {!! app(\Parsedown::class)->setSafeMode(true)->text(is_array($msg['content']) ? $msg['content'][0]['text'] ?? '' : $msg['content']) !!}
                            </div>
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

    <!-- System Message Modal -->
    @if ($showSystemMessageModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
            <div class="bg-white rounded-xl p-6 w-full max-w-2xl mx-4 shadow-xl border border-gray-200">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Settings</h3>
                </div>

                <!-- Model Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Model AI</label>
                    <select wire:model.live="selectedModel"
                        class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                        @foreach ($availableModels as $key => $model)
                            <option value="{{ $key }}" {{ $selectedModel === $key ? 'selected' : '' }}>
                                {{ $model }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- System Message -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">System Message</label>
                    <textarea wire:model="systemMessage" rows="6"
                        class="w-full bg-gray-50 border border-gray-300 rounded-lg px-4 py-3 text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none text-sm"
                        placeholder="Masukkan system message..."></textarea>
                </div>

                <div class="flex justify-end gap-3">
                    <button wire:click="closeSystemMessageModal"
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all duration-200 text-sm font-medium">Batal</button>
                    <button wire:click="updateSystemMessage"
                        class="px-6 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-all duration-200 text-sm font-medium">Simpan</button>
                </div>
            </div>
        </div>
    @endif

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

        /* Typing indicator */
        @if ($isTyping)
            .typing-indicator {
                animation: typing 1.5s infinite;
            }

            @keyframes typing {

                0%,
                60%,
                100% {
                    opacity: 1;
                }

                30% {
                    opacity: 0.5;
                }
            }
        @endif
    </style>
</div>
