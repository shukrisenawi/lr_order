@extends('layouts.app')

@section('title', 'Tetapan')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-light text-gray-800 mb-2">Tetapan</h1>
            <p class="text-gray-500">Urus tetapan sistem dan API</p>
        </div>

        <!-- Settings Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- J&T Express API -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-truck text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">J&T Express API</h3>
                        <p class="text-sm text-gray-500">Integrasi penghantaran</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Konfigurasi dan uji coba integrasi API J&T Express.</p>
                <a href="{{ route('settings.jt-express') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    <i class="fas fa-cog mr-2"></i>
                    Konfigurasi J&T Express
                </a>
            </div>

            <!-- API Management -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-key text-blue-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">API Management</h3>
                        <p class="text-sm text-gray-500">Urus token API</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Cipta dan urus token API untuk akses luar sistem.</p>
                <a href="{{ route('settings.api-tokens') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700">
                    <i class="fas fa-cog mr-2"></i>
                    Urus Token API
                </a>
            </div>

            <!-- API Documentation -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-book text-green-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">API Documentation</h3>
                        <p class="text-sm text-gray-500">Panduan API</p>
                    </div>
                </div>
                <p class="text-gray-600 mb-4">Lihat dokumentasi lengkap untuk menggunakan API.</p>
                <a href="{{ route('settings.api-documentation') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700">
                    <i class="fas fa-book-open mr-2"></i>
                    Lihat Dokumentasi
                </a>
            </div>

            <!-- System Info -->
            <div class="bg-white border border-gray-200 p-6">
                <div class="flex items-center mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-info-circle text-gray-600 text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">Maklumat Sistem</h3>
                        <p class="text-sm text-gray-500">Info sistem</p>
                    </div>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Versi:</span>
                        <span class="font-medium">1.0.0</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Laravel:</span>
                        <span class="font-medium">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">PHP:</span>
                        <span class="font-medium">{{ PHP_VERSION }}</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Quick Stats -->
        <div class="mt-8 bg-white border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Pantas</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">
                        {{ \App\Models\Bisnes::where('user_id', auth()->id())->count() }}</div>
                    <div class="text-sm text-gray-500">Bisnes</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">
                        {{ \App\Models\Prospek::whereHas('bisnes', function ($q) {$q->where('user_id', auth()->id());})->count() }}
                    </div>
                    <div class="text-sm text-gray-500">Prospek</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">
                        {{ \App\Models\ProspekBuy::whereHas('prospek.bisnes', function ($q) {$q->where('user_id', auth()->id());})->count() }}
                    </div>
                    <div class="text-sm text-gray-500">Pembelian</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-orange-600">
                        {{ \App\Models\ApiToken::where('user_id', auth()->id())->where('is_active', true)->count() }}</div>
                    <div class="text-sm text-gray-500">Token API Aktif</div>
                </div>
            </div>
        </div>
    </div>
@endsection
