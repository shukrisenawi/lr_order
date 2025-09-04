<div>
    <!-- Floating Chat Bubble -->
    <div class="fixed bottom-6 right-6 z-50">
        <!-- Chat Bubble Button -->
        <button
            wire:click="openChatModal"
            onclick="console.log('Chat button clicked')"
            class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-3xl transition-all duration-300 transform hover:scale-110 group"
            title="Buka Chat AI"
        >
            <i class="fas fa-robot text-2xl group-hover:animate-bounce"></i>
        </button>

        <!-- Pulse Animation Ring -->
        <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full animate-ping opacity-20"></div>
    </div>

    <!-- Chat Modal -->
    @if($showChatModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" style="background: rgba(0,0,0,0.8);">
            <script>console.log('Modal is showing');</script>
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeChatModal"></div>

                <!-- Modal panel -->
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white rounded-full w-10 h-10 flex items-center justify-center">
                                    <i class="fas fa-robot"></i>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">ChatGPT Assistant</h3>
                                    <p class="text-sm text-gray-600">AI dengan akses database</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <!-- Model Selector -->
                                <div class="flex items-center space-x-2">
                                    <label class="text-sm font-medium text-gray-700">Model:</label>
                                    <select
                                        wire:model.live="selectedModel"
                                        wire:change="requestModelChange($event.target.value)"
                                        class="px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                    >
                                        @foreach($availableModels as $modelKey => $modelName)
                                            <option value="{{ $modelKey }}" {{ $selectedModel === $modelKey ? 'selected' : '' }}>
                                                {{ $modelName }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Close Button -->
                                <button
                                    wire:click="closeChatModal"
                                    class="text-gray-400 hover:text-gray-600 transition-colors"
                                >
                                    <i class="fas fa-times text-xl"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Chat Content -->
                    <div class="max-h-96 overflow-y-auto p-4">
                        @livewire(\App\Livewire\ChatGPT\ChatGPTIndex::class, ['embedded' => true, 'selectedModel' => $selectedModel], key('floating-chat'))
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Password Verification Modal -->
    @if($showPasswordModal)
        <div class="fixed inset-0 z-[60] overflow-y-auto" aria-labelledby="password-modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-lock text-blue-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="password-modal-title">
                                    Sahkan Kata Laluan
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Masukkan kata laluan anda untuk menukar model AI.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <form wire:submit.prevent="verifyPassword" class="w-full">
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kata Laluan
                                </label>
                                <input
                                    type="password"
                                    id="password"
                                    wire:model="password"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-500 @enderror"
                                    placeholder="Masukkan kata laluan anda"
                                >
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                @if($passwordError)
                                    <p class="mt-1 text-sm text-red-600">{{ $passwordError }}</p>
                                @endif
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button
                                    type="button"
                                    wire:click="closePasswordModal"
                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors"
                                >
                                    Batal
                                </button>
                                <button
                                    type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors"
                                >
                                    Sahkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="fixed top-4 right-4 z-[70] bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Debug Messages -->
    @if (session()->has('debug'))
        <div class="fixed top-20 right-4 z-[70] bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg shadow-lg">
            <div class="flex items-center">
                <i class="fas fa-info-circle mr-2"></i>
                <span>{{ session('debug') }}</span>
            </div>
        </div>
    @endif

    <!-- JavaScript for debugging -->
    <script>
        // Debug: Listen for our custom event
        document.addEventListener('chat-modal-opened', function() {
            console.log('Chat modal opened event received');
        });

        // Debug: Check if button exists
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                const chatButton = document.querySelector('[wire\\:click="openChatModal"]');
                if (chatButton) {
                    console.log('Chat button found:', chatButton);
                    chatButton.style.border = '2px solid red'; // Make it visible for debugging
                } else {
                    console.log('Chat button NOT found');
                }
            }, 1000);
        });

        // Listen for Livewire updates
        document.addEventListener('livewire:updated', function () {
            console.log('Livewire updated');
        });
    </script>
</div>