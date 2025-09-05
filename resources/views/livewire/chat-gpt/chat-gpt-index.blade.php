<div class="flex flex-col h-[800px] bg-gray-100">
    <!-- Flash Message -->
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <!-- Header -->
    <div class="bg-white shadow p-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Live Chat</h1>
        <div class="flex items-center gap-4">
            <button wire:click="openSystemMessageModal" class="text-gray-600 hover:text-gray-800 p-1 rounded" title="Settings">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </button>
            <button wire:click="clearChat" wire:confirm="Adakah anda pasti mahu menghapuskan semua mesej?" class="text-gray-600 hover:text-gray-800 p-1 rounded" title="Clear Messages">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
            <span class="text-sm text-gray-500">Online</span>
        </div>
    </div>

    <!-- Chat Body -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach ($messages as $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                <div
                    class="{{ $msg['role'] === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} px-4 py-2 rounded-lg max-w-4xl">
                    <div class="flex flex-col">
                        <!-- Message Content -->
                        <div class="mb-1">
                            {{ is_array($msg['content']) ? $msg['content'][0]['text'] ?? '' : $msg['content'] }}
                        </div>
                        <!-- Model Info -->
                        @if(isset($msg['model']) && $msg['model'])
                            <div class="text-xs {{ $msg['role'] === 'user' ? 'text-blue-200' : 'text-gray-500' }} self-end">
                                {{ $msg['model'] }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Input Area -->
    <div class="bg-white p-4 border-t">
        <form wire:submit.prevent="sendMessage" class="flex gap-2 items-end">
            <textarea wire:model="newMessage" placeholder="Tulis mesej anda..."
                class="flex-1 rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 resize-none p-2" rows="2"
                onkeydown="if(event.key === 'Enter' && !event.shiftKey){ event.preventDefault(); this.closest('form').dispatchEvent(new Event('submit', {cancelable: true})); }"></textarea>

            <button type="submit"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 disabled:opacity-50"
                wire:loading.attr="disabled">
                Hantar
            </button>
        </form>
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

    <!-- JavaScript for handling redirects -->
    <script>
        document.addEventListener('livewire:loaded', () => {
            Livewire.on('redirect-to-invoice', (data) => {
                window.location.href = data.url;
            });
        });
    </script>
</div>
