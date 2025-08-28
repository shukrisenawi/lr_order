<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Iklan</h1>
                <p class="text-gray-600">Urus iklan anda</p>
            </div>
            <a href="{{ route('iklan.create') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-medium rounded-xl shadow-lg hover:from-emerald-600 hover:to-teal-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
                <i class="fas fa-plus mr-2"></i>
                Tambah Iklan Baru
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
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari iklan..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>
    <div class="flex flex-wrap items-center justify-between mb-4 gap-5">
        @forelse($iklan as $item)
            <div class="card w-96 bg-base-100 shadow-sm">
                <div class="card-body">

                    <div class="flex justify-between">
                        <h4 class="text-2xl font-bold">{{ $item->nama_iklan }}</h4>
                        <span class="text-xl font-bold text-green-800">{{ $item->hari }}</span>
                    </div>
                    {{ $item->keterangan }}
                    <div class="flex justify-between items-center mt-4 gap-3">
                        <div>
                            <input type="checkbox" wire:change="updateOn({{ $item->id }})"
                                class="toggle toggle-sm toggle-success" {{ $item->on ? 'checked' : '' }}>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('iklan.edit', $item) }}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-teal-700 bg-teal-50 rounded-lg hover:bg-teal-100 transition-colors duration-200">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <button wire:click="delete({{ $item->id }})"
                                wire:confirm="Adakah anda pasti mahu memadamkan iklan ini?"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                <i class="fas fa-trash mr-1"></i>
                                Padam
                            </button>
                        </div>

                        {{-- <a href="{{ route('iklan.show', $item) }}"
                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-emerald-700 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors duration-200">
                            <i class="fas fa-eye mr-1"></i>
                            Lihat
                        </a> --}}

                    </div>
                </div>
            </div>

        @empty
            <div>Tiada Iklan</div>
        @endforelse
    </div>
</div>
