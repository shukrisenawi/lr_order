@extends('layouts.app')

@section('title', 'View Image')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">View Image</h1>
                <p class="text-gray-600">Image details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('gambar.edit', $gambar) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('gambar.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Gallery
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Image Display -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Image</h3>
            </div>
            <div class="p-6">
                @if($gambar->path)
                    <img src="{{ asset('storage/' . $gambar->path) }}" alt="{{ $gambar->title }}" 
                         class="w-full h-auto rounded-lg border border-gray-300">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-6xl"></i>
                    </div>
                @endif
            </div>
        </div>

        <!-- Image Details -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Image Information</h3>
            </div>
            
            <div class="p-6">
                <div class="space-y-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $gambar->title ?? 'Untitled' }}</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $gambar->description ?? 'No description' }}</p>
                    </div>

                    <!-- Alt Text -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alt Text</label>
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $gambar->alt_text ?? 'No alt text' }}</p>
                    </div>

                    <!-- File Info -->
                    @if($gambar->path)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">File Path</label>
                            <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg font-mono text-sm">{{ $gambar->path }}</p>
                        </div>
                    @endif

                    <!-- Created Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                            {{ $gambar->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Updated Date -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                            {{ $gambar->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('gambar.edit', $gambar) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Image
        </a>
        <form method="POST" action="{{ route('gambar.destroy', $gambar) }}" class="inline" 
              onsubmit="return confirm('Are you sure you want to delete this image?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Delete Image
            </button>
        </form>
    </div>
@endsection
