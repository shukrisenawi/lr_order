<div class="w-full py-4 min-h-screen bg-gradient-to-br from-red-50 via-orange-50 via-yellow-50 via-green-50 via-blue-50 via-indigo-50 via-purple-50 to-pink-50">
        <!-- Header -->
        <div class="mb-4 text-center">
            <h1 class="text-3xl font-bold bg-gradient-to-r from-pink-500 via-red-500 to-yellow-500 bg-clip-text text-transparent mb-2">
                <i class="fas fa-bullhorn text-pink-500 mr-2"></i>
                Pengurusan Iklan Pintar
            </h1>
            <p class="text-gray-600 text-sm">Urus iklan anda dengan mudah</p>
            <a href="{{ route('iklan.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-pink-500 to-red-500 text-white font-medium rounded-lg shadow-md hover:from-pink-600 hover:to-red-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:ring-offset-2 transform hover:scale-105 mt-4">
                <i class="fas fa-plus mr-2"></i>
                Cipta Iklan Baru
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-4 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-lg shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                    <span class="text-sm">{{ session('message') }}</span>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div class="bg-gradient-to-br from-yellow-400 via-orange-500 to-red-500 rounded-lg p-4 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-yellow-100 text-sm font-semibold">Jumlah Iklan</p>
                        <p class="text-3xl font-bold mt-1">{{ $iklan->total() ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-ad text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-400 via-teal-500 to-blue-500 rounded-lg p-4 text-white shadow-lg transform hover:scale-105 transition-all duration-300">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-semibold">Aktif Sekarang</p>
                        <p class="text-3xl font-bold mt-1">{{ $iklan->where('on', 1)->count() ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-play-circle text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-4 text-center">
            <div class="relative inline-block">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-pink-400"></i>
                </div>
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari iklan..."
                    class="pl-10 pr-4 py-2 border border-pink-300 rounded-full bg-white focus:bg-white focus:border-pink-500 focus:ring-2 focus:ring-pink-100 focus:outline-none transition-all duration-300 shadow-sm w-80">
            </div>
        </div>
        <!-- Iklan Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            @forelse($iklan as $item)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden transform hover:scale-105 transition-all duration-300 hover:shadow-xl group" wire:key="iklan-{{ $item->id }}">
                    <!-- Card Header -->
                    <div class="relative">
                        <div class="h-20 bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-600 relative overflow-hidden">
                            <div class="absolute inset-0 bg-black/10"></div>
                            <div class="absolute top-2 right-2">
                                @if($item->on)
                                    <div class="w-6 h-6 bg-green-400 rounded-full flex items-center justify-center animate-pulse">
                                        <i class="fas fa-check text-white text-xs"></i>
                                    </div>
                                @else
                                    <div class="w-6 h-6 bg-gray-400 rounded-full flex items-center justify-center">
                                        <i class="fas fa-pause text-white text-xs"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="absolute bottom-2 left-3">
                                <span class="text-white font-bold text-sm">Hari {{ $item->hari }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="p-4">
                        <!-- Title -->
                        <h3 class="text-lg font-bold text-gray-900 mb-2 group-hover:text-purple-600 transition-colors" title="{{ $item->nama_iklan }}">
                            {{ $item->nama_iklan }}
                        </h3>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm leading-relaxed mb-4" title="{{ $item->keterangan }}">
                            {{ Str::limit($item->keterangan ?? 'Tiada keterangan', 100) }}
                        </p>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('iklan.show', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-cyan-500 rounded-lg hover:from-blue-600 hover:to-cyan-600 transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-105">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat
                            </a>
                            <a href="{{ route('iklan.edit', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-purple-500 to-pink-500 rounded-lg hover:from-purple-600 hover:to-pink-600 transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-105">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <button wire:click="delete({{ $item->id }})"
                                wire:confirm="Adakah anda pasti mahu memadamkan iklan ini?"
                                class="inline-flex items-center justify-center px-3 py-2 text-sm font-medium text-white bg-gradient-to-r from-red-500 to-orange-500 rounded-lg hover:from-red-600 hover:to-orange-600 transition-all duration-300 shadow-sm hover:shadow-md transform hover:scale-105">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full text-center py-12">
                    <div class="w-24 h-24 bg-gradient-to-r from-pink-400 to-yellow-400 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                        <i class="fas fa-ad text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold bg-gradient-to-r from-pink-600 to-yellow-600 bg-clip-text text-transparent mb-4">Tiada Iklan</h3>
                    <p class="text-gray-600 text-lg mb-6">Cipta iklan pertama anda sekarang!</p>
                    <a href="{{ route('iklan.create') }}"
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-pink-500 to-yellow-500 text-white font-medium rounded-lg shadow-md hover:from-pink-600 hover:to-yellow-600 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-pink-300 focus:ring-offset-2 transform hover:scale-105">
                        <i class="fas fa-plus mr-2"></i>
                        Cipta Iklan
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($iklan->hasPages())
            <div class="text-center py-4">
                <div class="inline-flex items-center gap-2 bg-white rounded-lg shadow-md p-2">
                    {{ $iklan->links('vendor.pagination.tailwind') }}
                </div>
            </div>
        @endif
</div>
