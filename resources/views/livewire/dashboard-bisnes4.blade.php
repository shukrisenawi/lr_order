<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">
            Dashboard Data Penduduk
        </h1>
        <p class="text-gray-600">Analisis data populasi dari sistem data penduduk</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Population -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jumlah Penduduk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($populationByCula['total_population'] ?? 0) }}</p>
                    @if(($populationByCula['total_population'] ?? 0) == 0)
                        <p class="text-xs text-red-500 mt-1">Tiada data</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Total Cula Categories -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-teal-100 rounded-lg">
                    <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kategori Cula</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($populationByCula['cula_distribution'] ?? []) }}</p>
                </div>
            </div>
        </div>

        <!-- Total Bangsa Categories -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Kategori Bangsa</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($populationByBangsa['bangsa_distribution'] ?? []) }}</p>
                </div>
            </div>
        </div>

        <!-- Gender Distribution -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-pink-100 rounded-lg">
                    <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Jantina</p>
                    <p class="text-2xl font-bold text-gray-900">{{ count($populationByGender['gender_distribution'] ?? []) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Population by Cula Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Mengikut Cula</h3>
            @if(count($populationByCula['cula_distribution'] ?? []) > 0)
                <canvas id="populationCulaChart" width="400" height="300"></canvas>
            @else
                <div class="flex items-center justify-center h-64 text-gray-500">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p>Tiada data cula</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Population by Bangsa Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Mengikut Bangsa</h3>
            @if(count($populationByBangsa['bangsa_distribution'] ?? []) > 0)
                <canvas id="populationBangsaChart" width="400" height="300"></canvas>
            @else
                <div class="flex items-center justify-center h-64 text-gray-500">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p>Tiada data bangsa</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Population by Gender Chart -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Distribusi Mengikut Jantina</h3>
            @if(count($populationByGender['gender_distribution'] ?? []) > 0)
                <canvas id="populationGenderChart" width="400" height="300"></canvas>
            @else
                <div class="flex items-center justify-center h-64 text-gray-500">
                    <div class="text-center">
                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <p>Tiada data jantina</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Data Tables -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Cula Data Table -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Cula</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @forelse($populationByCula['cula_distribution'] ?? [] as $cula)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-900">Cula {{ $cula['cula_code'] }}</span>
                        <div class="text-right">
                            <div class="text-lg font-bold text-indigo-600">{{ number_format($cula['count']) }}</div>
                            <div class="text-xs text-gray-500">{{ $cula['percentage'] }}%</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Tiada data cula</p>
                @endforelse
            </div>
        </div>

        <!-- Bangsa Data Table -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Bangsa</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @forelse($populationByBangsa['bangsa_distribution'] ?? [] as $bangsa)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-900">{{ $bangsa['bangsa'] }}</span>
                        <div class="text-right">
                            <div class="text-lg font-bold text-purple-600">{{ number_format($bangsa['count']) }}</div>
                            <div class="text-xs text-gray-500">{{ $bangsa['percentage'] }}%</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Tiada data bangsa</p>
                @endforelse
            </div>
        </div>

        <!-- Gender Data Table -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Data Jantina</h3>
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @forelse($populationByGender['gender_distribution'] ?? [] as $gender)
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <span class="text-sm font-medium text-gray-900">{{ $gender['gender'] }}</span>
                        <div class="text-right">
                            <div class="text-lg font-bold text-pink-600">{{ number_format($gender['count']) }}</div>
                            <div class="text-xs text-gray-500">{{ $gender['percentage'] }}%</div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-sm text-center py-4">Tiada data jantina</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
</div>

<script>
document.addEventListener('livewire:loaded', function () {
    // Population by Cula Pie Chart
    const culaCtx = document.getElementById('populationCulaChart');
    if (culaCtx) {
        const culaData = @json($populationByCula['cula_distribution'] ?? []);
        if (culaData.length > 0) {
            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
                '#4BC0C0', '#FF6384'
            ];

            new Chart(culaCtx, {
                type: 'pie',
                data: {
                    labels: culaData.map(item => `Cula ${item.cula_code}`),
                    datasets: [{
                        data: culaData.map(item => item.percentage),
                        backgroundColor: colors.slice(0, culaData.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const count = culaData[context.dataIndex]?.count || 0;
                                    return `${label}: ${value}% (${count} orang)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Population by Bangsa Pie Chart
    const bangsaCtx = document.getElementById('populationBangsaChart');
    if (bangsaCtx) {
        const bangsaData = @json($populationByBangsa['bangsa_distribution'] ?? []);
        if (bangsaData.length > 0) {
            const colors = [
                '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0',
                '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
                '#4BC0C0', '#FF6384'
            ];

            new Chart(bangsaCtx, {
                type: 'pie',
                data: {
                    labels: bangsaData.map(item => item.bangsa),
                    datasets: [{
                        data: bangsaData.map(item => item.percentage),
                        backgroundColor: colors.slice(0, bangsaData.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const count = bangsaData[context.dataIndex]?.count || 0;
                                    return `${label}: ${value}% (${count} orang)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }

    // Population by Gender Pie Chart
    const genderCtx = document.getElementById('populationGenderChart');
    if (genderCtx) {
        const genderData = @json($populationByGender['gender_distribution'] ?? []);
        if (genderData.length > 0) {
            const colors = ['#FF6384', '#36A2EB']; // Pink for female, Blue for male

            new Chart(genderCtx, {
                type: 'pie',
                data: {
                    labels: genderData.map(item => item.gender),
                    datasets: [{
                        data: genderData.map(item => item.percentage),
                        backgroundColor: colors.slice(0, genderData.length),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                usePointStyle: true
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.parsed || 0;
                                    const count = genderData[context.dataIndex]?.count || 0;
                                    return `${label}: ${value}% (${count} orang)`;
                                }
                            }
                        }
                    }
                }
            });
        }
    }
});
</script>
