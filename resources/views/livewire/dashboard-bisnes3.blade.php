<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">
            Dashboard {{ $selectedBisnes ? $selectedBisnes->nama_bines : 'Business' }}
        </h1>
        <p class="text-gray-600">Ringkasan prestasi dan analisis bisnes anda</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jumlah Pendapatan</p>
                    <p class="text-2xl font-bold text-gray-900">RM {{ number_format($totalRevenue, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jumlah Produk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProduk }}</p>
                </div>
            </div>
        </div>

        <!-- Total Customers -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jumlah Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalCustomer }}</p>
                </div>
            </div>
        </div>

        <!-- Total Invoices -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-orange-100 rounded-lg">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jumlah Invois</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalInvoice }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pendapatan Bulanan</h3>
            <canvas id="revenueChart" width="400" height="200"></canvas>
        </div>

        <!-- Conversion Rate -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kadar Penukaran Prospek</h3>
            <div class="flex items-center justify-center h-48">
                <div class="text-center">
                    <div class="text-4xl font-bold text-blue-600 mb-2">{{ $conversionRate['rate'] }}%</div>
                    <p class="text-gray-600">Dari {{ $conversionRate['total'] }} prospek</p>
                    <p class="text-sm text-gray-500">{{ $conversionRate['converted_prospects'] }} ditukar</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Top Products -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Produk Terbaru</h3>
            <div class="space-y-3">
                @forelse($topProducts as $product)
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600">{{ $product['product_name'] }}</span>
                        <span class="text-sm font-medium text-gray-900">RM {{ number_format($product['total_revenue'], 2) }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Tiada data produk</p>
                @endforelse
            </div>
        </div>

        <!-- Growth Metrics -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Metrik Pertumbuhan</h3>
            <div class="space-y-4">
                <div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pendapatan</span>
                        <span class="font-medium {{ $growthMetrics['revenue_growth']['growth_percentage'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $growthMetrics['revenue_growth']['growth_percentage'] }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ min(100, max(0, $growthMetrics['revenue_growth']['growth_percentage'] + 50)) }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Pelanggan</span>
                        <span class="font-medium {{ $growthMetrics['customer_growth']['growth_percentage'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $growthMetrics['customer_growth']['growth_percentage'] }}%
                        </span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mt-1">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min(100, max(0, $growthMetrics['customer_growth']['growth_percentage'] + 50)) }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aktiviti Terkini</h3>
            <div class="space-y-3 max-h-64 overflow-y-auto">
                @forelse($recentActivities as $activity)
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['date'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm">Tiada aktiviti terkini</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('livewire:loaded', function () {
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = @json($revenueByMonth);
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: revenueData.map(item => item.month),
                datasets: [{
                    label: 'Pendapatan (RM)',
                    data: revenueData.map(item => item.revenue),
                    borderColor: 'rgb(59, 130, 246)',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'RM ' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
