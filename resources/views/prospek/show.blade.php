@extends('layouts.app')

@section('title', 'Lihat Prospek - ' . ($prospek->gelaran ?: 'Prospek #' . $prospek->id))

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-eye text-blue-500 mr-3"></i>
                        Lihat Prospek
                    </h1>
                    <p class="text-gray-600">Maklumat terperinci untuk {{ $prospek->gelaran ?: 'Prospek #' . $prospek->id }}</p>
                    <div class="flex items-center gap-4 mt-4">
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            <i class="fas fa-hashtag mr-2"></i>
                            ID: {{ $prospek->id }}
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                            <i class="fas fa-phone mr-2"></i>
                            {{ $prospek->no_tel }}
                        </span>
                        <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200">
                            <i class="fas fa-calendar mr-2"></i>
                            Dibuat: {{ $prospek->created_at->format('d M Y') }}
                        </span>
                        @if($prospek->on)
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-800 border border-indigo-200">
                                <i class="fas fa-robot mr-2"></i>
                                AI Enabled
                            </span>
                        @else
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200">
                                <i class="fas fa-robot mr-2"></i>
                                AI Disabled
                            </span>
                        @endif
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('ai') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-robot mr-1"></i>
                        AI Approval
                    </a>
                    <a href="{{ route('prospek.edit', $prospek) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Prospek
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
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">Maklumat Prospek</h3>
                        <p class="text-gray-600 text-sm mt-1">Maklumat lengkap dan terkini untuk prospek ini</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Primary Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Phone Number -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-phone text-green-500 mr-2"></i>
                                No. Telefon
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-mobile-alt text-gray-400"></i>
                                </div>
                                <div class="pl-12 pr-4 py-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl">
                                    <p class="text-gray-900 font-medium text-lg">{{ $prospek->no_tel }}</p>
                                    <p class="text-gray-500 text-sm mt-1">Nombor telefon utama</p>
                                </div>
                            </div>
                        </div>

                        <!-- Title/Greeting -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-tag text-blue-500 mr-2"></i>
                                Nama/Gelaran
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <div class="pl-12 pr-4 py-4 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl">
                                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 border border-amber-200">
                                        <i class="fas fa-tag mr-2"></i>
                                        {{ $prospek->gelaran ?: 'Tidak dinyatakan' }}
                                    </span>
                                    <p class="text-gray-500 text-sm mt-2">Gelaran untuk komunikasi</p>
                                </div>
                            </div>
                        </div>

                        <!-- Session ID -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-key text-purple-500 mr-2"></i>
                                Session ID
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                </div>
                                <div class="pl-12 pr-4 py-4 bg-gradient-to-r from-purple-50 to-pink-50 border border-purple-200 rounded-xl">
                                    <p class="text-gray-900 font-medium">{{ $prospek->session_id ?: 'Tidak dinyatakan' }}</p>
                                    <p class="text-gray-500 text-sm mt-1">ID sesi WhatsApp</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column - Additional Information -->
                    <div class="space-y-6">
                        <!-- Business Information -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-building text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">Maklumat Bisnes</h4>
                            </div>

                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Bisnes</p>
                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        {{ $prospek->bisnes ? $prospek->bisnes->nama_bines : 'Tidak dinyatakan' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-600 uppercase tracking-wide">Status</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 mt-1">
                                        Active
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline Information -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">Maklumat Tarikh</h4>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-plus text-green-600 mr-3"></i>
                                    <div>
                                        <p class="text-xs text-gray-600">Dibuat pada</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $prospek->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar-check text-blue-600 mr-3"></i>
                                    <div>
                                        <p class="text-xs text-gray-600">Kemaskini pada</p>
                                        <p class="text-sm font-medium text-gray-900">{{ $prospek->updated_at->format('d M Y, H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- AI Status -->
                        <div class="bg-gradient-to-br from-{{ $prospek->on ? 'indigo' : 'gray' }}-50 to-{{ $prospek->on ? 'purple' : 'slate' }}-50 rounded-xl p-6 border border-{{ $prospek->on ? 'indigo' : 'gray' }}-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-{{ $prospek->on ? 'indigo' : 'gray' }}-500 to-{{ $prospek->on ? 'purple' : 'slate' }}-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">AI Integration</h4>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Status AI:</span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                    {{ $prospek->on ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $prospek->on ? 'Aktif' : 'Tidak Aktif' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Actions & Statistics -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Actions -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-phone text-white"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-xl font-semibold text-gray-900">Tindakan Komunikasi</h3>
                                <p class="text-gray-600 text-sm mt-1">Hubungi prospek melalui pelbagai saluran</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <a href="tel:{{ $prospek->no_tel }}"
                                class="flex items-center p-5 bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-xl transition-all duration-300 group border border-green-200">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-phone text-white text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-green-800">Panggilan Telefon</h4>
                                    <p class="text-gray-600 text-sm">{{ $prospek->no_tel }}</p>
                                    <p class="text-xs text-green-600 mt-1">Klik untuk panggil</p>
                                </div>
                                <div class="text-green-400 group-hover:text-green-600">
                                    <i class="fas fa-arrow-right text-lg"></i>
                                </div>
                            </a>

                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $prospek->no_tel) }}" target="_blank"
                                class="flex items-center p-5 bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-xl transition-all duration-300 group border border-green-200">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fab fa-whatsapp text-white text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-green-800">WhatsApp</h4>
                                    <p class="text-gray-600 text-sm">Hantar mesej</p>
                                    <p class="text-xs text-green-600 mt-1">Buka WhatsApp</p>
                                </div>
                                <div class="text-green-400 group-hover:text-green-600">
                                    <i class="fas fa-external-link-alt text-lg"></i>
                                </div>
                            </a>

                            <a href="sms:{{ $prospek->no_tel }}"
                                class="flex items-center p-5 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 rounded-xl transition-all duration-300 group border border-blue-200">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                                    <i class="fas fa-sms text-white text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900 group-hover:text-blue-800">SMS</h4>
                                    <p class="text-gray-600 text-sm">Mesej teks</p>
                                    <p class="text-xs text-blue-600 mt-1">Buka aplikasi SMS</p>
                                </div>
                                <div class="text-blue-400 group-hover:text-blue-600">
                                    <i class="fas fa-arrow-right text-lg"></i>
                                </div>
                            </a>

                            <div class="flex items-center p-5 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl border border-purple-200">
                                <div class="flex-shrink-0 w-14 h-14 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-white text-xl"></i>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-900">Emel</h4>
                                    <p class="text-gray-600 text-sm">{{ $prospek->email ?: 'Tiada emel' }}</p>
                                    <p class="text-xs text-purple-600 mt-1">Tidak tersedia</p>
                                </div>
                                <div class="text-purple-400">
                                    <i class="fas fa-times text-lg"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics & Activity -->
            <div class="space-y-6">
                <!-- Statistics Card -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-chart-bar text-white text-sm"></i>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Statistik</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="text-center pb-4 border-b border-gray-100">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-amber-100 to-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-shopping-cart text-amber-600 text-xl"></i>
                                </div>
                                <p class="text-gray-600 text-sm">Jumlah Pembelian</p>
                                <span class="text-3xl font-bold text-gray-900 block mt-1">0</span>
                            </div>

                            <div class="text-center pb-4 border-b border-gray-100">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-emerald-100 to-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-money-bill-wave text-emerald-600 text-xl"></i>
                                </div>
                                <p class="text-gray-600 text-sm">Jumlah Perbelanjaan</p>
                                <span class="text-3xl font-bold text-gray-900 block mt-1">RM 0.00</span>
                            </div>

                            <div class="text-center">
                                <div class="flex-shrink-0 w-16 h-16 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                    <i class="fas fa-calendar-check text-blue-600 text-xl"></i>
                                </div>
                                <p class="text-gray-600 text-sm">Hubungan Terakhir</p>
                                <span class="text-lg font-medium text-gray-900 block mt-1">{{ $prospek->updated_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Activity Timeline -->
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-history text-white text-sm"></i>
                            </div>
                            <h3 class="ml-3 text-lg font-semibold text-gray-900">Aktiviti</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-plus text-green-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Prospek dicipta</p>
                                    <p class="text-xs text-gray-500">{{ $prospek->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-edit text-blue-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Kemaskini terakhir</p>
                                    <p class="text-xs text-gray-500">{{ $prospek->updated_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            @if($prospek->on)
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 bg-indigo-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-robot text-indigo-600 text-xs"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">AI diaktifkan</p>
                                        <p class="text-xs text-gray-500">Boleh menggunakan AI untuk komunikasi</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="mt-10">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-slate-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-gray-500 to-slate-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cogs text-white"></i>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-xl font-semibold text-gray-900">Tindakan</h3>
                            <p class="text-gray-600 text-sm mt-1">Pilih tindakan yang ingin dilakukan untuk prospek ini</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <!-- Help Text -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fas fa-info-circle text-blue-600 text-xs"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">
                                    <strong>Tip:</strong> Gunakan butang edit untuk mengemaskini maklumat prospek atau padam jika tidak diperlukan lagi
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('prospek.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Kembali ke Senarai
                            </a>
                            <a href="{{ route('prospek.edit', $prospek) }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:ring-offset-2 transform hover:scale-105">
                                <i class="fas fa-edit mr-2"></i>
                                Edit Prospek
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                            <form method="POST" action="{{ route('prospek.destroy', $prospek) }}" class="inline"
                                onsubmit="return confirm('Adakah anda pasti mahu memadamkan prospek ini? Operasi ini tidak boleh dibuat asal.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-red-200 focus:ring-offset-2 transform hover:scale-105">
                                    <i class="fas fa-trash mr-2"></i>
                                    Padam Prospek
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Related Records -->
            <div class="bg-gradient-to-r from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-link text-white text-sm"></i>
                    </div>
                    <h4 class="ml-3 text-sm font-semibold text-gray-900">Rekod Berkaitan</h4>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-indigo-200">
                        <span class="text-sm text-gray-600">Invoice</span>
                        <span class="text-sm font-medium text-gray-900">0</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-indigo-200">
                        <span class="text-sm text-gray-600">Tracking</span>
                        <span class="text-sm font-medium text-gray-900">0</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">Customer</span>
                        <span class="text-sm font-medium text-gray-900">0</span>
                    </div>
                </div>
            </div>

            <!-- System Information -->
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-server text-white text-sm"></i>
                    </div>
                    <h4 class="ml-3 text-sm font-semibold text-gray-900">Maklumat Sistem</h4>
                </div>

                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-green-200">
                        <span class="text-sm text-gray-600">ID Sistem</span>
                        <span class="text-sm font-medium text-gray-900 font-mono">{{ $prospek->id }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-green-200">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Active
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-sm text-gray-600">AI Status</span>
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                            {{ $prospek->on ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $prospek->on ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
