@extends('layouts.app')

@section('title', 'View Prospect')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Prospek</h1>
                    <p class="text-gray-600">Maklumat terperinci untuk {{ $prospek->gelaran }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('prospek.edit', $prospek) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('prospek.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Prospect Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Prospek</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">No Telefon</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $prospek->no_tel }}</p>
                        </div>
                    </div>

                    <!-- Title/Greeting -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Gelaran</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                {{ $prospek->gelaran }}
                            </span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Emel</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($prospek->email)
                                <p class="text-gray-900">{{ $prospek->email }}</p>
                            @else
                                <p class="text-gray-500">Tiada emel</p>
                            @endif
                        </div>
                    </div>

                    <!-- Business -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Bisnes</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            @if ($prospek->bisnes)
                                <p class="text-gray-900 font-medium">{{ $prospek->bisnes->nama_bines }}</p>
                            @else
                                <p class="text-gray-500">Tiada bisnes</p>
                            @endif
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Dicipta</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                {{ $prospek->created_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>

                    <!-- Updated Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Kemaskini</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-check text-gray-500 mr-2"></i>
                                {{ $prospek->updated_at->format('d/m/Y H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Information -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Contact Actions -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Tindakan Pantas</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <a href="tel:{{ $prospek->no_tel }}"
                            class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                <i class="fas fa-phone text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium text-gray-900">Panggil</h4>
                                <p class="text-gray-600 text-sm">{{ $prospek->no_tel }}</p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>

                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $prospek->no_tel) }}" target="_blank"
                            class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center group-hover:bg-green-200 transition-colors">
                                <i class="fab fa-whatsapp text-green-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium text-gray-900">WhatsApp</h4>
                                <p class="text-gray-600 text-sm">Hantar mesej WhatsApp</p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>

                        <a href="sms:{{ $prospek->no_tel }}"
                            class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                                <i class="fas fa-sms text-blue-600 text-xl"></i>
                            </div>
                            <div class="ml-4">
                                <h4 class="font-medium text-gray-900">SMS</h4>
                                <p class="text-gray-600 text-sm">Hantar mesej teks</p>
                            </div>
                            <div class="ml-auto text-gray-400">
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Statistik</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-6">
                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-amber-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-shopping-cart text-amber-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-600 text-sm">Jumlah Pembelian</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-gray-900">0</span>
                        </div>

                        <div class="flex justify-between items-center pb-4 border-b border-gray-100">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-money-bill-wave text-emerald-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-600 text-sm">Jumlah Perbelanjaan</p>
                                </div>
                            </div>
                            <span class="text-2xl font-bold text-gray-900">RM 0.00</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                <div
                                    class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-check text-blue-600"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-600 text-sm">Hubungan Terakhir</p>
                                </div>
                            </div>
                            <span
                                class="text-lg font-medium text-gray-900">{{ $prospek->updated_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('prospek.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                Kembali
            </a>
            <a href="{{ route('prospek.edit', $prospek) }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                <i class="fas fa-edit mr-2"></i>
                Edit Prospek
            </a>
            <form method="POST" action="{{ route('prospek.destroy', $prospek) }}" class="inline"
                onsubmit="return confirm('Adakah anda pasti mahu memadamkan prospek ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-trash mr-2"></i>
                    Padam Prospek
                </button>
            </form>
        </div>
    </div>
@endsection
