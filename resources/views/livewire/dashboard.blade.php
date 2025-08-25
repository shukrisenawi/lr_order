<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Papan Pemuka</h1>
        <p class="text-gray-600 text-lg">Selamat kembali, <span
                class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span></p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10" wire:poll.30s="loadStats">
        <!-- Total Bisnes Card -->
        <div
            class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-building text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Bisnes</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            {{ $totalBisnes }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-white text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                            <span>12% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Produk Card -->
        <div
            class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-box-open text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Produk</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            {{ $totalProduk }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-white text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                            <span>8% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Prospek Card -->
        <div
            class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Prospek</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            {{ $totalProspek }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-white text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                            <span>5% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pembelian Card -->
        <div
            class="bg-gradient-to-br from-rose-500 to-pink-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-shopping-cart text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Pembelian</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            {{ $totalPembelian }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-white text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                            <span>15% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Tindakan Pantas</h2>
            <p class="text-gray-600 mt-1">Akses fungsi penting dengan cepat</p>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Tambah Bisnes -->
                <a href="{{ route('bisnes.create') }}" class="group block">
                    <div
                        class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100 transition-all duration-300 group-hover:shadow-lg group-hover:border-blue-200 group-hover:from-blue-100 group-hover:to-indigo-100">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="bg-blue-500 text-white p-3 rounded-full mb-4 group-hover:bg-blue-600 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Bisnes</h3>
                            <p class="text-sm text-gray-600">Daftar perniagaan baru</p>
                        </div>
                    </div>
                </a>

                <!-- Tambah Produk -->
                <a href="{{ route('produk.create') }}" class="group block">
                    <div
                        class="bg-gradient-to-br from-emerald-50 to-teal-50 rounded-xl p-6 border border-emerald-100 transition-all duration-300 group-hover:shadow-lg group-hover:border-emerald-200 group-hover:from-emerald-100 group-hover:to-teal-100">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="bg-emerald-500 text-white p-3 rounded-full mb-4 group-hover:bg-emerald-600 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Produk</h3>
                            <p class="text-sm text-gray-600">Daftar produk baru</p>
                        </div>
                    </div>
                </a>

                <!-- Tambah Prospek -->
                <a href="{{ route('prospek.create') }}" class="group block">
                    <div
                        class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100 transition-all duration-300 group-hover:shadow-lg group-hover:border-amber-200 group-hover:from-amber-100 group-hover:to-orange-100">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="bg-amber-500 text-white p-3 rounded-full mb-4 group-hover:bg-amber-600 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Prospek</h3>
                            <p class="text-sm text-gray-600">Daftar prospek baru</p>
                        </div>
                    </div>
                </a>

                <!-- Tambah Pembelian -->
                <a href="{{ route('prospek-buy.create') }}" class="group block">
                    <div
                        class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-xl p-6 border border-rose-100 transition-all duration-300 group-hover:shadow-lg group-hover:border-rose-200 group-hover:from-rose-100 group-hover:to-pink-100">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="bg-rose-500 text-white p-3 rounded-full mb-4 group-hover:bg-rose-600 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Pembelian</h3>
                            <p class="text-sm text-gray-600">Daftar pembelian baru</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="mt-10 bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100">
            <h2 class="text-xl font-bold text-gray-900">Aktiviti Terkini</h2>
            <p class="text-gray-600 mt-1">Kemas kini terbaru sistem anda</p>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-building text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Bisnes baru didaftarkan</h4>
                        <p class="text-gray-600 text-sm mt-1">"Kedai Runcit Maju" telah berjaya didaftarkan</p>
                        <p class="text-gray-500 text-xs mt-2">2 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0 bg-emerald-100 p-3 rounded-full">
                        <i class="fas fa-box-open text-emerald-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Produk ditambah</h4>
                        <p class="text-gray-600 text-sm mt-1">5 produk baru telah ditambah ke katalog</p>
                        <p class="text-gray-500 text-xs mt-2">5 jam yang lalu</p>
                    </div>
                </div>

                <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                    <div class="flex-shrink-0 bg-amber-100 p-3 rounded-full">
                        <i class="fas fa-users text-amber-600"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="font-medium text-gray-900">Prospek baru</h4>
                        <p class="text-gray-600 text-sm mt-1">3 prospek baru telah didaftarkan</p>
                        <p class="text-gray-500 text-xs mt-2">1 hari yang lalu</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
