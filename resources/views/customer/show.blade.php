@extends('layouts.app')

@section('title', 'Lihat Customer')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Butiran Customer</h1>
                <p class="text-gray-600">Maklumat lengkap untuk {{ $customer->nama_penerima }}</p>
                <div class="flex items-center gap-4 mt-3">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-hashtag mr-1"></i>
                        ID: {{ $customer->id }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                        <i class="fas fa-calendar mr-1"></i>
                        Dibuat: {{ $customer->created_at->format('d M Y') }}
                    </span>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('customer.edit', $customer) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                @if(request('from') === 'ai')
                    <a href="{{ route('ai') }}?tab={{ request('tab', 'customers') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-purple-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke AI Approval
                    </a>
                @else
                    <a href="{{ route('customer.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Information Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Customer Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-user mr-3"></i>
                    Maklumat Customer
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Nama Penerima</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->nama_penerima }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Nama/Gelaran</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->gelaran ?: '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">No Telefon</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->no_tel ?: '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Email</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->email ?: '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Poskod</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->poskod ?: '-' }}</dd>
                    </div>
                    <div class="py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600 mb-2">Alamat</dt>
                        <dd class="text-sm text-gray-900">{{ $customer->alamat ?: '-' }}</dd>
                    </div>
                    <div class="py-3">
                        <dt class="text-sm font-semibold text-gray-600 mb-2">Catatan</dt>
                        <dd class="text-sm text-gray-900">{{ $customer->catatan ?: '-' }}</dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Activity Information -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h2 class="text-xl font-semibold text-white flex items-center">
                    <i class="fas fa-clock mr-3"></i>
                    Maklumat Aktiviti
                </h2>
            </div>
            <div class="p-6">
                <dl class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Tarikh Dibuat</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->created_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-gray-100">
                        <dt class="text-sm font-semibold text-gray-600">Tarikh Kemaskini</dt>
                        <dd class="text-sm font-medium text-gray-900">{{ $customer->updated_at->format('d M Y H:i') }}</dd>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <dt class="text-sm font-semibold text-gray-600">Status</dt>
                        <dd class="text-sm">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>
                                Aktif
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-purple-500 to-purple-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-bolt mr-3"></i>
                Tindakan Pantas
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                    class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-300 group transform hover:scale-105">
                    <div class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                        <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-medium text-gray-900">Cipta Invoice</h4>
                        <p class="text-sm text-gray-600">Buat invoice baru untuk customer ini</p>
                    </div>
                    <div class="ml-auto text-gray-400 group-hover:text-blue-500 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                <a href="{{ route('tracking.create', ['customer_id' => $customer->id]) }}"
                    class="flex items-center p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition-all duration-300 group transform hover:scale-105">
                    <div class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                        <i class="fas fa-list text-yellow-600 text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-medium text-gray-900">Cipta Tracking</h4>
                        <p class="text-sm text-gray-600">Tambah maklumat tracking penghantaran</p>
                    </div>
                    <div class="ml-auto text-gray-400 group-hover:text-yellow-500 transition-colors">
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </a>

                @if($customer->no_tel)
                <a href="https://wa.me/6{{ preg_replace('/[^0-9]/', '', $customer->no_tel) }}" target="_blank"
                    class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all duration-300 group transform hover:scale-105">
                    <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                        <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                    </div>
                    <div class="ml-4 flex-1">
                        <h4 class="font-medium text-gray-900">WhatsApp</h4>
                        <p class="text-sm text-gray-600">Hubungi melalui WhatsApp</p>
                    </div>
                    <div class="ml-auto text-gray-400 group-hover:text-green-500 transition-colors">
                        <i class="fas fa-external-link-alt"></i>
                    </div>
                </a>
                @endif
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
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Padam Customer</h3>
                    <p class="text-sm text-gray-600 mb-6">
                        Sekali anda memadam customer ini, tidak boleh dikembalikan. Sila pastikan tindakan anda.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        @if(request('from') === 'ai')
                            <a href="{{ route('ai') }}?tab={{ request('tab', 'customers') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke AI Approval
                            </a>
                        @else
                            <a href="{{ route('customer.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Senarai
                            </a>
                        @endif
                        <a href="{{ route('customer.edit', $customer) }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            <i class="fas fa-edit mr-2"></i>
                            Edit Customer
                        </a>
                        <form method="POST" action="{{ route('customer.destroy', $customer) }}" class="inline"
                              onsubmit="return confirm('Adakah anda pasti mahu memadam customer ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                <i class="fas fa-trash mr-2"></i>
                                Padam Customer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
