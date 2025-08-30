@extends('layouts.app')

@section('title', 'Tracking Details')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Tracking Details</h1>
                <p class="text-gray-600">Shipment tracking information</p>
            </div>
            <div class="flex space-x-2">
                <button onclick="createShipment({{ $tracking->id }})" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-shipping-fast mr-2"></i>
                    Create Shipment
                </button>
                <a href="{{ route('tracking.edit', $tracking) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('tracking.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Tracking
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Tracking Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Tracking Information</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Tracking ID</dt>
                    <dd class="text-sm text-gray-900">#{{ $tracking->id }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Courier</dt>
                    <dd class="text-sm text-gray-900">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $tracking->kurier ?? 'J&T' }}
                        </span>
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Created Date</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->created_at->format('d/m/Y H:i') }}</dd>
                </div>
                @if($tracking->invoice)
                <div>
                    <dt class="text-sm font-medium text-gray-500">Related Invoice</dt>
                    <dd class="text-sm text-gray-900">
                        <a href="{{ route('invoice.show', $tracking->invoice) }}" class="text-blue-600 hover:text-blue-800">
                            Invoice #{{ $tracking->invoice->id }}
                        </a>
                    </dd>
                </div>
                @endif
            </dl>
        </div>

        <!-- Recipient Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recipient Information</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Recipient Name</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->nama_penerima }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->no_tel }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->alamat }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Postcode</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->poskod }}</dd>
                </div>
            </dl>
        </div>

        <!-- Parcel Information -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Parcel Information</h2>
            <dl class="space-y-3">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Parcel Content</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->kandungan_parcel ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Parcel Type</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->jenis_parcel ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Weight</dt>
                    <dd class="text-sm text-gray-900">{{ $tracking->berat ? $tracking->berat . ' kg' : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Dimensions (L x W x H)</dt>
                    <dd class="text-sm text-gray-900">
                        {{ $tracking->panjang ? $tracking->panjang . ' x ' . $tracking->lebar . ' x ' . $tracking->tinggi . ' cm' : '-' }}
                    </dd>
                </div>
            </dl>
        </div>

        <!-- Tracking Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Tracking Status</h2>
            <div class="space-y-4">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Order Created</p>
                        <p class="text-sm text-gray-500">{{ $tracking->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <!-- Placeholder for tracking updates -->
                <div class="text-center py-8">
                    <i class="fas fa-clock text-gray-400 text-2xl mb-2"></i>
                    <p class="text-sm text-gray-500">Tracking updates will appear here</p>
                    <button class="mt-2 text-blue-600 hover:text-blue-800 text-sm" onclick="checkTracking()">
                        Check Latest Status
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Form -->
    <div class="mt-6 bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 text-red-600">Danger Zone</h2>
        <p class="text-sm text-gray-600 mb-4">Once you delete this tracking record, there is no going back. Please be certain.</p>
        <form method="POST" action="{{ route('tracking.destroy', $tracking) }}"
              onsubmit="return confirm('Are you sure you want to delete this tracking record?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg">
                <i class="fas fa-trash mr-2"></i>
                Delete Tracking Record
            </button>
        </form>
    </div>
@endsection

<script>
function createShipment(trackingId) {
    if (confirm('Are you sure you want to create a shipment for this tracking record?')) {
        fetch(`/tracking/${trackingId}/create-shipment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Shipment created successfully!');
                location.reload();
            } else {
                alert('Failed to create shipment: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while creating the shipment.');
        });
    }
}

function checkTracking() {
    // Placeholder for tracking API call
    alert('Tracking status check functionality will be implemented with J&T Express API integration.');
}
</script>
