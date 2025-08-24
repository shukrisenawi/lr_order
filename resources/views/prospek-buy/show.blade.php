@extends('layouts.app')

@section('title', 'View Purchase')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">View Purchase</h1>
                <p class="text-gray-600">Purchase details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('prospek-buy.edit', $prospekBuy) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('prospek-buy.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Purchase Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Purchase Information</h3>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prospect Info -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Customer</label>
                    <div class="bg-gray-50 px-3 py-2 rounded-lg">
                        @if ($prospekBuy->prospekAlamat && $prospekBuy->prospekAlamat->prospek)
                            <p class="text-gray-900 font-medium">{{ $prospekBuy->prospekAlamat->prospek->gelaran }}</p>
                            <p class="text-gray-600 text-sm">{{ $prospekBuy->prospekAlamat->prospek->no_tel }}</p>
                            @if ($prospekBuy->prospekAlamat->prospek->bisnes)
                                <p class="text-gray-500 text-xs">
                                    {{ $prospekBuy->prospekAlamat->prospek->bisnes->nama_bines }}</p>
                            @endif
                        @else
                            <p class="text-gray-500">No customer assigned</p>
                        @endif
                    </div>
                </div>

                <!-- Product Info -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product</label>
                    <div class="bg-gray-50 px-3 py-2 rounded-lg">
                        @if ($prospekBuy->produk)
                            <p class="text-gray-900 font-medium">{{ $prospekBuy->produk->name }}</p>
                            <p class="text-gray-600 text-sm">{{ $prospekBuy->produk->description ?? 'No description' }}</p>
                        @else
                            <p class="text-gray-500">No product assigned</p>
                        @endif
                    </div>
                </div>

                <!-- Quantity -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekBuy->kuantiti ?? 1 }}</p>
                </div>

                <!-- Unit Price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">RM
                        {{ number_format($prospekBuy->harga ?? 0, 2) }}</p>
                </div>

                <!-- Total Amount -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Total Amount</label>
                    <p class="text-gray-900 bg-green-50 px-3 py-2 rounded-lg font-bold text-lg">
                        RM {{ number_format(($prospekBuy->kuantiti ?? 1) * ($prospekBuy->harga ?? 0), 2) }}
                    </p>
                </div>

                <!-- Purchase Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Date</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ optional($prospekBuy->purchase_date)->format('d/m/Y') ?? 'N/A' }}
                    </p>
                </div>

                <!-- Notes -->
                @if ($prospekBuy->notes)
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                        <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekBuy->notes }}</p>
                    </div>
                @endif

                <!-- Created Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Record Created</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $prospekBuy->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Updated Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $prospekBuy->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchase Summary -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Purchase Summary</h3>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-blue-900">Product:</span>
                    <span class="font-medium text-blue-900">{{ $prospekBuy->produk->name ?? 'N/A' }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-blue-900">Quantity:</span>
                    <span class="font-medium text-blue-900">{{ $prospekBuy->kuantiti ?? 1 }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-blue-900">Unit Price:</span>
                    <span class="font-medium text-blue-900">RM {{ number_format($prospekBuy->harga ?? 0, 2) }}</span>
                </div>
                <hr class="border-blue-300 my-2">
                <div class="flex justify-between items-center">
                    <span class="text-blue-900 font-bold">Total:</span>
                    <span class="font-bold text-blue-900 text-xl">RM
                        {{ number_format(($prospekBuy->kuantiti ?? 1) * ($prospekBuy->harga ?? 0), 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('prospek-buy.edit', $prospekBuy) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Purchase
        </a>
        <form method="POST" action="{{ route('prospek-buy.destroy', $prospekBuy) }}" class="inline"
            onsubmit="return confirm('Are you sure you want to delete this purchase?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Delete Purchase
            </button>
        </form>
    </div>
@endsection
