@extends('layouts.app')

@section('title', 'Butiran Tracking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Butiran Tracking</h1>
                <p class="text-gray-600">Maklumat lengkap penghantaran dan tracking</p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-hashtag mr-1"></i>
                        ID: {{ $tracking->id }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($tracking->kurier === 'J&T') bg-green-100 text-green-800
                        @elseif($tracking->kurier === 'PosLaju') bg-blue-100 text-blue-800
                        @elseif($tracking->kurier === 'DHL') bg-orange-100 text-orange-800
                        @else bg-gray-100 text-gray-800 @endif">
                        <i class="fas fa-truck mr-1"></i>
                        {{ $tracking->kurier ?? 'J&T' }}
                    </span>
                </div>
            </div>
            <div class="flex gap-4">
                <button onclick="createShipment({{ $tracking->id }})"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-xl shadow-lg hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-shipping-fast mr-2"></i>
                    Buat Shipment
                </button>
                <a href="{{ route('tracking.edit', $tracking) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('tracking.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Tracking Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-info-circle mr-3"></i>
                    Maklumat Tracking
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Tracking ID</dt>
                        <dd class="text-sm font-medium text-gray-900">#{{ $tracking->id }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Kurier</dt>
                        <dd class="text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                @if($tracking->kurier === 'J&T') bg-green-100 text-green-800
                                @elseif($tracking->kurier === 'PosLaju') bg-blue-100 text-blue-800
                                @elseif($tracking->kurier === 'DHL') bg-orange-100 text-orange-800
                                @else bg-gray-100 text-gray-800 @endif">
                                <i class="fas fa-truck mr-1"></i>
                                {{ $tracking->kurier ?? 'J&T' }}
                            </span>
                        </dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Tarikh Dibuat</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    @if($tracking->invoice)
                    <div class="flex justify-between items-center py-3">
                        <dt class="text-sm font-semibold text-gray-600">Invoice Berkaitan</dt>
                        <dd class="text-sm">
                            <a href="{{ route('invoice.show', $tracking->invoice) }}"
                               class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 transition-colors">
                                <i class="fas fa-external-link-alt mr-1"></i>
                                Invoice #{{ $tracking->invoice->id }}
                            </a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>

        <!-- Recipient Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-3"></i>
                    Maklumat Penerima
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Nama Penerima</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->nama_penerima }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Nombor Telefon</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->no_tel }}</dd>
                    </div>
                    <div class="py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600 mb-2">Alamat</dt>
                        <dd class="text-sm text-gray-900">{{ $tracking->alamat }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <dt class="text-sm font-semibold text-gray-600">Poskod</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->poskod }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Parcel Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-box mr-3"></i>
                    Maklumat Parcel
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Kandungan Parcel</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->kandungan_parcel ?: '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Jenis Parcel</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->jenis_parcel ?: '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Berat</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $tracking->berat ? $tracking->berat . ' kg' : '-' }}</dd>
                    </div>
                    <div class="py-3">
                        <dt class="text-sm font-semibold text-gray-600 mb-2">Dimensi (P x L x T)</dt>
                        <dd class="text-sm font-medium text-gray-900">
                            {{ $tracking->panjang ? $tracking->panjang . ' x ' . $tracking->lebar . ' x ' . $tracking->tinggi . ' cm' : '-' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Tracking Status -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-route mr-3"></i>
                    Status Tracking
                </h2>
            </div>
            <div class="p-6">
                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-lg"></i>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-semibold text-gray-900">Pesanan Dibuat</p>
                            <p class="text-sm text-gray-500">{{ $tracking->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Placeholder for tracking updates -->
                    <div class="text-center py-8 bg-gray-50 rounded-xl">
                        <div class="bg-gray-100 rounded-full p-3 w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-clock text-gray-400 text-xl"></i>
                        </div>
                        <h3 class="text-sm font-medium text-gray-900 mb-1">Kemas Kini Tracking</h3>
                        <p class="text-sm text-gray-500 mb-4">Kemas kini tracking akan muncul di sini</p>
                        <button onclick="checkTracking()"
                                class="inline-flex items-center px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-lg transition-colors">
                            <i class="fas fa-sync-alt mr-2"></i>
                            Semak Status Terkini
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-red-500 to-red-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-exclamation-triangle mr-3"></i>
                Zon Bahaya
            </h2>
        </div>
        <div class="p-6">
            <div class="flex items-start space-x-4">
                <div class="flex-shrink-0">
                    <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center">
                        <i class="fas fa-trash-alt text-red-600 text-lg"></i>
                    </div>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Padam Rekod Tracking</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Sekali anda memadam rekod tracking ini, tidak boleh dikembalikan. Sila pastikan tindakan anda.
                    </p>
                    <form method="POST" action="{{ route('tracking.destroy', $tracking) }}"
                          onsubmit="return confirm('Adakah anda pasti mahu memadam rekod tracking ini?')" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-trash mr-2"></i>
                            Padam Rekod Tracking
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
