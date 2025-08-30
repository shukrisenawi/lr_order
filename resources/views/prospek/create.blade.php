@extends('layouts.app')

@section('title', 'Tambah Prospek Baru')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-user-plus text-amber-500 mr-3"></i>
                        Tambah Prospek Baru
                    </h1>
                    <p class="text-gray-600">Cipta prospek baru untuk sistem anda</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-amber-100 to-orange-100 text-amber-800 border border-amber-200">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Tip: Pastikan nombor telefon adalah aktif
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('ai') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-robot mr-1"></i>
                        AI Approval
                    </a>
                    <a href="{{ route('prospek.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-amber-50 to-orange-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-amber-500 to-orange-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user-plus text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">Maklumat Prospek</h3>
                        <p class="text-gray-600 text-sm mt-1">Sila isi semua maklumat yang diperlukan untuk mencipta prospek baru</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('prospek.store') }}" class="p-6">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left Column - Main Information -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- No Telefon -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-phone text-green-500 mr-2"></i>
                                No. Telefon
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-mobile-alt text-gray-400"></i>
                                </div>
                                <input type="text" name="no_tel" value="{{ old('no_tel') }}" required
                                    placeholder="Contoh: 012-3456789"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-300 text-lg @error('no_tel') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('no_tel')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Gelaran -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-user-tag text-blue-500 mr-2"></i>
                                Nama/Gelaran
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" name="gelaran" value="{{ old('gelaran') }}"
                                    placeholder="Contoh: Encik Ahmad, Puan Siti"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 text-lg @error('gelaran') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('gelaran')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Session ID -->
                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-key text-purple-500 mr-2"></i>
                                Session ID
                                <span class="text-gray-500 text-xs ml-2">(Pilihan)</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                </div>
                                <input type="text" name="session_id" value="{{ old('session_id') }}"
                                    placeholder="ID sesi WhatsApp (jika ada)"
                                    class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 text-lg @error('session_id') border-red-500 bg-red-50 @enderror">
                            </div>
                            @error('session_id')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column - Settings & Info -->
                    <div class="space-y-6">
                        <!-- AI Settings Card -->
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-xl p-6 border border-indigo-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-robot text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">AI Integration</h4>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="on" value="1" {{ old('on') ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-3 text-sm text-gray-700">Aktifkan AI untuk prospek ini</span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">AI akan membantu dalam komunikasi automatik</p>
                                </div>
                            </div>
                        </div>

                        <!-- Information Card -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">Maklumat</h4>
                            </div>

                            <div class="space-y-3 text-sm text-gray-600">
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <span>Nombor telefon akan digunakan untuk WhatsApp</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <span>Nama/gelaran untuk komunikasi yang lebih personal</span>
                                </div>
                                <div class="flex items-start">
                                    <i class="fas fa-check-circle text-green-500 mt-0.5 mr-2"></i>
                                    <span>Session ID untuk integrasi WhatsApp API</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                        <!-- Help Text -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                <i class="fas fa-question text-blue-600 text-xs"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">
                                    <strong>Tip:</strong> Pastikan semua maklumat adalah tepat untuk komunikasi yang berkesan
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('prospek.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-semibold rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-amber-200 focus:ring-offset-2 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Prospek
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Quick Stats -->
        <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Jumlah Prospek</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Prospek::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-robot text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">AI Enabled</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Prospek::where('on', true)->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-plus-circle text-white"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Baru Ditambah</p>
                        <p class="text-2xl font-bold text-gray-900">{{ \App\Models\Prospek::whereDate('created_at', today())->count() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
