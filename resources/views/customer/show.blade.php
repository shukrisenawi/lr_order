@extends('layouts.app')

@section('title', 'View Prospect')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Customer</h1>
                    <p class="text-gray-600">Maklumat terperinci untuk {{ $customer->nama_penerima }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('customer.edit', $customer) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    @if(request('from') === 'ai')
                        <a href="{{ route('ai') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-purple-500 to-purple-700 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-purple-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke AI Approval
                        </a>
                    @else
                        <a href="{{ route('customer.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali ke Senarai
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Prospect Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Customer</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Penerima</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $customer->nama_penerima }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $customer->alamat ?? '-' }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nama / Gelaran</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customer->gelaran)
                                <p class="text-gray-900">{{ $customer->gelaran }}</p>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">No Tel</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customer->no_tel)
                                <p class="text-gray-900">{{ $customer->no_tel }}</p>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>
                    </div>

                    <!-- Business -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customer->poskod)
                                <p class="text-gray-900 font-medium">{{ $customer->poskod }}</p>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Catatan</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customer->catatan)
                                <p class="text-gray-900 font-medium">{{ $customer->catatan }}</p>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Email</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($customer->email)
                                <p class="text-gray-900 font-medium">{{ $customer->email }}</p>
                            @else
                                <p class="text-gray-500">-</p>
                            @endif
                        </div>
                    </div>
                    <!-- Created Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Dicipta</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                {{ $customer->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Updated Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Kemaskini</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-check text-gray-500 mr-2"></i>
                                {{ $customer->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        <div class="mt-8 grid grid-cols-1 gap-8">
            <!-- Contact Actions -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Tindakan Pantas</h3>
                </div>
                <div class="p-6">
                    <div class="flex justify-evenly gap-10 space-y-4">
                        <a href="{{ route('invoice.create', ['customer_id' => $customer->id]) }}"
                            class="flex w-full items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-shopping-cart text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium text-gray-900">Cipta Invoice</h4>
                            </div>
                            <div class="ml-auto text-gray-400">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>

                        <a href="{{ route('tracking.create', ['customer_id' => $customer->id]) }}"
                            class="flex items-center w-full p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center group-hover:bg-yellow-200 transition-colors">
                                <i class="fas fa-list text-yellow-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium text-gray-900">Cipta Tracking</h4>
                            </div>
                            <div class="ml-auto text-gray-400">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>

                        <a href="https://wa.me/6{{ preg_replace('/[^0-9]/', '', $customer->no_tel) }}" target="_blank"
                            class="flex items-center w-full p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium text-gray-900">WhatsApp</h4>
                            </div>
                            <div class="ml-auto text-gray-400">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->

        </div>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            @if(request('from') === 'ai')
                <a href="{{ route('ai') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-purple-300 text-purple-700 font-medium rounded-xl hover:bg-purple-50 transition-colors duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke AI Approval
                </a>
            @else
                <a href="{{ route('customer.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Kembali
                </a>
            @endif
            <a href="{{ route('customer.edit', $customer) }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                <i class="fas fa-edit mr-2"></i>
                Edit Customer
            </a>
            <form method="POST" action="{{ route('customer.destroy', $customer) }}" class="inline"
                onsubmit="return confirm('Adakah anda pasti mahu memadamkan customer ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-trash mr-2"></i>
                    Padam Customer
                </button>
            </form>
        </div>
    </div>
@endsection
