@extends('layouts.app')

@section('title', 'AI Customer Data Generator')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-robot text-purple-500 mr-3"></i>
                        AI Customer Generator
                    </h1>
                    <p class="text-gray-600">Generate customer data automatically using AI</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-purple-100 to-indigo-100 text-purple-800 border border-purple-200">
                            <i class="fas fa-magic mr-2"></i>
                            AI Powered
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                            <i class="fas fa-brain mr-2"></i>
                            Smart Processing
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('customer.create') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-blue-100 hover:bg-blue-200 text-blue-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-plus mr-1"></i>
                        Manual Entry
                    </a>
                    <a href="{{ route('customer.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- How It Works Section -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-edit text-white text-xl"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-semibold text-gray-900">1. Input Data</h4>
                </div>
                <p class="text-gray-600 text-sm">Masukkan maklumat pelanggan dalam bentuk teks biasa</p>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-robot text-white text-xl"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-semibold text-gray-900">2. AI Processing</h4>
                </div>
                <p class="text-gray-600 text-sm">AI akan memproses dan menyusun data secara automatik</p>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-white text-xl"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-semibold text-gray-900">3. Ready to Use</h4>
                </div>
                <p class="text-gray-600 text-sm">Data pelanggan sedia untuk digunakan dalam sistem</p>
            </div>
        </div>

        <!-- Main Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-purple-50 to-pink-50">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-magic text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">Generate Customer Data</h3>
                        <p class="text-gray-600 text-sm mt-1">Masukkan maklumat pelanggan dalam bentuk teks untuk diproses oleh AI</p>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('customer.generate-data') }}" class="p-6">
                @csrf

                <!-- Input Section -->
                <div class="mb-8">
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-file-text text-purple-500 mr-2"></i>
                            Customer Information
                            <span class="text-red-500 ml-1">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute top-4 left-4 text-gray-400">
                                <i class="fas fa-quote-left text-2xl"></i>
                            </div>
                            <textarea name="text_alamat" rows="6"
                                placeholder="Contoh:
Nama: Ahmad bin Abdullah
Alamat: No. 123, Jalan Merdeka, Taman Bahagia, 43000 Kajang, Selangor
Telefon: 012-3456789

Atau masukkan dalam bentuk paragraph:
Pelanggan bernama Siti binti Hassan tinggal di No. 45 Jalan Sentosa Kuala Lumpur dengan nombor telefon 013-9876543"
                                class="w-full pl-12 pr-4 py-4 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 text-lg @error('text_alamat') border-red-500 bg-red-50 @enderror">{{ old('text_alamat') }}</textarea>
                            <div class="absolute bottom-4 right-4 text-gray-400">
                                <i class="fas fa-quote-right text-2xl"></i>
                            </div>
                        </div>
                        @error('text_alamat')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror

                        <!-- Help Text -->
                        <div class="mt-3 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center mt-0.5">
                                    <i class="fas fa-info text-blue-600 text-xs"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-800">
                                        <strong>Format yang disokong:</strong> AI boleh memproses pelbagai format teks termasuk nama, alamat, dan nombor telefon dalam bentuk semula jadi atau structured.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 pt-6 border-t border-gray-200">
                    <!-- Help Text -->
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center mt-0.5">
                            <i class="fas fa-lightbulb text-purple-600 text-xs"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-gray-600">
                                <strong>Tip:</strong> Semakin lengkap maklumat yang dimasukkan, semakin tepat hasil AI
                            </p>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3">
                        <a href="{{ route('customer.create') }}"
                            class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 hover:border-gray-400 transition-all duration-300">
                            <i class="fas fa-edit mr-2"></i>
                            Manual Entry
                        </a>
                        <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-purple-500 to-pink-600 text-white font-semibold rounded-xl shadow-lg hover:from-purple-600 hover:to-pink-700 hover:shadow-xl transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-purple-200 focus:ring-offset-2 transform hover:scale-105">
                            <i class="fas fa-magic mr-2"></i>
                            Generate with AI
                            <i class="fas fa-robot ml-2"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Features Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 rounded-xl p-6 border border-indigo-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-indigo-500 to-blue-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-brain text-white text-sm"></i>
                    </div>
                    <h4 class="ml-3 text-sm font-semibold text-gray-900">AI-Powered Processing</h4>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Automatic data extraction
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Smart format recognition
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Error correction
                    </li>
                </ul>
            </div>

            <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                <div class="flex items-center mb-4">
                    <div class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-white text-sm"></i>
                    </div>
                    <h4 class="ml-3 text-sm font-semibold text-gray-900">Time Saving</h4>
                </div>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Instant data processing
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        No manual data entry
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-check text-green-500 mr-2"></i>
                        Reduced errors
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
