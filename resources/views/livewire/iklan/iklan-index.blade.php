<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                        <i class="fas fa-bullhorn text-blue-500 mr-2"></i>
                        Pengurusan Iklan Pintar
                    </h1>
                    <p class="text-gray-600 text-sm">Urus dan pantau semua iklan anda dengan teknologi AI terkini</p>
                    <div class="flex items-center gap-2 mt-3">
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200 shadow-sm">
                            <i class="fas fa-brain mr-1 text-blue-600"></i>
                            AI Powered
                        </div>
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200 shadow-sm">
                            <i class="fas fa-magic mr-1 text-green-600"></i>
                            Smart Automation
                        </div>
                    </div>
                </div>
                <a href="{{ route('iklan.create') }}"
                    class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105">
                    <i class="fas fa-plus mr-2"></i>
                    Cipta Iklan Baru
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-sm">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-lg p-4 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-xs font-semibold uppercase tracking-wide">Jumlah Iklan</p>
                        <p class="text-2xl font-bold mt-1">{{ $iklan->total() ?? 0 }}</p>
                        <p class="text-blue-200 text-xs mt-1">Total dalam sistem</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-ad text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-lg p-4 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-xs font-semibold uppercase tracking-wide">Aktif Hari Ini</p>
                        <p class="text-2xl font-bold mt-1">{{ $iklan->where('on', 1)->count() ?? 0 }}</p>
                        <p class="text-green-200 text-xs mt-1">Iklan yang aktif</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-play-circle text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-600 rounded-lg p-4 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-xs font-semibold uppercase tracking-wide">Purata Hari</p>
                        <p class="text-2xl font-bold mt-1">{{ round($iklan->avg('hari') ?? 0) }}</p>
                        <p class="text-purple-200 text-xs mt-1">Hari purata</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-calendar-day text-lg"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 rounded-lg p-4 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-xs font-semibold uppercase tracking-wide">Performance</p>
                        <p class="text-2xl font-bold mt-1">{{ $iklan->where('on', 1)->count() > 0 ? 'A+' : 'B' }}</p>
                        <p class="text-orange-200 text-xs mt-1">Tahap prestasi</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-trophy text-lg"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="px-4 py-3 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-900">Carian & Penapisan</h3>
                        <p class="text-gray-600 text-xs mt-1">Cari iklan dengan mudah</p>
                    </div>
                    <div class="flex gap-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama iklan..."
                                class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg bg-white focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                        </div>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Iklan Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
            @forelse($iklan as $item)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 hover:shadow-xl group" wire:key="iklan-{{ $item->id }}">
                    <!-- Card Header -->
                    <div class="relative">
                        <div class="h-24 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-600 relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/20"></div>
                            <div class="absolute top-3 right-3">
                                <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <i class="fas fa-ad text-white text-sm"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-3 left-4 right-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 bg-white/20 rounded flex items-center justify-center backdrop-blur-sm">
                                            <i class="fas fa-hashtag text-white text-xs"></i>
                                        </div>
                                        <span class="text-white font-bold text-sm">Hari {{ $item->hari }}</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        @if($item->on)
                                            <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                                            <span class="text-green-200 font-semibold text-xs">Aktif</span>
                                        @else
                                            <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                                            <span class="text-gray-300 font-semibold text-xs">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <!-- Title and Status -->
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2" title="{{ $item->nama_iklan }}">
                                {{ $item->nama_iklan }}
                            </h3>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <p class="text-gray-600 text-xs leading-relaxed line-clamp-2" title="{{ $item->keterangan }}">
                                {{ Str::limit($item->keterangan ?? 'Tiada keterangan', 80) }}
                            </p>
                        </div>

                        <!-- AI Toggle -->
                        <div class="flex items-center justify-between mb-4 p-3 bg-gradient-to-r from-purple-50 to-pink-50 rounded-lg border border-purple-100">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 bg-gradient-to-r from-purple-500 to-pink-600 rounded flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-900">AI Status</p>
                                    <p class="text-xs text-gray-600">Pengurusan automatik</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:change="updateOn({{ $item->id }})"
                                    class="sr-only peer" {{ $item->on ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[1px] after:left-[1px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-pink-600"></div>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('iklan.show', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg hover:from-blue-100 hover:to-blue-200 transition-all duration-300 shadow-sm hover:shadow-md border border-blue-200 hover:border-blue-300 transform hover:scale-105">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat
                            </a>
                            <a href="{{ route('iklan.edit', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-indigo-700 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-lg hover:from-indigo-100 hover:to-indigo-200 transition-all duration-300 shadow-sm hover:shadow-md border border-indigo-200 hover:border-indigo-300 transform hover:scale-105">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <button wire:click="delete({{ $item->id }})"
                                wire:confirm="Adakah anda pasti mahu memadamkan iklan ini?"
                                class="inline-flex items-center justify-center px-3 py-2 text-xs font-medium text-red-700 bg-gradient-to-r from-red-50 to-red-100 rounded-lg hover:from-red-100 hover:to-red-200 transition-all duration-300 shadow-sm hover:shadow-md border border-red-200 hover:border-red-300 transform hover:scale-105">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        <!-- Created Date -->
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-calendar-plus mr-1"></i>
                                <span>Dicipta: {{ $item->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                        <div class="p-8 text-center">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                                <i class="fas fa-ad text-blue-500 text-2xl"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Tiada Iklan Dijumpai</h3>
                            <p class="text-gray-600 text-sm mb-4 max-w-md mx-auto">Mula cipta iklan pertama anda dengan teknologi AI terkini untuk pengurusan yang lebih efektif</p>
                            <a href="{{ route('iklan.create') }}"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105">
                                <i class="fas fa-plus mr-2"></i>
                                Cipta Iklan Pertama Anda
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($iklan->hasPages())
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700 font-medium">
                            Menunjukkan <span class="font-bold text-blue-600">{{ $iklan->firstItem() }}</span> ke <span class="font-bold text-blue-600">{{ $iklan->lastItem() }}</span> daripada <span class="font-bold text-blue-600">{{ $iklan->total() }}</span> iklan
                        </div>
                        <div class="flex items-center gap-2">
                            {{ $iklan->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
</div>
