<div
    class="w-full min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 p-4 md:p-6 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute top-10 left-10 w-32 h-32 bg-blue-200 rounded-full"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-purple-200 rounded-full"></div>
        <div class="absolute bottom-20 left-1/4 w-40 h-40 bg-indigo-200 rounded-full"></div>
        <div class="absolute bottom-40 right-10 w-28 h-28 bg-green-200 rounded-full"></div>
    </div>
    <style>
        @keyframes countUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-count {
            animation: countUp 0.8s ease-out forwards;
        }

        .fade-in {
            animation: fadeIn 1s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
    <div class="relative z-10 fade-in">
        <!-- Hero Section -->
        <div class="max-w-full mx-auto mb-8 animate-fade-in">
            <div
                class="bg-white rounded-xl shadow-lg p-6 md:p-8 border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="flex flex-col md:flex-row items-center justify-between">
                    <div class="mb-4 md:mb-0">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">
                            Welcome back, {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-gray-600 text-sm md:text-base">
                            {{ now()->format('l, F j, Y') }} •
                            @if($dashboardType === 'business_ai')
                                AI-Powered Business Dashboard
                            @elseif($dashboardType === 'business_standard')
                                Standard Business Dashboard
                            @elseif($dashboardType === 'education')
                                Education Management Dashboard
                            @elseif($dashboardType === 'data_population')
                                Population Data Dashboard
                            @else
                                General Dashboard
                            @endif
                            for {{ $selectedBisnes ? $selectedBisnes->nama_bisnes : 'Selected Business' }}
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
                <div
                    class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <i class="fas fa-building text-blue-600 text-lg"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl md:text-3xl font-bold text-gray-900 animate-count"
                                style="animation-delay: 0.1s;" wire:loading.class="animate-pulse">
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
                <div
                    class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <i class="fas fa-box text-green-600 text-lg"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl md:text-3xl font-bold text-gray-900 animate-count"
                                style="animation-delay: 0.2s;" wire:loading.class="animate-pulse">
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
                <div
                    class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-orange-100 rounded-lg">
                            <i class="fas fa-users text-orange-600 text-lg"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-2xl md:text-3xl font-bold text-gray-900 animate-count"
                                style="animation-delay: 0.3s;" wire:loading.class="animate-pulse">
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
                <div
                    class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between mb-3">
                        <div class="p-2 bg-purple-100 rounded-lg">
                            <i class="fas fa-money-bill-wave text-purple-600 text-lg"></i>
                        </div>
                        <div class="text-right">
                            <p class="text-xl md:text-2xl font-bold text-gray-900 animate-count"
                                style="animation-delay: 0.3s;" wire:loading.class="animate-pulse">
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

        <!-- Dashboard Type Specific Section -->
        @if($dashboardType === 'business_ai')
            <!-- AI Business Dashboard -->
            <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-robot text-blue-500 mr-2"></i>
                        AI-Powered Features
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 p-4 rounded-lg">
                            <i class="fas fa-magic text-2xl text-blue-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-900">Smart Content Generation</h4>
                            <p class="text-sm text-gray-600">AI-powered advertisement creation</p>
                        </div>
                        <div class="bg-gradient-to-r from-green-50 to-green-100 p-4 rounded-lg">
                            <i class="fas fa-chart-line text-2xl text-green-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-900">Predictive Analytics</h4>
                            <p class="text-sm text-gray-600">Forecast sales and trends</p>
                        </div>
                        <div class="bg-gradient-to-r from-purple-50 to-purple-100 p-4 rounded-lg">
                            <i class="fas fa-users-cog text-2xl text-purple-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-900">Customer Insights</h4>
                            <p class="text-sm text-gray-600">AI-driven customer analysis</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($dashboardType === 'education')
            <!-- Education Dashboard -->
            <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-graduation-cap text-green-500 mr-2"></i>
                        Education Management Overview
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ \App\Models\AnakKhariah::where('bisnes_id', $selectedBisnesId)->count() }}</div>
                            <div class="text-sm text-gray-500">Anak Khariah</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ \App\Models\TenagaPengajar::where('bisnes_id', $selectedBisnesId)->count() }}</div>
                            <div class="text-sm text-gray-500">Tenaga Pengajar</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ \App\Models\KitabPengajian::where('bisnes_id', $selectedBisnesId)->count() }}</div>
                            <div class="text-sm text-gray-500">Kitab Pengajian</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ \App\Models\JadualPengajian::where('bisnes_id', $selectedBisnesId)->count() }}</div>
                            <div class="text-sm text-gray-500">Jadual Pengajian</div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($dashboardType === 'data_population')
            <!-- Population Data Dashboard -->
            <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-users text-orange-500 mr-2"></i>
                        Population Data Overview
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ \App\Models\DataPenduduk::where('bisnes_id', $selectedBisnesId)->count() }}</div>
                            <div class="text-sm text-gray-500">Total Records</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-green-600">{{ \App\Models\DataPenduduk::where('bisnes_id', $selectedBisnesId)->where('jantina', 'Lelaki')->count() }}</div>
                            <div class="text-sm text-gray-500">Male</div>
                        </div>
                        <div class="text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ \App\Models\DataPenduduk::where('bisnes_id', $selectedBisnesId)->where('jantina', 'Perempuan')->count() }}</div>
                            <div class="text-sm text-gray-500">Female</div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif($dashboardType === 'business_standard')
            <!-- Standard Business Dashboard -->
            <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.4s;">
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-briefcase text-indigo-500 mr-2"></i>
                        Business Operations
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-gradient-to-r from-indigo-50 to-indigo-100 p-4 rounded-lg">
                            <i class="fas fa-shopping-cart text-2xl text-indigo-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-900">Product Management</h4>
                            <p class="text-sm text-gray-600">Manage your product catalog</p>
                        </div>
                        <div class="bg-gradient-to-r from-teal-50 to-teal-100 p-4 rounded-lg">
                            <i class="fas fa-handshake text-2xl text-teal-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-900">Customer Relations</h4>
                            <p class="text-sm text-gray-600">Track customer interactions</p>
                        </div>
                        <div class="bg-gradient-to-r from-pink-50 to-pink-100 p-4 rounded-lg">
                            <i class="fas fa-file-invoice-dollar text-2xl text-pink-600 mb-2"></i>
                            <h4 class="font-semibold text-gray-900">Invoice Management</h4>
                            <p class="text-sm text-gray-600">Handle billing and payments</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Charts Section -->
        <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.6s;">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Revenue Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-blue-500 mr-2"></i>
                        Revenue Trend
                    </h3>
                    <div class="h-64">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>

                <!-- Product Performance Chart -->
                <div class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-chart-pie text-green-500 mr-2"></i>
                        Product Performance
                    </h3>
                    <div class="h-64">
                        <canvas id="productChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Block -->
        <div class="max-w-full mx-auto animate-fade-in" style="animation-delay: 0.5s;">
            <div
                class="bg-white rounded-xl shadow-lg p-4 md:p-6 border border-gray-200 hover:shadow-2xl transition-shadow duration-300">
                <h3 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-rocket text-blue-500 mr-2"></i>
                    Quick Actions
                </h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
                    @if($dashboardType === 'business_ai')
                        <a href="{{ route('ai') }}"
                            class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-robot text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">AI Generator</span>
                            </div>
                        </a>
                        <a href="{{ route('produk.create') }}"
                            class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-green-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-box text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Product</span>
                            </div>
                        </a>
                        <a href="{{ route('iklan.create') }}"
                            class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-bullhorn text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Create Ad</span>
                            </div>
                        </a>
                        @if($selectedBisnes && $selectedBisnes->type_id == 1)
                        <a href="{{ route('customer.create') }}"
                            class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-users text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Customer</span>
                            </div>
                        </a>
                        @endif
                    @elseif($dashboardType === 'education')
                        <a href="{{ route('anak-khariah.create') }}"
                            class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-heart text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Student</span>
                            </div>
                        </a>
                        <a href="{{ route('tenaga-pengajar.create') }}"
                            class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-green-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-chalkboard-teacher text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Teacher</span>
                            </div>
                        </a>
                        <a href="{{ route('jadual-pengajian.create') }}"
                            class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-calendar text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Schedule Class</span>
                            </div>
                        </a>
                        <a href="{{ route('kitab-pengajian.create') }}"
                            class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-book text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Book</span>
                            </div>
                        </a>
                    @elseif($dashboardType === 'data_population')
                        <a href="{{ route('data-penduduk.create') }}"
                            class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-user-plus text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Record</span>
                            </div>
                        </a>
                        <a href="{{ route('data-penduduk.index') }}"
                            class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-green-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-table text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">View Data</span>
                            </div>
                        </a>
                        <a href="#"
                            class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-chart-bar text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Analytics</span>
                            </div>
                        </a>
                        <a href="#"
                            class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-file-export text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Export</span>
                            </div>
                        </a>
                    @else
                        <a href="{{ route('produk.create') }}"
                            class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-blue-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-box text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Product</span>
                            </div>
                        </a>
                        @if($selectedBisnes && $selectedBisnes->type_id == 1)
                        <a href="{{ route('customer.create') }}"
                            class="group bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-green-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-users text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Customer</span>
                            </div>
                        </a>
                        @endif
                        @if($selectedBisnes && $selectedBisnes->type_id == 1)
                        <a href="{{ route('invoice.create') }}"
                            class="group bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-purple-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-file-invoice text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Create Invoice</span>
                            </div>
                        </a>
                        @endif
                        <a href="{{ route('bisnes.create') }}"
                            class="group bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white p-3 md:p-4 rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg hover:shadow-orange-500/25 relative overflow-hidden">
                            <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
                            <div class="flex flex-col items-center text-center relative z-10">
                                <i class="fas fa-plus text-lg md:text-xl mb-2 group-hover:animate-bounce transition-transform duration-300"></i>
                                <span class="text-xs md:text-sm font-medium">Add Business</span>
                            </div>
                        </a>
                    @endif
                </div>

                <!-- Reports Section -->
                <div class="max-w-full mx-auto mb-8 animate-fade-in" style="animation-delay: 0.8s;">
                    <div
                        class="bg-white rounded-xl shadow-lg p-6 border border-gray-200 hover:shadow-xl transition-shadow">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-file-alt text-purple-500 mr-2"></i>
                            Quick Reports
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($dashboardType === 'business_ai')
                                @if($selectedBisnes && $selectedBisnes->type_id == 1)
                                <a href="{{ route('customer.index') }}"
                                    class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-blue-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Customer Analytics</p>
                                            <p class="text-sm text-gray-600">AI-powered insights</p>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                <a href="{{ route('produk.index') }}"
                                    class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-box text-green-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Product Performance</p>
                                            <p class="text-sm text-gray-600">Sales analytics</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('iklan.index') }}"
                                    class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-purple-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-bullhorn text-purple-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Ad Campaign Report</p>
                                            <p class="text-sm text-gray-600">AI-generated content</p>
                                        </div>
                                    </div>
                                </a>
                            @elseif($dashboardType === 'education')
                                <a href="{{ route('anak-khariah.index') }}"
                                    class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-blue-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-heart text-blue-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Student Report</p>
                                            <p class="text-sm text-gray-600">Student management</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('jadual-pengajian.index') }}"
                                    class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-green-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Schedule Report</p>
                                            <p class="text-sm text-gray-600">Class schedules</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('pengajian.index') }}"
                                    class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-purple-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-graduation-cap text-purple-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Study Sessions</p>
                                            <p class="text-sm text-gray-600">Learning progress</p>
                                        </div>
                                    </div>
                                </a>
                            @elseif($dashboardType === 'data_population')
                                <a href="{{ route('data-penduduk.index') }}"
                                    class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-blue-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Population Data</p>
                                            <p class="text-sm text-gray-600">Complete records</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#"
                                    class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-chart-pie text-green-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Demographics</p>
                                            <p class="text-sm text-gray-600">Age & gender stats</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="#"
                                    class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-purple-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-map-marked-alt text-purple-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Geographic Report</p>
                                            <p class="text-sm text-gray-600">Location analysis</p>
                                        </div>
                                    </div>
                                </a>
                            @else
                                @if($selectedBisnes && $selectedBisnes->type_id == 1)
                                <a href="{{ route('customer.index') }}"
                                    class="group bg-gradient-to-r from-blue-50 to-blue-100 hover:from-blue-100 hover:to-blue-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-blue-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-users text-blue-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Customer Report</p>
                                            <p class="text-sm text-gray-600">View all customers</p>
                                        </div>
                                    </div>
                                </a>
                                <a href="{{ route('invoice.index') }}"
                                    class="group bg-gradient-to-r from-green-50 to-green-100 hover:from-green-100 hover:to-green-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-green-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-invoice-dollar text-green-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Invoice Report</p>
                                            <p class="text-sm text-gray-600">View all invoices</p>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                <a href="{{ route('produk.index') }}"
                                    class="group bg-gradient-to-r from-purple-50 to-purple-100 hover:from-purple-100 hover:to-purple-200 p-4 rounded-lg transition-all duration-300 transform hover:scale-105 border border-purple-200">
                                    <div class="flex items-center">
                                        <i class="fas fa-box text-purple-600 text-2xl mr-3"></i>
                                        <div>
                                            <p class="font-semibold text-gray-900">Product Report</p>
                                            <p class="text-sm text-gray-600">View all products</p>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart.js Scripts -->
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('livewire:loaded', function() {
                    // Revenue Chart
                    const revenueCtx = document.getElementById('revenueChart');
                    if (revenueCtx) {
                        new Chart(revenueCtx, {
                            type: 'line',
                            data: {
                                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                                datasets: [{
                                    label: 'Revenue (RM)',
                                    data: [1200, 1900, 3000, 5000, 2000, 3000],
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    tension: 0.4,
                                    fill: true
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        ticks: {
                                            callback: function(value) {
                                                return 'RM' + value.toLocaleString();
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // Product Chart
                    const productCtx = document.getElementById('productChart');
                    if (productCtx) {
                        new Chart(productCtx, {
                            type: 'doughnut',
                            data: {
                                labels: ['Active Products', 'Inactive Products', 'Out of Stock'],
                                datasets: [{
                                    data: [{{ $totalProduk }}, {{ max(0, $totalProduk - 2) }}, 1],
                                    backgroundColor: [
                                        '#10b981',
                                        '#f59e0b',
                                        '#ef4444'
                                    ],
                                    borderWidth: 2
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        position: 'bottom',
                                    }
                                }
                            }
                        });
                    }
                });
            </script>
        </div>
    </div>
</div>
