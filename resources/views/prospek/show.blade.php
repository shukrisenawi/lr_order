@extends('layouts.app')

@section('title', 'View Prospect')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">View Prospect</h1>
                <p class="text-gray-600">Prospect details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('prospek.edit', $prospek) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('prospek.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Prospect Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Prospect Information</h3>
        </div>
        
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Telefon</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $prospek->no_tel }}</p>
                </div>

                <!-- Title/Greeting -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gelaran</label>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        {{ $prospek->gelaran }}
                    </span>
                </div>

                <!-- Business -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business</label>
                    <div class="bg-gray-50 px-3 py-2 rounded-lg">
                        @if($prospek->bisnes)
                            <p class="text-gray-900 font-medium">{{ $prospek->bisnes->nama_bines }}</p>
                            <p class="text-gray-600 text-sm">{{ $prospek->bisnes->nama_syarikat }}</p>
                            <p class="text-gray-500 text-xs">{{ $prospek->bisnes->jenis_bisnes }}</p>
                        @else
                            <p class="text-gray-500">No business assigned</p>
                        @endif
                    </div>
                </div>

                <!-- Created Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Created Date</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $prospek->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <!-- Updated Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Updated</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        {{ $prospek->updated_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Related Information -->
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Contact Actions -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
            </div>
            <div class="p-6">
                <div class="space-y-3">
                    <a href="tel:{{ $prospek->no_tel }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                        <i class="fas fa-phone text-green-600 mr-3"></i>
                        <span class="text-green-700 font-medium">Call {{ $prospek->no_tel }}</span>
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $prospek->no_tel) }}" target="_blank" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                        <i class="fab fa-whatsapp text-green-600 mr-3"></i>
                        <span class="text-green-700 font-medium">WhatsApp</span>
                    </a>
                    <a href="sms:{{ $prospek->no_tel }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                        <i class="fas fa-sms text-blue-600 mr-3"></i>
                        <span class="text-blue-700 font-medium">Send SMS</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Statistics</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Purchases:</span>
                        <span class="font-semibold">0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Spent:</span>
                        <span class="font-semibold">RM 0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Last Contact:</span>
                        <span class="font-semibold">{{ $prospek->updated_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('prospek.edit', $prospek) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Prospect
        </a>
        <form method="POST" action="{{ route('prospek.destroy', $prospek) }}" class="inline" 
              onsubmit="return confirm('Are you sure you want to delete this prospect?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Delete Prospect
            </button>
        </form>
    </div>
@endsection
