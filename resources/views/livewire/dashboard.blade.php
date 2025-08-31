<div class="w-full min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-4 md:p-6 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 left-10 w-32 h-32 bg-blue-200 rounded-full"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-purple-200 rounded-full"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-indigo-200 rounded-full"></div>
        <div class="absolute bottom-40 right-10 w-28 h-28 bg-green-200 rounded-full"></div>
    </div>
    <style>
        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-count {
            animation: countUp 0.8s ease-out forwards;
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
    <div class="relative z-10 fade-in">
    <!-- Hero Section -->
    <div class="max-w-full mx-auto mb-8 animate-fade-in">
        <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
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
    <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.2s;">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6" wire:poll.30s="loadStats">
            <!-- Business Block -->
            <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <i class="fas fa-building text-blue-600 text-lg"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-2xl md:text-3xl font-bold text-gray-900 animate-count" style="animation-delay: 0.1s;" wire:loading.class="animate-pulse">
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
                        <p class="text-2xl md:text-3xl font-bold text-gray-900 animate-count" style="animation-delay: 0.2s;" wire:loading.class="animate-pulse">
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
                        <p class="text-2xl md:text-3xl font-bold text-gray-900 animate-count" style="animation-delay: 0.3s;" wire:loading.class="animate-pulse">
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
                        <p class="text-xl md:text-2xl font-bold text-gray-900 animate-count" style="animation-delay: 0.3s;" wire:loading.class="animate-pulse">
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
    <div class="max-w-full mx-auto animate-fade-in" style="animation-delay: 0.5s;">
        <div class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
            <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 flex items-center">
                <i class="fas fa-rocket text-blue-500 mr-2"></i>
                Quick Actions
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                <a href="{{ route('bisnes.create') }}" class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="flex flex-col items-center text-center relative z-10">
                        <i class="fas fa-plus text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                        <span class="text-xs md:text-sm font-medium">Add Business</span>
                    </div>
                </a>
                <a href="{{ route('produk.create') }}" class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-green-500/25 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="flex flex-col items-center text-center relative z-10">
                        <i class="fas fa-box text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                        <span class="text-xs md:text-sm font-medium">Add Product</span>
                    </div>
                </a>
                <a href="{{ route('customer.create') }}" class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/25 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="flex flex-col items-center text-center relative z-10">
                        <i class="fas fa-users text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                        <span class="text-xs md:text-sm font-medium">Add Customer</span>
                    </div>
                </a>
                <a href="{{ route('invoice.create') }}" class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25 relative overflow-hidden">
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                    <div class="flex flex-col items-center text-center relative z-10">
                        <i class="fas fa-file-invoice text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                        <span class="text-xs md:text-sm font-medium">Create Invoice</span>
                    </div>
                </a>
            </div>
            </div>
        </div>
    </div>
</div>
