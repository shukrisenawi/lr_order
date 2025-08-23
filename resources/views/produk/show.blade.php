@extends('layouts.app')

@section('title', 'View Product')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">View Product</h1>
                <p class="text-gray-600">Product details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('produk.edit', $produk) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('produk.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Product Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Product Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Product Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $produk->name ?? 'N/A' }}</p>
                </div>

                <!-- Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $produk->price ?? 'N/A' }}</p>
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $produk->description ?? 'N/A' }}</p>
                </div>

                <!-- Created Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $produk->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Updated Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $produk->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('produk.edit', $produk) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Product
        </a>
        <form method="POST" action="{{ route('produk.destroy', $produk) }}" class="inline" 
              onsubmit="return confirm('Are you sure you want to delete this product?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Delete Product
            </button>
        </form>
    </div>
@endsection
