<div>
    <!-- Welcome Section -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-gray-600">Here's what's happening with your business today.</p>
            </div>
            <button wire:click="refreshStats"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-sync-alt mr-2" wire:loading.class="animate-spin"></i>
                <span wire:loading.remove>Refresh</span>
                <span wire:loading>Refreshing...</span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" wire:poll.30s="loadStats">
        <!-- Total Bisnes -->
        <div class="bg-white rounded-lg shadow p-6 transform transition-all duration-300 hover:scale-105">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bisnes</p>
                    <p class="text-2xl font-bold text-gray-900" wire:loading.class="animate-pulse">{{ $totalBisnes }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="bg-white rounded-lg shadow p-6 transform transition-all duration-300 hover:scale-105">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-box text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-900" wire:loading.class="animate-pulse">{{ $totalProduk }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Prospek -->
        <div class="bg-white rounded-lg shadow p-6 transform transition-all duration-300 hover:scale-105">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Prospek</p>
                    <p class="text-2xl font-bold text-gray-900" wire:loading.class="animate-pulse">{{ $totalProspek }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Pembelian -->
        <div class="bg-white rounded-lg shadow p-6 transform transition-all duration-300 hover:scale-105">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pembelian</p>
                    <p class="text-2xl font-bold text-gray-900" wire:loading.class="animate-pulse">{{ $totalPembelian }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
