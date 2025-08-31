<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Welcome Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">Dashboard</h1>
                <p class="text-gray-600 text-sm">Welcome back, <span class="font-medium text-indigo-600">{{ Auth::user()->name }}</span></p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-500">{{ now()->format('l, M d, Y') }}</p>
                <p class="text-xs text-gray-400">{{ now()->format('H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Key Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6" wire:poll.30s="loadStats">
        <!-- Business Card -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-blue-500 to-blue-600 p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-building text-white text-sm"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-blue-100">Business</p>
                        <p class="text-lg font-bold text-white" wire:loading.class="animate-pulse">{{ $totalBisnes }}</p>
                    </div>
                </div>
                <div class="flex items-center text-blue-100 text-xs">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Active businesses</span>
                </div>
            </div>
        </div>

        <!-- Products Card -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-emerald-500 to-emerald-600 p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-box text-white text-sm"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-emerald-100">Products</p>
                        <p class="text-lg font-bold text-white" wire:loading.class="animate-pulse">{{ $totalProduk }}</p>
                    </div>
                </div>
                <div class="flex items-center text-emerald-100 text-xs">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Total products</span>
                </div>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-amber-500 to-orange-600 p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-users text-white text-sm"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-amber-100">Customers</p>
                        <p class="text-lg font-bold text-white" wire:loading.class="animate-pulse">{{ $totalCustomer }}</p>
                    </div>
                </div>
                <div class="flex items-center text-amber-100 text-xs">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>Happy customers</span>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="group relative overflow-hidden bg-gradient-to-br from-purple-500 to-purple-600 p-4 rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
            <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -translate-y-8 translate-x-8"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-2">
                    <div class="bg-white/20 p-2 rounded-lg backdrop-blur-sm">
                        <i class="fas fa-money-bill-wave text-white text-sm"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-purple-100">Revenue</p>
                        <p class="text-sm font-bold text-white" wire:loading.class="animate-pulse">RM{{ number_format($totalRevenue, 0) }}</p>
                    </div>
                </div>
                <div class="flex items-center text-purple-100 text-xs">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>This month</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-gradient-to-r from-white to-gray-50 p-4 rounded-lg shadow-lg border border-gray-100 mb-6">
        <div class="flex items-center mb-3">
            <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-2 rounded-lg mr-3">
                <i class="fas fa-bolt text-white text-sm"></i>
            </div>
            <h2 class="text-sm font-bold text-gray-900">Quick Actions</h2>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('bisnes.create') }}" class="group flex items-center p-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-300 transform hover:scale-105 shadow-sm hover:shadow-md">
                <div class="bg-blue-500 p-2 rounded-lg mr-3 group-hover:bg-blue-600 transition-colors">
                    <i class="fas fa-plus text-white text-xs"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Add Business</span>
            </a>

            <a href="{{ route('produk.create') }}" class="group flex items-center p-3 bg-gradient-to-r from-emerald-50 to-emerald-100 rounded-lg hover:from-emerald-100 hover:to-emerald-200 transition-all duration-300 transform hover:scale-105 shadow-sm hover:shadow-md">
                <div class="bg-emerald-500 p-2 rounded-lg mr-3 group-hover:bg-emerald-600 transition-colors">
                    <i class="fas fa-plus text-white text-xs"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Add Product</span>
            </a>

            <a href="{{ route('customer.create') }}" class="group flex items-center p-3 bg-gradient-to-r from-amber-50 to-amber-100 rounded-lg hover:from-amber-100 hover:to-amber-200 transition-all duration-300 transform hover:scale-105 shadow-sm hover:shadow-md">
                <div class="bg-amber-500 p-2 rounded-lg mr-3 group-hover:bg-amber-600 transition-colors">
                    <i class="fas fa-plus text-white text-xs"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Add Customer</span>
            </a>

            <a href="{{ route('invoice.create') }}" class="group flex items-center p-3 bg-gradient-to-r from-purple-50 to-purple-100 rounded-lg hover:from-purple-100 hover:to-purple-200 transition-all duration-300 transform hover:scale-105 shadow-sm hover:shadow-md">
                <div class="bg-purple-500 p-2 rounded-lg mr-3 group-hover:bg-purple-600 transition-colors">
                    <i class="fas fa-plus text-white text-xs"></i>
                </div>
                <span class="text-xs font-medium text-gray-700">Create Invoice</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-gradient-to-r from-white to-gray-50 p-4 rounded-lg shadow-lg border border-gray-100">
        <div class="flex items-center mb-3">
            <div class="bg-gradient-to-r from-gray-500 to-gray-600 p-2 rounded-lg mr-3">
                <i class="fas fa-history text-white text-sm"></i>
            </div>
            <h2 class="text-sm font-bold text-gray-900">Recent Activity</h2>
        </div>
        <div class="space-y-3">
            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-r from-blue-400 to-blue-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-clock text-white text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Dashboard updated</p>
                    <p class="text-xs text-gray-500">{{ now()->format('M d, H:i') }}</p>
                </div>
                <div class="text-xs text-gray-400">
                    <i class="fas fa-circle text-green-400"></i>
                </div>
            </div>

            <div class="flex items-center p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300">
                <div class="bg-gradient-to-r from-green-400 to-green-500 p-2 rounded-lg mr-3">
                    <i class="fas fa-user text-white text-xs"></i>
                </div>
                <div class="flex-1">
                    <p class="text-sm font-medium text-gray-900">Welcome back, {{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-500">{{ now()->format('M d, H:i') }}</p>
                </div>
                <div class="text-xs text-gray-400">
                    <i class="fas fa-circle text-blue-400"></i>
                </div>
            </div>
        </div>
    </div>
</div>
