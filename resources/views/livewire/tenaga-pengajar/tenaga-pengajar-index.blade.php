<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Pengurusan Tenaga Pengajar</h1>
                <p class="text-sm text-gray-600">Urus tenaga pengajar dan data mereka</p>
                <div class="flex items-center gap-2 mt-3">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-users mr-1"></i>
                        Jumlah: {{ $tenagaPengajar->total() }}
                    </span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <i class="fas fa-heart mr-1"></i>
                        Aktif: {{ $tenagaPengajar->where('status', true)->count() }}
                    </span>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('tenaga-pengajar.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg shadow-md hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Tenaga Pengajar Baru
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div
            class="mb-6 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span class="text-sm">{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Search -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari tenaga pengajar mengikut nama atau no tel..."
                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg bg-white focus:bg-white focus:border-amber-500 focus:ring-2 focus:ring-amber-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-amber-600 transition-colors"
                            wire:click="sortBy('nama')">
                            <div class="flex items-center">
                                Nama
                                @if ($sortField === 'nama')
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700"
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Alamat</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Gambar</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tenagaPengajar as $item)
                        <tr class="hover:bg-amber-50 transition-colors duration-200"
                            wire:key="tenaga-pengajar-{{ $item->id }}">
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->no_tel }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->alamat ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                @if($item->gambar)
                                    <img src="{{ asset('storage/tenaga-pengajar/' . $item->gambar) }}" alt="Gambar" class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <input type="checkbox" wire:change="updateStatus({{ $item->id }})"
                                    class="toggle toggle-sm toggle-success" {{ $item->status ? 'checked' : '' }}>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex gap-1">
                                    <a href="{{ route('tenaga-pengajar.show', $item) }}"
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-blue-700 bg-blue-50 rounded hover:bg-blue-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        View
                                    </a>
                                    <a href="{{ route('tenaga-pengajar.edit', $item) }}"
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-indigo-700 bg-indigo-50 rounded hover:bg-indigo-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button wire:click="delete({{ $item->id }})"
                                        wire:confirm="Are you sure you want to delete this tenaga pengajar?"
                                        class="inline-flex items-center px-2 py-1 text-sm font-medium text-red-700 bg-red-50 rounded hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-3 mb-2">
                                        <i class="fas fa-users text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-900 mb-1">Tiada tenaga pengajar dijumpai</h3>
                                    <p class="text-sm text-gray-500 mb-2">Cuba tukar carian anda atau tambah tenaga pengajar baru</p>
                                    <a href="{{ route('tenaga-pengajar.create') }}"
                                        class="inline-flex items-center px-3 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg shadow hover:from-amber-600 hover:to-orange-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Tenaga Pengajar Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($tenagaPengajar->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $tenagaPengajar->firstItem() }}</span> ke <span
                            class="font-medium">{{ $tenagaPengajar->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $tenagaPengajar->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $tenagaPengajar->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>