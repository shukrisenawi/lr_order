<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $isEdit ? 'Kemaskini Invoice' : 'Tambah Invoice Baru' }}
                </h1>
                <p class="text-gray-600">
                    {{ $isEdit ? 'Kemaskini maklumat invoice' : 'Cipta invoice baru untuk perniagaan anda' }}
                </p>
                @if($isEdit && isset($invoice))
                    <div class="flex items-center gap-4 mt-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-hashtag mr-1"></i>
                            ID: {{ $invoice->id }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                            <i class="fas fa-file-invoice mr-1"></i>
                            {{ $invoice->invoice_no }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="flex gap-4">
                <a href="{{ route('invoice.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Senarai
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-8 p-4 bg-gradient-to-r from-red-50 to-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form -->
    <form wire:submit.prevent="save" class="space-y-8">
        <!-- Basic Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-3"></i>
                    Maklumat Asas
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-2">
                        <label for="bisnes_id" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-building mr-2 text-blue-500"></i>
                            Perniagaan <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="bisnes_id" id="bisnes_id"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                            <option value="">Pilih Perniagaan</option>
                            @foreach ($bisnes_list as $bisnes)
                                <option value="{{ $bisnes->id }}" {{ $bisnes->id == $bisnes_id ? 'selected' : '' }}>{{ $bisnes->nama_bisnes }}</option>
                            @endforeach
                        </select>
                        @error('bisnes_id')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="status" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-circle mr-2 text-green-500"></i>
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="status" id="status"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                            <option value="pending">Pending</option>
                            <option value="paid">Paid</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        @error('status')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-3"></i>
                    Maklumat Customer
                </h2>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Recipient Name -->
                    <div class="space-y-2">
                        <label for="nama_penerima" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user mr-2 text-blue-500"></i>
                            Nama Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="nama_penerima" id="nama_penerima"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                            placeholder="Contoh: Encik Ahmad">
                        @error('nama_penerima')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Phone Number -->
                    <div class="space-y-2">
                        <label for="no_tel" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-phone mr-2 text-green-500"></i>
                            No Telefon <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="no_tel" id="no_tel"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                            placeholder="Contoh: 0123456789">
                        @error('no_tel')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="alamat" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model="alamat" id="alamat" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm resize-none"
                            placeholder="Masukkan alamat lengkap"></textarea>
                        @error('alamat')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Courier -->
                    <div class="space-y-2">
                        <label for="kurier" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-truck mr-2 text-yellow-500"></i>
                            Kurier
                        </label>
                        <input type="text" wire:model="kurier" id="kurier"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                            placeholder="Contoh: J&T, PosLaju, DHL">
                        @error('kurier')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- Notes -->
                    <div class="space-y-2">
                        <label for="catatan" class="block text-sm font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-sticky-note mr-2 text-orange-500"></i>
                            Catatan
                        </label>
                        <textarea wire:model="catatan" id="catatan" rows="3"
                            class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm resize-none"
                            placeholder="Catatan tambahan (pilihan)"></textarea>
                        @error('catatan')
                            <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-shopping-cart mr-3"></i>
                        Item Invoice
                    </h2>
                    <button type="button" wire:click="addItem"
                        class="inline-flex items-center px-4 py-2 bg-white/20 hover:bg-white/30 text-white rounded-lg transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Item
                    </button>
                </div>
            </div>

            <div class="p-6">
                <div class="space-y-6">
                    @foreach ($items as $index => $item)
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl p-6 border border-gray-200" wire:key="item-{{ $index }}">
                            <div class="flex items-center justify-between mb-6">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <i class="fas fa-box mr-2 text-orange-500"></i>
                                    Item {{ $index + 1 }}
                                </h3>
                                @if (count($items) > 1)
                                    <button type="button" wire:click="removeItem({{ $index }})"
                                        class="inline-flex items-center px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <i class="fas fa-trash mr-1"></i>
                                        Buang
                                    </button>
                                @endif
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <!-- Product Selection -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-box-open mr-2 text-blue-500"></i>
                                        Produk
                                    </label>
                                    <select wire:model="items.{{ $index }}.produk_id"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                                        <option value="">Pilih Produk</option>
                                        @foreach ($produk_list as $produk)
                                            <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('items.' . $index . '.produk_id')
                                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Custom Product Name -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-edit mr-2 text-purple-500"></i>
                                        Produk Custom
                                    </label>
                                    <input type="text" wire:model="items.{{ $index }}.produk_custom"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                                        placeholder="Atau masukkan produk custom">
                                    @error('items.' . $index . '.produk_custom')
                                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Quantity -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-hashtag mr-2 text-green-500"></i>
                                        Kuantiti <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" wire:model="items.{{ $index }}.kuantiti" min="1"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                                    @error('items.' . $index . '.kuantiti')
                                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Price -->
                                <div class="space-y-2">
                                    <label class="block text-sm font-semibold text-gray-800 flex items-center">
                                        <i class="fas fa-dollar-sign mr-2 text-yellow-500"></i>
                                        Harga (RM) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" wire:model="items.{{ $index }}.harga" step="0.01" min="0"
                                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                                    @error('items.' . $index . '.harga')
                                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                                            <i class="fas fa-exclamation-circle mr-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Item Total -->
                            <div class="mt-6 pt-4 border-t border-gray-200">
                                <div class="flex justify-end">
                                    <div class="bg-white rounded-lg px-4 py-2 border border-gray-200">
                                        <span class="text-sm text-gray-600">Jumlah Item: </span>
                                        <span class="font-bold text-lg text-green-600">
                                            RM {{ number_format(($item['kuantiti'] ?? 0) * ($item['harga'] ?? 0), 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Total Summary -->
                <div class="mt-8 bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-calculator text-green-600 text-2xl mr-3"></i>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Jumlah Keseluruhan</h3>
                                <p class="text-sm text-gray-600">Semua item dalam invoice</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-green-600">
                                RM {{ number_format($this->getTotal(), 2) }}
                            </div>
                            <div class="text-sm text-gray-600">Termasuk semua caj</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-paper-plane mr-3"></i>
                    Tindakan
                </h2>
            </div>
            <div class="p-6">
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('invoice.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        {{ $isEdit ? 'Kemaskini Invoice' : 'Cipta Invoice' }}
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
