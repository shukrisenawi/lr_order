<div class="bg-white rounded-lg border border-gray-200 p-6">
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Item Invoice</h3>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
        <!-- Product Selection -->
        <div class="md:col-span-2">
            <label for="produk_id" class="block text-sm font-medium text-gray-700 mb-1">
                Produk <span class="text-red-500">*</span>
            </label>
            <select wire:model.live="produk_id" id="produk_id"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">Pilih produk atau masukkan manual</option>
                @foreach($produk_list as $produk)
                    <option value="{{ $produk->id }}">RM {{ number_format($produk->harga, 2) }} - {{ $produk->nama }}</option>
                @endforeach
            </select>
            @error('produk_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Custom Product Name -->
        <div class="md:col-span-2">
            <label for="produk_custom" class="block text-sm font-medium text-gray-700 mb-1">
                Nama Produk Custom
            </label>
            <input type="text" wire:model.live="produk_custom" id="produk_custom"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="Masukkan nama produk jika tidak ada dalam senarai">
            @error('produk_custom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Quantity -->
        <div>
            <label for="kuantiti" class="block text-sm font-medium text-gray-700 mb-1">
                Kuantiti <span class="text-red-500">*</span>
            </label>
            <input type="number" wire:model.live="kuantiti" id="kuantiti" min="1"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="0">
            @error('kuantiti') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Unit Price -->
        <div>
            <label for="harga_seunit" class="block text-sm font-medium text-gray-700 mb-1">
                Harga Seunit (RM) <span class="text-red-500">*</span>
            </label>
            <input type="number" wire:model.live="harga_seunit" id="harga_seunit" min="0" step="0.01"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                   placeholder="0.00">
            @error('harga_seunit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Total Price (Auto-calculated) -->
        <div>
            <label for="harga" class="block text-sm font-medium text-gray-700 mb-1">
                Jumlah Harga (RM) <span class="text-red-500">*</span>
            </label>
            <input type="number" wire:model.live="harga" id="harga" min="0" step="0.01"
                   class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-gray-50"
                   placeholder="0.00" readonly>
            @error('harga') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- Calculation Display -->
    <div class="mt-4 p-3 bg-blue-50 rounded-md border border-blue-200">
        <div class="flex items-center justify-between text-sm">
            <span class="text-blue-700 font-medium">Pengiraan Automatik:</span>
            <span class="text-blue-700">
                {{ $kuantiti }} × RM {{ number_format($harga_seunit, 2) }} = RM {{ number_format($harga, 2) }}
            </span>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="mt-6 flex justify-end space-x-3">
        <button type="button" wire:click="resetForm"
                class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
            Reset
        </button>
        <button type="button" wire:click="$dispatch('add-invoice-item', {{ json_encode($this->saveItem()) }})"
                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors">
            Tambah Item
        </button>
    </div>

    <!-- JavaScript for Real-time Updates -->
    <script>
        document.addEventListener('livewire:updated', function () {
            // Auto-focus on next field when product is selected
            const produkSelect = document.getElementById('produk_id');
            if (produkSelect) {
                produkSelect.addEventListener('change', function() {
                    if (this.value) {
                        document.getElementById('kuantiti').focus();
                    }
                });
            }

            // Format currency inputs
            const currencyInputs = document.querySelectorAll('input[type="number"][step="0.01"]');
            currencyInputs.forEach(input => {
                input.addEventListener('blur', function() {
                    if (this.value && !isNaN(this.value)) {
                        this.value = parseFloat(this.value).toFixed(2);
                    }
                });
            });
        });
    </script>
</div>
