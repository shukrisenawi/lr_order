<div class="max-w-6xl mx-auto" wire:poll.30s="calculateStats">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-light text-gray-800 mb-2">Pengurusan Pembelian</h1>
                <p class="text-gray-500">Urus pembelian prospek</p>
            </div>
            <a href="{{ route('prospek-buy.create') }}" class="px-4 py-2 bg-gray-800 text-white hover:bg-gray-900">
                Tambah Pembelian Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Jumlah Pembelian</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">{{ $totalPurchases }}
            </div>
        </div>
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Jumlah Hasil</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">RM
                {{ number_format($totalRevenue, 2) }}</div>
        </div>
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Purata Pesanan</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">RM
                {{ number_format($averageOrder, 2) }}</div>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Cari mengikut telefon pelanggan, nama, atau produk..."
            class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none">
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">ID</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Prospect</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Product</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer"
                        wire:click="sortBy('kuantiti')">
                        Quantity
                        @if ($sortField === 'kuantiti')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer" wire:click="sortBy('harga')">
                        Price
                        @if ($sortField === 'harga')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Total</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer"
                        wire:click="sortBy('created_at')">
                        Date
                        @if ($sortField === 'created_at')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospekBuy as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50" wire:key="purchase-{{ $item->id }}">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->id }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800">
                            {{ $item->prospekAlamat->prospek->gelaran ?? '' }} -
                            {{ $item->prospekAlamat->prospek->no_tel ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->produk->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->kuantiti ?? 1 }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">RM {{ number_format($item->harga ?? 0, 2) }}</td>
                        <td class="px-6 py-4 text-sm text-gray-800 font-medium">
                            RM {{ number_format(($item->kuantiti ?? 1) * ($item->harga ?? 0), 2) }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            {{ $item->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('prospek-buy.show', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">View</a>
                                <a href="{{ route('prospek-buy.edit', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">Edit</a>
                                <button wire:click="delete({{ $item->id }})"
                                    wire:confirm="Are you sure you want to delete this purchase?"
                                    class="text-red-600 hover:text-red-800">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                            <div>No purchases found</div>
                            <a href="{{ route('prospek-buy.create') }}"
                                class="text-gray-800 hover:underline mt-2 inline-block">
                                Record your first purchase
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($prospekBuy->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $prospekBuy->links() }}
            </div>
        @endif
    </div>
</div>
