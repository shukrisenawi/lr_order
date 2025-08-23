@extends('layouts.app')

@section('title', 'View Prospect Address')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">View Address</h1>
                <p class="text-gray-600">Address details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('prospek-alamat.edit', $prospekAlamat) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('prospek-alamat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Address Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Address Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prospect Info -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Prospect</label>
                    <div class="bg-gray-50 px-3 py-2 rounded-lg">
                        @if($prospekAlamat->prospek)
                            <p class="text-gray-900 font-medium">{{ $prospekAlamat->prospek->gelaran }}</p>
                            <p class="text-gray-600 text-sm">{{ $prospekAlamat->prospek->no_tel }}</p>
                            @if($prospekAlamat->prospek->bisnes)
                                <p class="text-gray-500 text-xs">{{ $prospekAlamat->prospek->bisnes->nama_bines }}</p>
                            @endif
                        @else
                            <p class="text-gray-500">No prospect assigned</p>
                        @endif
                    </div>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekAlamat->alamat ?? 'N/A' }}</p>
                </div>

                <!-- City -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekAlamat->bandar ?? 'N/A' }}</p>
                </div>

                <!-- Postcode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Postcode</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekAlamat->poskod ?? 'N/A' }}</p>
                </div>

                <!-- State -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekAlamat->negeri ?? 'N/A' }}</p>
                </div>

                <!-- Country -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospekAlamat->negara ?? 'N/A' }}</p>
                </div>

                <!-- Created Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $prospekAlamat->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Updated Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $prospekAlamat->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Full Address Display -->
    <div class="mt-6 bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Complete Address</h3>
        </div>
        <div class="p-6">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-blue-900 font-medium">
                    {{ $prospekAlamat->alamat ?? 'N/A' }}<br>
                    {{ $prospekAlamat->poskod ?? '' }} {{ $prospekAlamat->bandar ?? '' }}<br>
                    {{ $prospekAlamat->negeri ?? '' }}<br>
                    {{ $prospekAlamat->negara ?? '' }}
                </p>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('prospek-alamat.edit', $prospekAlamat) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Address
        </a>
        <form method="POST" action="{{ route('prospek-alamat.destroy', $prospekAlamat) }}" class="inline" 
              onsubmit="return confirm('Are you sure you want to delete this address?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Delete Address
            </button>
        </form>
    </div>
@endsection
