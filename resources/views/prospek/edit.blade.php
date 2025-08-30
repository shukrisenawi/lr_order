@extends('layouts.app')

@section('title', 'Kemaskini Prospek')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-edit text-indigo-500 mr-3"></i>
                        Kemaskini Prospek
                    </h1>
                    <p class="text-gray-600">Kemaskini maklumat prospek untuk {{ $prospek->gelaran ?: 'Prospek #' . $prospek->id }}</p>
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
                        @endif
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('ai') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-purple-100 hover:bg-purple-200 text-purple-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-robot mr-1"></i>
                        AI Approval
                    </a>
                    <a href="{{ route('prospek.show', $prospek) }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-eye mr-1"></i>
                        Lihat Detail
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
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">Kemaskini Maklumat Prospek</h3>
                        <p class="text-gray-600 text-sm mt-1">Kemaskini maklumat prospek dengan teliti untuk komunikasi yang berkesan</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('prospek.update', $prospek) }}" class="p-6">
                @csrf
                @method('PUT')

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
                                <input type="text" name="no_tel" value="{{ old('no_tel', $prospek->no_tel) }}" required
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
                                <input type="text" name="gelaran" value="{{ old('gelaran', $prospek->gelaran) }}"
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
                                <input type="text" name="session_id" value="{{ old('session_id', $prospek->session_id) }}"
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

                    <!-- Right Column - Settings & Status -->
                    <div class="space-y-6">
                        <!-- Current Status Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-info-circle text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">Status Semasa</h4>
                            </div>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">AI Status:</span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $prospek->on ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $prospek->on ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Dibuat:</span>
                                    <span class="text-gray-900 font-medium">{{ $prospek->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">Kemaskini:</span>
                                    <span class="text-gray-900 font-medium">{{ $prospek->updated_at->format('d/m/Y') }}</span>
                                </div>
                            </div>
                        </div>

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
                                        <input type="checkbox" name="on" value="1" {{ old('on', $prospek->on) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-3 text-sm text-gray-700">Aktifkan AI untuk prospek ini</span>
                                    </label>
                                    <p class="text-xs text-gray-500 mt-1 ml-6">AI akan membantu dalam komunikasi automatik</p>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions Card -->
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-bolt text-white text-sm"></i>
                                </div>
                                <h4 class="ml-3 text-sm font-semibold text-gray-900">Tindakan Pantas</h4>
                            </div>

                            <div class="space-y-3">
                                <a href="tel:{{ $prospek->no_tel }}"
                                    class="flex items-center p-3 bg-white hover:bg-green-100 rounded-lg transition-all duration-200 group">
                                    <i class="fas fa-phone text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-700 group-hover:text-green-800">Panggil</span>
                                </a>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $prospek->no_tel) }}" target="_blank"
                                    class="flex items-center p-3 bg-white hover:bg-green-100 rounded-lg transition-all duration-200 group">
                                    <i class="fab fa-whatsapp text-green-600 mr-3"></i>
                                    <span class="text-sm text-gray-700 group-hover:text-green-800">WhatsApp</span>
                                </a>
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
                                <i class="fas fa-lightbulb text-blue-600 text-xs"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-600">
                                    <strong>Tip:</strong> Perubahan akan disimpan dan boleh dilihat serta-merta dalam senarai prospek
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('prospek.show', $prospek) }}"
                                class="inline-flex items-center justify-center px-4 py-2 border-2 border-blue-300 text-blue-700 font-medium rounded-lg hover:bg-blue-50 transition-colors duration-200">
                                <i class="fas fa-eye mr-1"></i>
                                Lihat
                            </a>
                            <a href="{{ route('prospek.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:from-indigo-600 hover:to-purple-700 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-indigo-200 focus:ring-offset-2 transform hover:scale-105">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Perubahan
                                <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Change History -->
        <div class="mt-8 bg-gradient-to-r from-gray-50 to-slate-50 rounded-xl p-6 border border-gray-200">
            <div class="flex items-center mb-4">
                <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-gray-500 to-slate-600 rounded-lg flex items-center justify-center">
                    <i class="fas fa-history text-white text-sm"></i>
                </div>
                <div class="ml-3">
                    <h4 class="text-sm font-semibold text-gray-900">Maklumat Terakhir</h4>
                    <p class="text-xs text-gray-600">Maklumat terkini tentang prospek ini</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Dibuat pada:</span>
                    <span class="font-medium text-gray-900">{{ $prospek->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Kemaskini pada:</span>
                    <span class="font-medium text-gray-900">{{ $prospek->updated_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-600">Status AI:</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium
                        {{ $prospek->on ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $prospek->on ? 'Aktif' : 'Tidak Aktif' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
