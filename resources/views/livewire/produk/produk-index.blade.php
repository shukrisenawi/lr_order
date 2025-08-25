<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Produk</h1>
                <p class="text-gray-600">Urus produk anda</p>
            </div>
            <a href="{{ route('produk.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>
                Tambah Produk Baru
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

    <!-- Search -->
    <div class="mb-8">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Gambar</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-emerald-600 transition-colors"
                            wire:click="sortBy('name')">
                            <div class="flex items-center">
                                Nama
                                @if ($sortField === 'name')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-emerald-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-emerald-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-emerald-600 transition-colors"
                            wire:click="sortBy('price')">
                            <div class="flex items-center">
                                Harga
                                @if ($sortField === 'price')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-emerald-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-emerald-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($produk as $item)
                        <tr class="hover:bg-emerald-50 transition-colors duration-200"
                            wire:key="produk-{{ $item->id }}">
                            <td class="px-6 py-4">
                                @if ($item->gambar && $item->gambar->path)
                                    <img src="{{ asset('storage/' . $item->gambar->path) }}" alt="{{ $item->name }}"
                                        class="w-12 h-12 object-cover border border-gray-200 rounded-lg">
                                @else
                                    <div
                                        class="w-12 h-12 bg-gradient-to-br from-emerald-100 to-teal-100 border border-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-box-open text-emerald-500"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <div class="max-w-xs truncate">{{ $item->description ?? 'Tiada keterangan' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                RM {{ number_format($item->price ?? 0, 2) }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('produk.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('produk.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-teal-700 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button wire:click="delete({{ $item->id }})"
                                        wire:confirm="Adakah anda pasti mahu memadamkan produk ini?"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Padam
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-box-open text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tiada produk dijumpai</h3>
                                    <p class="text-gray-500 mb-4">Cuba ubah carian atau tambah produk baru</p>
                                    <a href="{{ route('produk.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-lg shadow hover:from-emerald-600 hover:to-teal-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah produk pertama anda
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($produk->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $produk->firstItem() }}</span> ke <span
                            class="font-medium">{{ $produk->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $produk->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $produk->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
