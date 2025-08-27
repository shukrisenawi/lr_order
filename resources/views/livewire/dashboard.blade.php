<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header Section -->
    <div class="mb-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p class="text-gray-600 text-lg">Selamat kembali, <span
                class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span></p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10" wire:poll.30s="loadStats">
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
                            <span>{{ $growthMetrics['bisnes_growth'] ?? 0 }}% dari bulan lepas</span>
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
                            <span>{{ $growthMetrics['produk_growth'] ?? 0 }}% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Customer Card -->
        <div
            class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Customer</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            {{ $totalCustomer }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-white text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                            <span>{{ $growthMetrics['customer_growth'] ?? 0 }}% dari bulan lepas</span>
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
                            <span>{{ $growthMetrics['pembelian_growth'] ?? 0 }}% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div
            class="bg-gradient-to-br from-purple-500 to-violet-600 rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0 bg-white bg-opacity-20 p-3 rounded-lg">
                        <i class="fas fa-money-bill-wave text-white text-2xl"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-white text-sm font-medium">Jumlah Hasil</p>
                        <div class="text-2xl font-bold text-white" wire:loading.class="animate-pulse">
                            RM{{ number_format($totalRevenue, 2) }}</div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="flex items-center text-white text-sm">
                        <span class="flex items-center">
                            <i class="fas fa-arrow-up text-green-300 mr-1"></i>
                            <span>{{ $growthMetrics['revenue_growth'] ?? 0 }}% dari bulan lepas</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Analytics Dashboard -->
    <div class="grid grid-cols-1 gap-8 mb-10">
        <!-- Combined Chart -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Hasil Bulanan & Kadar Penukaran</h2>
                <p class="text-gray-600 mt-1">Trend hasil sepanjang tahun dan Kadar Penukaran Customer kepada pelanggan
                </p>
            </div>
            <div class="p-6">
                <canvas id="combinedChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <!-- Top Products -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Produk Teratas</h2>
                <p class="text-gray-600 mt-1">Produk paling laris</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse ($topProducts as $index => $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="bg-indigo-100 text-indigo-600 p-2 rounded-full mr-3">
                                    <i class="fas fa-trophy text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $product['name'] ?? 'Unknown Product' }}
                                    </p>
                                    <p class="text-sm text-gray-600">{{ $product['sales'] ?? 0 }} jualan</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-semibold text-gray-900">
                                    RM{{ number_format($product['revenue'] ?? 0, 2) }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-chart-bar text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Tiada data produk</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden lg:col-span-2">
            <div class="px-6 py-5 border-b border-gray-100">
                <h2 class="text-xl font-bold text-gray-900">Aktiviti Terkini</h2>
                <p class="text-gray-600 mt-1">Kemas kini terbaru sistem anda</p>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start p-4 bg-gray-50 rounded-lg">
                            <div class="flex-shrink-0 bg-{{ $activity['color'] }}-100 p-3 rounded-full">
                                <i class="fas fa-{{ $activity['icon'] }} text-{{ $activity['color'] }}-600"></i>
                            </div>
                            <div class="ml-4 flex-1">
                                <p class="text-gray-600 text-sm mt-1">{{ $activity['description'] }}</p>
                                <p class="text-gray-500 text-xs mt-2">{{ $activity['time'] }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <i class="fas fa-inbox text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-500">Tiada aktiviti terkini</p>
                        </div>
                    @endforelse
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
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Bisnes
                            </h3>
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
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Produk
                            </h3>
                            <p class="text-sm text-gray-600">Daftar produk baru</p>
                        </div>
                    </div>
                </a>

                <!-- Tambah Customer -->
                <a href="{{ route('customer.create') }}" class="group block">
                    <div
                        class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-6 border border-amber-100 transition-all duration-300 group-hover:shadow-lg group-hover:border-amber-200 group-hover:from-amber-100 group-hover:to-orange-100">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="bg-amber-500 text-white p-3 rounded-full mb-4 group-hover:bg-amber-600 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah Customer
                            </h3>
                            <p class="text-sm text-gray-600">Daftar customer baru</p>
                        </div>
                    </div>

                    @script
                        <script>
                            document.addEventListener('livewire:init', function() {
                                // Function to initialize or update the combined chart
                                function initCombinedChart() {
                                    const ctx = document.getElementById('combinedChart').getContext('2d');

                                    // Destroy existing chart if it exists
                                    if (window.combinedChart) {
                                        window.combinedChart.destroy();
                                    }

                                    // Prepare data for the chart
                                    const revenueData = @json($revenueByMonth);
                                    const conversionData = @json($conversionRate);

                                    // Extract months and values
                                    const months = revenueData.map(item => item.month);
                                    const revenueValues = revenueData.map(item => item.revenue);
                                    const conversionValues = conversionData.rate || 0;

                                    // Create the combined chart
                                    window.combinedChart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: months,
                                            datasets: [{
                                                    label: 'Hasil Bulanan (RM)',
                                                    data: revenueValues,
                                                    borderColor: 'rgb(147, 51, 234)', // Purple color
                                                    backgroundColor: 'rgba(147, 51, 234, 0.1)',
                                                    borderWidth: 3,
                                                    pointRadius: 4,
                                                    pointBackgroundColor: 'rgb(147, 51, 234)',
                                                    pointBorderColor: '#fff',
                                                    pointBorderWidth: 2,
                                                    tension: 0.3,
                                                    fill: true,
                                                    yAxisID: 'y'
                                                },
                                                {
                                                    label: 'Kadar Penukaran (%)',
                                                    data: Array(months.length).fill(conversionValues),
                                                    borderColor: 'rgb(234, 179, 8)', // Yellow color
                                                    backgroundColor: 'rgba(234, 179, 8, 0.1)',
                                                    borderWidth: 3,
                                                    pointRadius: 4,
                                                    pointBackgroundColor: 'rgb(234, 179, 8)',
                                                    pointBorderColor: '#fff',
                                                    pointBorderWidth: 2,
                                                    tension: 0.3,
                                                    fill: true,
                                                    yAxisID: 'y1'
                                                }
                                            ]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            interaction: {
                                                mode: 'index',
                                                intersect: false
                                            },
                                            scales: {
                                                x: {
                                                    grid: {
                                                        display: false
                                                    },
                                                    ticks: {
                                                        color: '#6b7280'
                                                    }
                                                },
                                                y: {
                                                    type: 'linear',
                                                    display: true,
                                                    position: 'left',
                                                    grid: {
                                                        color: 'rgba(0, 0, 0, 0.05)'
                                                    },
                                                    ticks: {
                                                        color: '#6b7280',
                                                        callback: function(value) {
                                                            return 'RM' + value.toLocaleString();
                                                        }
                                                    }
                                                },
                                                y1: {
                                                    type: 'linear',
                                                    display: true,
                                                    position: 'right',
                                                    grid: {
                                                        drawOnChartArea: false
                                                    },
                                                    ticks: {
                                                        color: '#6b7280',
                                                        callback: function(value) {
                                                            return value + '%';
                                                        }
                                                    }
                                                }
                                            },
                                            plugins: {
                                                legend: {
                                                    position: 'top',
                                                    labels: {
                                                        color: '#374151',
                                                        font: {
                                                            size: 12
                                                        },
                                                        padding: 20
                                                    }
                                                },
                                                tooltip: {
                                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                                    titleColor: '#fff',
                                                    bodyColor: '#fff',
                                                    borderColor: 'rgba(0, 0, 0, 0.1)',
                                                    borderWidth: 1,
                                                    padding: 12,
                                                    callbacks: {
                                                        label: function(context) {
                                                            let label = context.dataset.label || '';
                                                            if (label) {
                                                                label += ': ';
                                                            }
                                                            if (context.datasetIndex === 0) {
                                                                label += 'RM' + context.parsed.y.toLocaleString();
                                                            } else {
                                                                label += context.parsed.y + '%';
                                                            }
                                                            return label;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    });
                                }

                                // Initialize the chart when the page loads
                                initCombinedChart();

                                // Re-initialize the chart when Livewire updates
                                Livewire.on('stats-updated', () => {
                                    setTimeout(() => {
                                        initCombinedChart();
                                    }, 100);
                                });
                            });
                        </script>
                    @endscript
                </a>

                <!-- Tambah Pembelian -->
                <a href="{{ route('customer-buy.create') }}" class="group block">
                    <div
                        class="bg-gradient-to-br from-rose-50 to-pink-50 rounded-xl p-6 border border-rose-100 transition-all duration-300 group-hover:shadow-lg group-hover:border-rose-200 group-hover:from-rose-100 group-hover:to-pink-100">
                        <div class="flex flex-col items-center text-center">
                            <div
                                class="bg-rose-500 text-white p-3 rounded-full mb-4 group-hover:bg-rose-600 transition-colors">
                                <i class="fas fa-plus text-xl"></i>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-1">Tambah
                                Pembelian</h3>
                            <p class="text-sm text-gray-600">Daftar pembelian baru</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
