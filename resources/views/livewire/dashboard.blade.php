<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-light text-gray-800 mb-2">Papan Pemuka</h1>
        <p class="text-gray-500">Selamat kembali, {{ Auth::user()->name }}</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" wire:poll.30s="loadStats">
        <!-- Total Bisnes -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Jumlah Bisnes</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">{{ $totalBisnes }}</div>
        </div>

        <!-- Total Produk -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Jumlah Produk</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">{{ $totalProduk }}</div>
        </div>

        <!-- Total Prospek -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Jumlah Prospek</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">{{ $totalProspek }}</div>
        </div>

        <!-- Total Pembelian -->
        <div class="bg-white border border-gray-200 p-6">
            <div class="text-sm text-gray-600 mb-1">Jumlah Pembelian</div>
            <div class="text-2xl font-light text-gray-800" wire:loading.class="animate-pulse">{{ $totalPembelian }}
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white border border-gray-200 p-8">
        <h2 class="text-lg font-light text-gray-800 mb-6">Tindakan Pantas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('bisnes.create') }}" class="p-4 border border-gray-200 hover:border-gray-400 text-center">
                <div class="text-gray-600 mb-2">Tambah Bisnes</div>
            </a>
            <a href="{{ route('produk.create') }}" class="p-4 border border-gray-200 hover:border-gray-400 text-center">
                <div class="text-gray-600 mb-2">Tambah Produk</div>
            </a>
            <a href="{{ route('prospek.create') }}"
                class="p-4 border border-gray-200 hover:border-gray-400 text-center">
                <div class="text-gray-600 mb-2">Tambah Prospek</div>
            </a>
            <a href="{{ route('prospek-buy.create') }}"
                class="p-4 border border-gray-200 hover:border-gray-400 text-center">
                <div class="text-gray-600 mb-2">Tambah Pembelian</div>
            </a>
        </div>
    </div>
</div>
