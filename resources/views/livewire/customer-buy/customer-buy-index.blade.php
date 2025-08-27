<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" wire:poll.30s="calculateStats">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Pembelian</h1>
                <p class="text-gray-600">Urus pembelian pelanggan</p>
            </div>
            <a href="{{ route('customer-buy.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-medium rounded-xl shadow-lg hover:from-rose-600 hover:to-pink-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-rose-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>
                Tambah Pembelian Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div
            class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Pembelian</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            {{ $totalPurchases }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Hasil</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">RM
                            {{ number_format($totalRevenue, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Purata Pesanan</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">RM
                            {{ number_format($averageOrder, 2) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-8">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari mengikut telefon pelanggan, nama, atau produk..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-rose-500 focus:ring-4 focus:ring-rose-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Prospect</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Product</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-rose-600 transition-colors"
                            wire:click="sortBy('kuantiti')">
                            <div class="flex items-center">
                                Quantity
                                @if ($sortField === 'kuantiti')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-rose-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-rose-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-rose-600 transition-colors"
                            wire:click="sortBy('harga')">
                            <div class="flex items-center">
                                Price
                                @if ($sortField === 'harga')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-rose-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-rose-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Total</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-rose-600 transition-colors"
                            wire:click="sortBy('purchase_date')">
                            <div class="flex items-center">
                                Purchase Date
                                @if ($sortField === 'purchase_date')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-rose-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-rose-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customerBuy as $item)
                        <tr class="hover:bg-rose-50 transition-colors duration-200"
                            wire:key="purchase-{{ $item->id }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $item->customerAlamat->customer->gelaran ?? '' }} -
                                {{ $item->customerAlamat->customer->no_tel ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->produk->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->kuantiti ?? 1 }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">RM
                                {{ number_format($item->harga ?? 0, 2) }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                RM {{ number_format(($item->kuantiti ?? 1) * ($item->harga ?? 0), 2) }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ optional($item->purchase_date)->format('d/m/Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('customer-buy.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-rose-700 bg-rose-50 rounded-lg hover:bg-rose-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                    <a href="{{ route('customer-buy.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-pink-700 bg-pink-50 rounded-lg hover:bg-pink-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button wire:click="delete({{ $item->id }})"
                                        wire:confirm="Are you sure you want to delete this purchase?"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No purchases found</h3>
                                    <p class="text-gray-500 mb-4">Try changing your search or record a new purchase</p>
                                    <a href="{{ route('customer-buy.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-rose-500 to-pink-600 text-white font-medium rounded-lg shadow hover:from-rose-600 hover:to-pink-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Record your first purchase
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($customerBuy->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $customerBuy->firstItem() }}</span> ke <span
                            class="font-medium">{{ $customerBuy->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $customerBuy->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $customerBuy->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
