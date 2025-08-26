<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Bisnes</h1>
                <p class="text-gray-600">Urus entiti bisnes anda</p>
            </div>
            <a href="{{ route('bisnes.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>
                Tambah Bisnes Baru
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
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari bisnes..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-blue-600 transition-colors"
                            wire:click="sortBy('nama_bisnes')">
                            <div class="flex items-center">
                                Nama Bisnes
                                @if ($sortField === 'nama_bisnes')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-blue-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-blue-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-blue-600 transition-colors"
                            wire:click="sortBy('nama_syarikat')">
                            <div class="flex items-center">
                                Nama Syarikat
                                @if ($sortField === 'nama_syarikat')
                                    @if ($sortDirection === 'asc')
                                        <i class="fas fa-arrow-up ml-2 text-blue-500"></i>
                                    @else
                                        <i class="fas fa-arrow-down ml-2 text-blue-500"></i>
                                    @endif
                                @else
                                    <i class="fas fa-sort ml-2 text-gray-400"></i>
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Telefon</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">On</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($bisnes as $item)
                        <tr class="hover:bg-blue-50 transition-colors duration-200"
                            wire:key="bisnes-{{ $item->id }}">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    @if ($item->gambar)
                                        <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($item->gambar) }}"
                                            alt="{{ $item->nama_bisnes }}"
                                            class="w-10 h-10 object-cover border border-gray-200 rounded-lg mr-3">
                                    @else
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-100 to-indigo-100 border border-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                            <i class="fas fa-building text-blue-500"></i>
                                        </div>
                                    @endif
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nama_bisnes }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->nama_syarikat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_tel }}</td>
                            <td class="px-6 py-4"><input type="checkbox" wire:change="updateOn({{ $item->id }})"
                                    class="toggle toggle-sm toggle-success" {{ $item->on ? 'checked' : '' }}></td>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('bisnes.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('bisnes.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button wire:click="delete({{ $item->id }})"
                                        wire:confirm="Adakah anda pasti mahu memadamkan bisnes ini?"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Padam
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-building text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tiada bisnes dijumpai</h3>
                                    <p class="text-gray-500 mb-4">Cuba ubah carian atau tambah bisnes baru</p>
                                    <a href="{{ route('bisnes.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow hover:from-blue-600 hover:to-indigo-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah bisnes pertama anda
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($bisnes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $bisnes->firstItem() }}</span> ke <span
                            class="font-medium">{{ $bisnes->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $bisnes->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $bisnes->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
