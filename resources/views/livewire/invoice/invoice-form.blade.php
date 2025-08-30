<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    {{ $isEdit ? 'Edit Invoice' : 'Tambah Invoice Baru' }}
                </h1>
                <p class="text-gray-600 mt-1">
                    {{ $isEdit ? 'Update invoice details' : 'Create a new invoice for your business' }}
                </p>
            </div>
            <a href="{{ route('invoice.index') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Invoice
            </a>
        </div>
    </div>

    <!-- Form -->
    <form wire:submit.prevent="save" class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Basic Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select wire:model="status" id="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="pending">Pending</option>
                        <option value="paid">Paid</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-6">Customer Information</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Recipient Name -->
                <div>
                    <label for="nama_penerima" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Penerima <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="nama_penerima" id="nama_penerima"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter recipient name">
                    @error('nama_penerima')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700 mb-2">
                        No Telefon <span class="text-red-500">*</span>
                    </label>
                    <input type="text" wire:model="no_tel" id="no_tel"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter phone number">
                    @error('no_tel')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat <span class="text-red-500">*</span>
                    </label>
                    <textarea wire:model="alamat" id="alamat" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter full address"></textarea>
                    @error('alamat')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Courier -->
                <div>
                    <label for="kurier" class="block text-sm font-medium text-gray-700 mb-2">
                        Kurier
                    </label>
                    <input type="text" wire:model="kurier" id="kurier"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter courier service">
                    @error('kurier')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Notes -->
                <div>
                    <label for="catatan" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan
                    </label>
                    <textarea wire:model="catatan" id="catatan" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Enter notes"></textarea>
                    @error('catatan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Invoice Items</h2>
                <button type="button" wire:click="addItem"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>
                    Add Item
                </button>
            </div>

            <div class="space-y-4">
                @foreach ($items as $index => $item)
                    <div class="border border-gray-200 rounded-lg p-4" wire:key="item-{{ $index }}">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Item {{ $index + 1 }}</h3>
                            @if (count($items) > 1)
                                <button type="button" wire:click="removeItem({{ $index }})"
                                    class="text-red-600 hover:text-red-800">
                                    <i class="fas fa-trash"></i>
                                </button>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Product Selection -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                                <select wire:model="items.{{ $index }}.produk_id"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Product</option>
                                    @foreach ($produk_list as $produk)
                                        <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                    @endforeach
                                </select>
                                @error('items.' . $index . '.produk_id')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Custom Product Name -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Custom Product</label>
                                <input type="text" wire:model="items.{{ $index }}.produk_custom"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Or enter custom product">
                                @error('items.' . $index . '.produk_custom')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Quantity -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity <span
                                        class="text-red-500">*</span></label>
                                <input type="number" wire:model="items.{{ $index }}.kuantiti" min="1"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('items.' . $index . '.kuantiti')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price (RM) <span
                                        class="text-red-500">*</span></label>
                                <input type="number" wire:model="items.{{ $index }}.harga" step="0.01"
                                    min="0"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @error('items.' . $index . '.harga')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Item Total -->
                        <div class="mt-4 text-right">
                            <span class="text-sm text-gray-600">Item Total: </span>
                            <span class="font-semibold text-gray-900">
                                RM {{ number_format(($item['kuantiti'] ?? 0) * ($item['harga'] ?? 0), 2) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <div class="flex justify-end">
                    <div class="text-right">
                        <div class="text-lg font-semibold text-gray-900">
                            Total: RM {{ number_format($this->getTotal(), 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('invoice.index') }}"
                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                Cancel
            </a>
            <button type="submit"
                class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-save mr-2"></i>
                {{ $isEdit ? 'Update Invoice' : 'Create Invoice' }}
            </button>
        </div>
    </form>
</div>
