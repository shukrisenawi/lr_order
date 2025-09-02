<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Waktu Solat</h1>
                <p class="text-gray-600">Urus waktu solat masjid dan jadual ibadat</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('waktu-solat.create') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Waktu Baru
                </a>
                <div class="flex items-center gap-2">
                    <button wire:click="deleteAll"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Padam Semua
                    </button>
                    <input type="file" wire:model="excelFile" accept=".xlsx,.xls"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    <button wire:click="importExcel" wire:loading.attr="disabled" :disabled="$loading"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div wire:loading wire:target="importExcel" class="flex items-center">
                            <i class="fas fa-spinner fa-spin mr-2"></i>
                            Memuat...
                        </div>
                        <div wire:loading.remove wire:target="importExcel" class="flex items-center">
                            <i class="fas fa-upload mr-2"></i>
                            Import Excel
                        </div>
                    </button>
                </div>
            </div>
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

    @if (session()->has('error'))
        <div
            class="mb-8 p-4 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-triangle text-red-500 mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Prayer Time Selector -->
    <div class="mb-8">
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Waktu Solat</h3>
            <div class="flex items-center gap-4">
                <select wire:model.live="selectedPrayerTime"
                    class="px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @if($isBlinking) animate-pulse bg-red-50 border-red-300 @endif">
                    <option value="">Pilih Waktu Solat</option>
                    <option value="imsak">Imsak</option>
                    <option value="subuh">Subuh</option>
                    <option value="syuruk">Syuruk</option>
                    <option value="zohor">Zohor</option>
                    <option value="asar">Asar</option>
                    <option value="maghrib">Maghrib</option>
                    <option value="isyak">Isyak</option>
                </select>
                <button wire:click="showResetModal"
                    class="inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-database mr-2"></i>
                    Reset DB
                </button>
                @if($isBlinking)
                    <div class="text-red-600 font-semibold animate-pulse">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Waktu solat dalam 5 minit!
                    </div>
                @endif
            </div>

            <script>
                document.addEventListener('livewire:loaded', () => {
                    setInterval(() => {
                        @this.call('refreshBlinking');
                    }, 60000); // Check every minute
                });
            </script>
        </div>
    </div>

    <!-- Search -->
    <div class="mb-8">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari tarikh, tarikh hijrah, hari..."
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
                            wire:click="sortBy('tarikh')">
                            <div class="flex items-center">
                                Tarikh
                                @if ($sortField === 'tarikh')
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
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tarikh Hijrah</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Hari</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Imsak</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Subuh</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Syuruk</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Zohor</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Asar</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Maghrib</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Isyak</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($waktus as $item)
                        <tr class="hover:bg-blue-50 transition-colors duration-200"
                            wire:key="waktu-{{ $item->id }}">
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $item->tarikh ? \Carbon\Carbon::parse($item->tarikh)->format('d/m/Y') : '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->tarikh_hijrah }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->hari }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->imsak }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->subuh }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->syuruk }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->zohor }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->asar }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->maghrib }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->isyak }}</td>
                            <td class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('waktu-solat.show', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('waktu-solat.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button wire:click="delete({{ $item->id }})"
                                        wire:confirm="Adakah anda pasti mahu memadamkan waktu solat ini?"
                                        class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Padam
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-clock text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tiada waktu solat dijumpai</h3>
                                    <p class="text-gray-500 mb-4">Cuba ubah carian atau tambah waktu baru</p>
                                    <a href="{{ route('waktu-solat.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow hover:from-blue-600 hover:to-indigo-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah waktu pertama anda
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($waktus->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $waktus->firstItem() }}</span> ke <span
                            class="font-medium">{{ $waktus->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $waktus->total() }}</span> rekod
                    </div>
                    <div class="flex space-x-1">
                        {{-- Previous Page Link --}}
                        @if ($waktus->onFirstPage())
                            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-l-md cursor-not-allowed">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                        @else
                            <button wire:click="gotoPage({{ $waktus->currentPage() - 1 }})"
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        @endif

                        {{-- Current Page and Nearby Pages --}}
                        @php
                            $start = max(1, $waktus->currentPage() - 2);
                            $end = min($waktus->lastPage(), $waktus->currentPage() + 2);
                        @endphp

                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $waktus->currentPage())
                                <span class="px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-500 cursor-default">
                                    {{ $page }}
                                </span>
                            @else
                                <button wire:click="gotoPage({{ $page }})"
                                    class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    {{ $page }}
                                </button>
                            @endif
                        @endfor

                        {{-- Next Page Link --}}
                        @if ($waktus->hasMorePages())
                            <button wire:click="gotoPage({{ $waktus->currentPage() + 1 }})"
                                class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        @else
                            <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-white border border-gray-300 rounded-r-md cursor-not-allowed">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                        @endif
                    </div>

                    <!-- Reset DB Modal -->
                    @if($showResetModal)
                        <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white p-6 rounded-xl shadow-xl max-w-md w-full mx-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pengesahan Reset Database</h3>
                                <p class="text-gray-600 mb-4">Tindakan ini akan memadam semua data dan menjana semula. Masukkan kata laluan admin untuk meneruskan.</p>
                                <input type="password" wire:model="adminPassword" placeholder="Kata Laluan Admin"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-300 mb-4">
                                <div class="flex gap-3">
                                    <button wire:click="resetDatabase"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-red-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        <i class="fas fa-check mr-2"></i>
                                        Sahkan Reset
                                    </button>
                                    <button wire:click="closeResetModal"
                                        class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                        <i class="fas fa-times mr-2"></i>
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Delete All Modal -->
                    @if ($showDeleteModal)
                        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="delete-modal">
                            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                                <div class="mt-3">
                                    <div class="flex items-center justify-center mb-4">
                                        <div class="bg-red-100 rounded-full p-3">
                                            <i class="fas fa-exclamation-triangle text-red-600 text-2xl"></i>
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 text-center mb-2">Pengesahan Padam Semua Data</h3>
                                    <p class="text-sm text-gray-500 text-center mb-4">
                                        Adakah anda pasti mahu memadamkan SEMUA data waktu solat? Tindakan ini tidak boleh dibuat asal.
                                    </p>
                                    <div class="mb-4">
                                        <label for="deletePassword" class="block text-sm font-medium text-gray-700 mb-2">
                                            Masukkan kata laluan anda untuk pengesahan:
                                        </label>
                                        <input type="password" wire:model="deletePassword" id="deletePassword"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500"
                                            placeholder="Kata laluan">
                                        @error('deletePassword')
                                            <span class="text-red-500 text-xs">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="flex justify-end space-x-3">
                                        <button wire:click="closeDeleteModal"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                            Batal
                                        </button>
                                        <button wire:click="confirmDeleteAll"
                                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 disabled:opacity-50"
                                            :disabled="!$wire.deletePassword">
                                            Padam Semua
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
