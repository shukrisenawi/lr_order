<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-12">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                        <i class="fas fa-bullhorn text-blue-500 mr-4"></i>
                        Pengurusan Iklan Pintar
                    </h1>
                    <p class="text-gray-600 text-lg">Urus dan pantau semua iklan anda dengan teknologi AI terkini</p>
                    <div class="flex items-center gap-4 mt-6">
                        <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-2 border-blue-200 shadow-sm">
                            <i class="fas fa-brain mr-2 text-blue-600"></i>
                            AI Powered
                        </div>
                        <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200 shadow-sm">
                            <i class="fas fa-magic mr-2 text-green-600"></i>
                            Smart Automation
                        </div>
                    </div>
                </div>
                <a href="{{ route('iklan.create') }}"
                    class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-plus mr-3 text-lg"></i>
                    Cipta Iklan Baru
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-8 p-6 bg-gradient-to-r from-green-50 via-emerald-50 to-teal-50 border-2 border-green-200 text-green-800 rounded-2xl shadow-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-4 text-xl"></i>
                    <span class="font-semibold text-lg">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
            <div class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide">Jumlah Iklan</p>
                        <p class="text-4xl font-bold mt-2">{{ $iklan->total() ?? 0 }}</p>
                        <p class="text-blue-200 text-xs mt-1">Total dalam sistem</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-ad text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold uppercase tracking-wide">Aktif Hari Ini</p>
                        <p class="text-4xl font-bold mt-2">{{ $iklan->where('on', 1)->count() ?? 0 }}</p>
                        <p class="text-green-200 text-xs mt-1">Iklan yang aktif</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-play-circle text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-600 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide">Purata Hari</p>
                        <p class="text-4xl font-bold mt-2">{{ round($iklan->avg('hari') ?? 0) }}</p>
                        <p class="text-purple-200 text-xs mt-1">Hari purata</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-calendar-day text-3xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-semibold uppercase tracking-wide">Performance</p>
                        <p class="text-4xl font-bold mt-2">{{ $iklan->where('on', 1)->count() > 0 ? 'A+' : 'B' }}</p>
                        <p class="text-orange-200 text-xs mt-1">Tahap prestasi</p>
                    </div>
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-trophy text-3xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-10">
            <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900">Carian & Penapisan</h3>
                        <p class="text-gray-600 text-sm mt-1">Cari iklan dengan mudah</p>
                    </div>
                    <div class="flex gap-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-lg"></i>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama iklan..."
                                class="w-80 pl-12 pr-6 py-4 border-2 border-gray-300 rounded-2xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm hover:shadow-md text-lg">
                        </div>
                        <select class="px-6 py-4 border-2 border-gray-300 rounded-2xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm hover:shadow-md text-lg">
                            <option value="">Semua Status</option>
                            <option value="active">Aktif</option>
                            <option value="inactive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- Iklan Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-10">
            @forelse($iklan as $item)
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden transform hover:scale-105 transition-all duration-300 hover:shadow-2xl group" wire:key="iklan-{{ $item->id }}">
                    <!-- Card Header -->
                    <div class="relative">
                        <div class="h-32 bg-gradient-to-r from-blue-500 via-purple-600 to-pink-600 relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/20"></div>
                            <div class="absolute top-4 right-4">
                                <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                    <i class="fas fa-ad text-white text-xl"></i>
                                </div>
                            </div>
                            <div class="absolute bottom-4 left-6 right-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center backdrop-blur-sm">
                                            <i class="fas fa-hashtag text-white text-sm"></i>
                                        </div>
                                        <span class="text-white font-bold text-lg">Hari {{ $item->hari }}</span>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @if($item->on)
                                            <div class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></div>
                                            <span class="text-green-200 font-semibold text-sm">Aktif</span>
                                        @else
                                            <div class="w-3 h-3 bg-gray-400 rounded-full"></div>
                                            <span class="text-gray-300 font-semibold text-sm">Tidak Aktif</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-6">
                        <!-- Title and Status -->
                        <div class="flex items-start justify-between mb-4">
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2" title="{{ $item->nama_iklan }}">
                                {{ $item->nama_iklan }}
                            </h3>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            <p class="text-gray-600 text-sm leading-relaxed line-clamp-3" title="{{ $item->keterangan }}">
                                {{ Str::limit($item->keterangan ?? 'Tiada keterangan', 120) }}
                            </p>
                        </div>

                        <!-- AI Toggle -->
                        <div class="flex items-center justify-between mb-6 p-4 bg-gradient-to-r from-purple-50 to-pink-50 rounded-2xl border border-purple-100">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-xs"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-900">AI Status</p>
                                    <p class="text-xs text-gray-600">Pengurusan automatik</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:change="updateOn({{ $item->id }})"
                                    class="sr-only peer" {{ $item->on ? 'checked' : '' }}>
                                <div class="w-12 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-purple-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-purple-500 peer-checked:to-pink-600"></div>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3">
                            <a href="{{ route('iklan.show', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-4 py-3 text-sm font-bold text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 rounded-2xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 shadow-sm hover:shadow-md border-2 border-blue-200 hover:border-blue-300 transform hover:scale-105">
                                <i class="fas fa-eye mr-2"></i>
                                Lihat
                            </a>
                            <a href="{{ route('iklan.edit', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-4 py-3 text-sm font-bold text-indigo-700 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-2xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-300 shadow-sm hover:shadow-md border-2 border-indigo-200 hover:border-indigo-300 transform hover:scale-105">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                            <button wire:click="delete({{ $item->id }})"
                                wire:confirm="Adakah anda pasti mahu memadamkan iklan ini?"
                                class="inline-flex items-center justify-center px-4 py-3 text-sm font-bold text-red-700 bg-gradient-to-r from-red-50 to-red-100 rounded-2xl hover:from-red-100 hover:to-red-200 transition-all duration-300 shadow-sm hover:shadow-md border-2 border-red-200 hover:border-red-300 transform hover:scale-105">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>

                        <!-- Created Date -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <div class="flex items-center text-xs text-gray-500">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                <span>Dicipta: {{ $item->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="p-16 text-center">
                            <div class="w-32 h-32 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-8 shadow-lg">
                                <i class="fas fa-ad text-blue-500 text-5xl"></i>
                            </div>
                            <h3 class="text-3xl font-bold text-gray-900 mb-4">Tiada Iklan Dijumpai</h3>
                            <p class="text-gray-600 text-lg mb-8 max-w-md mx-auto">Mula cipta iklan pertama anda dengan teknologi AI terkini untuk pengurusan yang lebih efektif</p>
                            <a href="{{ route('iklan.create') }}"
                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                                <i class="fas fa-plus mr-3 text-lg"></i>
                                Cipta Iklan Pertama Anda
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($iklan->hasPages())
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
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
