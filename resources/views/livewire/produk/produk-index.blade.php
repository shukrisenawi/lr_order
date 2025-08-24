<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-light text-gray-800 mb-2">Pengurusan Produk</h1>
                <p class="text-gray-500">Urus produk anda</p>
            </div>
            <a href="{{ route('produk.create') }}" class="px-4 py-2 bg-gray-800 text-white hover:bg-gray-900">
                Tambah Produk Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search -->
    <div class="mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari produk..."
            class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none">
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Gambar</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer" wire:click="sortBy('name')">
                        Nama
                        @if ($sortField === 'name')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Keterangan</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer" wire:click="sortBy('price')">
                        Harga
                        @if ($sortField === 'price')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($produk as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50" wire:key="produk-{{ $item->id }}">
                        <td class="px-6 py-4">
                            @if ($item->gambar && $item->gambar->path)
                                <img src="{{ asset('storage/' . $item->gambar->path) }}" alt="{{ $item->name }}"
                                    class="w-12 h-12 object-cover border border-gray-200">
                            @else
                                <div class="w-12 h-12 bg-gray-100 border border-gray-200"></div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $item->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <div class="max-w-xs truncate">{{ $item->description ?? 'No description' }}</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            RM {{ number_format($item->price ?? 0, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('produk.show', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">Lihat</a>
                                <a href="{{ route('produk.edit', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">Edit</a>
                                <button wire:click="delete({{ $item->id }})"
                                    wire:confirm="Adakah anda pasti mahu memadamkan produk ini?"
                                    class="text-red-600 hover:text-red-800">Padam</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div>Tiada produk dijumpai</div>
                            <a href="{{ route('produk.create') }}"
                                class="text-gray-800 hover:underline mt-2 inline-block">
                                Tambah produk pertama anda
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($produk->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $produk->links() }}
            </div>
        @endif
    </div>
</div>
