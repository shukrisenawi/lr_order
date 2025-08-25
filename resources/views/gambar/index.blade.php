@extends('layouts.app')

@section('title', 'Galeri Gambar')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Galeri Gambar</h1>
                    <p class="text-gray-600">Urus koleksi gambar anda</p>
                </div>
                <a href="{{ route('gambar.create') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i>
                    Muat Naik Gambar Baru
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Images Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($gambar as $item)
                <div
                    class="bg-white rounded-2xl shadow-xl overflow-hidden transform transition-all duration-300 hover:scale-105">
                    <!-- Image -->
                    <div class="aspect-w-16 aspect-h-9">
                        @if ($item->path)
                            <img src="{{ \App\Helpers\ImageHelper::galleryImageUrl($item->path) }}"
                                alt="{{ $item->nama ?? 'Gambar' }}" class="w-full h-48 object-cover">
                        @else
                            <div
                                class="w-full h-48 bg-gradient-to-br from-purple-100 to-indigo-100 flex items-center justify-center">
                                <i class="fas fa-image text-purple-400 text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-5">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2 truncate">{{ $item->nama ?? 'Tanpa Tajuk' }}
                        </h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ Str::limit($item->description ?? 'Tiada keterangan', 100) }}</p>

                        <!-- Actions -->
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ $item->created_at->format('d/m/Y') }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('gambar.show', $item) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-purple-700 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200"
                                    title="Lihat">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>
                                <a href="{{ route('gambar.edit', $item) }}"
                                    class="inline-flex items-center justify-center w-8 h-8 text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200"
                                    title="Edit">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <form method="POST" action="{{ route('gambar.destroy', $item) }}" class="inline"
                                    onsubmit="return confirm('Adakah anda pasti mahu memadamkan gambar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center justify-center w-8 h-8 text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200"
                                        title="Padam">
                                        <i class="fas fa-trash text-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                        <div class="bg-gray-100 rounded-full p-4 inline-flex mb-6">
                            <i class="fas fa-images text-gray-400 text-4xl"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Tiada gambar dijumpai</h3>
                        <p class="text-gray-600 mb-6">Mulakan dengan memuat naik gambar pertama anda.</p>
                        <a href="{{ route('gambar.create') }}"
                            class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-300">
                            <i class="fas fa-plus mr-2"></i>
                            Muat Naik Gambar
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (isset($gambar) && $gambar->hasPages())
            <div class="mt-10">
                <div class="flex items-center justify-between bg-white rounded-2xl shadow-sm px-6 py-4">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $gambar->firstItem() }}</span> ke <span
                            class="font-medium">{{ $gambar->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $gambar->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $gambar->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
