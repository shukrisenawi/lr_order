<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" wire:poll.180s="refreshData">
    <!-- Header Section -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Jadual Data</h1>
                <p class="text-gray-600">Data akan dikemas kini setiap 3 minit secara automatik</p>
            </div>
            <div class="mt-4 sm:mt-0 flex items-center space-x-4">
                <div class="text-sm text-gray-500">
                    Kemas kini terakhir: <span class="font-medium">{{ $lastRefresh }}</span>
                </div>
                <button wire:click="refreshData"
                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <i class="fas fa-sync-alt mr-2" wire:loading.class="animate-spin"></i>
                    Kemas Kini
                </button>
            </div>
        </div>
    </div>

    <!-- Tab Navigation -->
    <div class="mb-6">
        <nav class="flex space-x-8" aria-label="Tabs">
            <button wire:click="setActiveTab('bisnes')"
                class="@if ($activeTab === 'bisnes') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-building mr-2"></i>
                Bisnes
            </button>
            <button wire:click="setActiveTab('produk')"
                class="@if ($activeTab === 'produk') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-box-open mr-2"></i>
                Produk
            </button>
            <button wire:click="setActiveTab('prospek')"
                class="@if ($activeTab === 'prospek') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-users mr-2"></i>
                Prospek
            </button>
            <button wire:click="setActiveTab('pembelian')"
                class="@if ($activeTab === 'pembelian') border-indigo-500 text-indigo-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                <i class="fas fa-shopping-cart mr-2"></i>
                Pembelian
            </button>
        </nav>
    </div>

    <!-- Search Bar -->
    <div class="mb-6">
        <div class="max-w-md">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input wire:model.live="search" type="text"
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    placeholder="Cari data...">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">
                    @switch($activeTab)
                        @case('bisnes')
                            Data Bisnes
                        @break

                        @case('produk')
                            Data Produk
                        @break

                        @case('prospek')
                            Data Prospek
                        @break

                        @case('pembelian')
                            Data Pembelian
                        @break
                    @endswitch
                </h3>
                <div class="text-sm text-gray-500">
                    Jumlah: {{ $totalRecords }} rekod
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                @if ($activeTab === 'bisnes')
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Bisnes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jenis Bisnes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Alamat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarikh Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->nama_bisnes }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->jenis_bisnes }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->alamat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p>Tiada data bisnes dijumpai</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @elseif($activeTab === 'produk')
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarikh Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->nama_produk }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->kategori }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    RM{{ number_format($item->harga, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p>Tiada data produk dijumpai</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @elseif($activeTab === 'prospek')
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Telefon</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Bisnes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarikh Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->nama }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->telefon }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->bisnes->nama_bisnes ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p>Tiada data prospek dijumpai</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @elseif($activeTab === 'pembelian')
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nama Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kuantiti</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tarikh Dibuat</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($data as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $item->prospekAlamat->prospek->nama ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->produk->nama_produk ?? 'N/A' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->kuantiti }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    RM{{ number_format($item->harga, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <i class="fas fa-inbox text-4xl mb-4 text-gray-300"></i>
                                    <p>Tiada data pembelian dijumpai</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                @endif
            </table>
        </div>

        <!-- Pagination -->
        @if ($data->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $data->links() }}
            </div>
        @endif
    </div>

    <!-- Auto-refresh indicator -->
    <div class="mt-6 text-center">
        <div class="inline-flex items-center px-4 py-2 bg-green-100 border border-green-200 rounded-md">
            <div class="flex items-center">
                <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse mr-2"></div>
                <span class="text-sm text-green-700">Data akan dikemas kini automatik setiap 3 minit</span>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('data-refreshed', (event) => {
            // Show a brief notification when data is refreshed
            const notification = document.createElement('div');
            notification.className =
                'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg z-50';
            notification.textContent = 'Data telah dikemas kini!';
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        });
    });
</script>
