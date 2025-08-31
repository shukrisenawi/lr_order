<div class="w-full min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 md:p-6">
    <!-- Hero Section -->
    <div class="max-w-full mx-auto mb-8">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                        Welcome back, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-gray-600 text-sm md:text-base">
                        {{ now()->format('l, F j, Y') }} • Have a productive day
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl">👋</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Blocks -->
    <div class="max-w-full mx-auto mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6" wire:poll.30s="loadStats">
            <!-- Business Block -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-building text-blue-600 text-lg"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl md:text-3xl font-bold text-gray-900" wire:loading.class="animate-pulse">
                            {{ $totalBisnes }}
                        </p>
                        <p class="text-xs md:text-sm text-gray-500">Business</p>
                    </div>
                </div>
                <div class="w-full bg-blue-200 rounded-full h-2">
                    <div class="bg-blue-600 h-2 rounded-full" style="width: 75%"></div>
                </div>
            </div>

            <!-- Products Block -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <i class="fas fa-box text-green-600 text-lg"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl md:text-3xl font-bold text-gray-900" wire:loading.class="animate-pulse">
                            {{ $totalProduk }}
                        </p>
                        <p class="text-xs md:text-sm text-gray-500">Products</p>
                    </div>
                </div>
                <div class="w-full bg-green-200 rounded-full h-2">
                    <div class="bg-green-600 h-2 rounded-full" style="width: 60%"></div>
                </div>
            </div>

            <!-- Customers Block -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-orange-100 rounded-lg">
                        <i class="fas fa-users text-orange-600 text-lg"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl md:text-3xl font-bold text-gray-900" wire:loading.class="animate-pulse">
                            {{ $totalCustomer }}
                        </p>
                        <p class="text-xs md:text-sm text-gray-500">Customers</p>
                    </div>
                </div>
                <div class="w-full bg-orange-200 rounded-full h-2">
                    <div class="bg-orange-600 h-2 rounded-full" style="width: 85%"></div>
                </div>
            </div>

            <!-- Revenue Block -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <i class="fas fa-money-bill-wave text-purple-600 text-lg"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xl md:text-2xl font-bold text-gray-900" wire:loading.class="animate-pulse">
                            RM{{ number_format($totalRevenue, 0) }}
                        </p>
                        <p class="text-xs md:text-sm text-gray-500">Revenue</p>
                    </div>
                </div>
                <div class="w-full bg-purple-200 rounded-full h-2">
                    <div class="bg-purple-600 h-2 rounded-full" style="width: 90%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Block -->
    <div class="max-w-full mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200">
            <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <a href="{{ route('bisnes.create') }}" class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 md:p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-plus text-lg md:text-xl mb-2 group-hover:animate-bounce"></i>
                        <span class="text-xs md:text-sm font-medium">Add Business</span>
                    </div>
                </a>
                <a href="{{ route('produk.create') }}" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 md:p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-box text-lg md:text-xl mb-2 group-hover:animate-bounce"></i>
                        <span class="text-xs md:text-sm font-medium">Add Product</span>
                    </div>
                </a>
                <a href="{{ route('customer.create') }}" class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 md:p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-users text-lg md:text-xl mb-2 group-hover:animate-bounce"></i>
                        <span class="text-xs md:text-sm font-medium">Add Customer</span>
                    </div>
                </a>
                <a href="{{ route('invoice.create') }}" class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 md:p-4 rounded-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex flex-col items-center text-center">
                        <i class="fas fa-file-invoice text-lg md:text-xl mb-2 group-hover:animate-bounce"></i>
                        <span class="text-xs md:text-sm font-medium">Create Invoice</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
