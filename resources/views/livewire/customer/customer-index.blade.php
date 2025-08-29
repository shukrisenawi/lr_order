<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Customer</h1>
                <p class="text-gray-600">Urus customer anda</p>
            </div>
            <a href="{{ route('customer.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>
                Tambah Customer Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Search -->
    <div class="mb-8">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari customer mengikut nama, telefon, atau emel..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-amber-600 transition-colors"
                            wire:click="sortBy('nama_penerima')">
                            <div class="flex items-center">
                                Nama
                                @if ($sortField === 'nama_penerima')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-amber-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-amber-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-amber-600 transition-colors"
                            wire:click="sortBy('alamat')">
                            <div class="flex items-center">
                                Alamat
                                @if ($sortField === 'alamat')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-amber-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-amber-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-amber-600 transition-colors"
                            wire:click="sortBy('no_tel')">
                            <div class="flex items-center">
                                No Tel
                                @if ($sortField === 'no_tel')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-amber-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-amber-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>

                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-amber-600 transition-colors"
                            wire:click="sortBy('catatan')">
                            <div class="flex items-center">
                                Catatan
                                @if ($sortField === 'catatan')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-amber-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-amber-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($customer as $item)
                        <tr class="hover:bg-amber-50 transition-colors duration-200"
                            wire:key="customer-{{ $item->id }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->gelaran }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->nama_penerima }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->alamat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_tel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->catatan }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('customer.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-700 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                    <a href="{{ route('customer.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-orange-700 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button wire:click="delete({{ $item->id }})"
                                        wire:confirm="Are you sure you want to delete this prospect?"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">No prospects found</h3>
                                    <p class="text-gray-500 mb-4">Try changing your search or add a new prospect</p>
                                    <a href="{{ route('customer.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg shadow hover:from-amber-600 hover:to-orange-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Add your first prospect
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($customer->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $customer->firstItem() }}</span> ke <span
                            class="font-medium">{{ $customer->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $customer->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $customer->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
