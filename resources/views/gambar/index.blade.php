@extends('layouts.app')

@section('title', 'Galeri Gambar')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-light text-gray-800 mb-2">Galeri Gambar</h1>
                    <p class="text-gray-500">Urus koleksi gambar anda</p>
                </div>
                <a href="{{ route('gambar.create') }}" class="px-4 py-2 bg-gray-800 text-white hover:bg-gray-900">
                    Muat Naik Gambar Baru
                </a>
            </div>
        </div>

        <!-- Images Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($gambar as $item)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Image -->
                    <div class="aspect-w-16 aspect-h-9">
                        @if ($item->path)
                            <img src="{{ asset('storage/' . $item->path) }}" alt="{{ $item->title ?? 'Image' }}"
                                class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $item->title ?? 'Untitled' }}</h3>
                        <p class="text-gray-600 text-sm mb-3">{{ Str::limit($item->description ?? 'No description', 100) }}
                        </p>

                        <!-- Actions -->
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ $item->created_at->format('d/m/Y') }}</span>
                            <div class="flex space-x-2">
                                <a href="{{ route('gambar.show', $item) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('gambar.edit', $item) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('gambar.destroy', $item) }}" class="inline"
                                    onsubmit="return confirm('Are you sure you want to delete this image?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-lg shadow p-12 text-center">
                        <i class="fas fa-images text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No images found</h3>
                        <p class="text-gray-600 mb-4">Get started by uploading your first image.</p>
                        <a href="{{ route('gambar.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-plus mr-2"></i>
                            Upload Image
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (isset($gambar) && $gambar->hasPages())
            <div class="mt-6">
                {{ $gambar->links() }}
            </div>
        @endif
    @endsection
