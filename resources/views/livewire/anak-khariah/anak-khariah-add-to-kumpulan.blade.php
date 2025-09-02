<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Tambah Anak Khariah ke Kumpulan</h1>
                <p class="text-sm text-gray-600">Pilih anak khariah dan tambah ke kumpulan yang dipilih</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('anak-khariah.index') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
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

    @if (session()->has('error'))
        <div
            class="mb-6 p-3 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span class="text-sm">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Selection Form -->
    <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Select Kumpulan -->
            <div>
                <label for="selectedKumpulan" class="block text-sm font-medium text-gray-700 mb-2">
                    Pilih Kumpulan <span class="text-red-500">*</span>
                </label>
                <select wire:model.live="selectedKumpulan" id="selectedKumpulan"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">-- Pilih Kumpulan --</option>
                    @foreach($kumpulans as $kumpulan)
                        <option value="{{ $kumpulan->id }}">{{ $kumpulan->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Action Button -->
            <div class="flex items-end">
                <button wire:click="addToKumpulan"
                    wire:loading.attr="disabled"
                    class="w-full px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50">
                    <i class="fas fa-users mr-2"></i>
                    <span wire:loading.remove>Tambah ke Kumpulan</span>
                    <span wire:loading>Menambah...</span>
                </button>
            </div>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search"
                placeholder="Cari anak khariah mengikut nama atau no tel..."
                class="w-full pl-10 pr-4 py-2 border border-gray-200 rounded-lg bg-white focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Anak Khariah List -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                            <input type="checkbox" wire:click="selectAll"
                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        </th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700 cursor-pointer hover:text-blue-600 transition-colors"
                            wire:click="sortBy('nama')">
                            <div class="flex items-center">
                                Nama
                                @if ($sortField === 'nama')
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700"
                            wire:click="sortBy('gelaran')">
                            <div class="flex items-center">
                                Gelaran
                                @if ($sortField === 'gelaran')
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700"
                            wire:click="sortBy('no_tel')">
                            <div class="flex items-center">
                                No Tel
                                @if ($sortField === 'no_tel')
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
                        <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Kumpulan Sekarang</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($anakKhariah as $item)
                        <tr class="hover:bg-blue-50 transition-colors duration-200"
                            wire:key="anak-khariah-{{ $item->id }}">
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <input type="checkbox" wire:model="selectedAnakKhariah" value="{{ $item->id }}"
                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            </td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $item->nama }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->gelaran ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $item->no_tel }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                @if($item->kumpulans->count() > 0)
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($item->kumpulans as $kumpulan)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $kumpulan->nama }}
                                                <button wire:click="removeFromKumpulan({{ $item->id }}, {{ $kumpulan->id }})"
                                                        wire:confirm="Adakah anda pasti ingin keluarkan {{ $item->nama }} dari kumpulan {{ $kumpulan->nama }}?"
                                                        class="ml-1 text-blue-600 hover:text-red-600 transition-colors duration-200"
                                                        title="Keluarkan dari kumpulan">
                                                    <i class="fas fa-times text-xs"></i>
                                                </button>
                                            </span>
                                        @endforeach
                                    </div>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-3 mb-2">
                                        <i class="fas fa-users text-gray-400 text-xl"></i>
                                    </div>
                                    <h3 class="text-base font-medium text-gray-900 mb-1">Tiada anak khariah dijumpai</h3>
                                    <p class="text-sm text-gray-500 mb-2">Cuba tukar carian anda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($anakKhariah->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $anakKhariah->firstItem() }}</span> ke <span
                            class="font-medium">{{ $anakKhariah->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $anakKhariah->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $anakKhariah->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>