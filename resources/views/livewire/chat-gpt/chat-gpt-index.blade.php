<div class="flex flex-col h-[800px] bg-gray-100">
    <!-- Header -->
    <div class="bg-white shadow p-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Live Chat</h1>
        <span class="text-sm text-gray-500">Online</span>
    </div>

    <!-- Chat Body -->
    <div class="flex-1 overflow-y-auto p-4 space-y-4">
        @foreach ($messages as $msg)
            <div class="flex {{ $msg['role'] === 'user' ? 'justify-end' : 'justify-start' }}">
                <div
                    class="{{ $msg['role'] === 'user' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800' }} px-4 py-2 rounded-lg max-w-4xl">
                    {{ is_array($msg['content']) ? $msg['content'][0]['text'] ?? '' : $msg['content'] }}
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
</div>
