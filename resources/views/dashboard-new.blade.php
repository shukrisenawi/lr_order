@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Section -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name }}! 👋</h1>
        <p class="text-gray-600">Here's what's happening with your business today.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Bisnes -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Bisnes</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBisnes ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Produk -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-lg">
                    <i class="fas fa-box text-green-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Produk</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProduk ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Prospek -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-lg">
                    <i class="fas fa-users text-purple-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Prospek</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalProspek ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Total Pembelian -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-lg">
                    <i class="fas fa-shopping-cart text-yellow-600 text-xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Pembelian</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalPembelian ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Business Management -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Business Management</h3>
            <div class="space-y-3">
                <a href="{{ route('bisnes.create') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                    <i class="fas fa-plus text-blue-600 mr-3"></i>
                    <span class="text-blue-700 font-medium">Add New Business</span>
                </a>
                <a href="{{ route('produk.create') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors">
                    <i class="fas fa-plus text-green-600 mr-3"></i>
                    <span class="text-green-700 font-medium">Add New Product</span>
                </a>
                <a href="{{ route('gambar.create') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors">
                    <i class="fas fa-plus text-purple-600 mr-3"></i>
                    <span class="text-purple-700 font-medium">Add New Image</span>
                </a>
            </div>
        </div>

        <!-- Customer Management -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Management</h3>
            <div class="space-y-3">
                <a href="{{ route('prospek.create') }}" class="flex items-center p-3 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors">
                    <i class="fas fa-plus text-indigo-600 mr-3"></i>
                    <span class="text-indigo-700 font-medium">Add New Prospect</span>
                </a>
                <a href="{{ route('prospek-alamat.create') }}" class="flex items-center p-3 bg-pink-50 hover:bg-pink-100 rounded-lg transition-colors">
                    <i class="fas fa-plus text-pink-600 mr-3"></i>
                    <span class="text-pink-700 font-medium">Add Prospect Address</span>
                </a>
                <a href="{{ route('prospek-buy.create') }}" class="flex items-center p-3 bg-orange-50 hover:bg-orange-100 rounded-lg transition-colors">
                    <i class="fas fa-plus text-orange-600 mr-3"></i>
                    <span class="text-orange-700 font-medium">Add New Purchase</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-blue-100 rounded-full">
                        <i class="fas fa-building text-blue-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">New business added</p>
                        <p class="text-sm text-gray-500">2 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-green-100 rounded-full">
                        <i class="fas fa-box text-green-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Product updated</p>
                        <p class="text-sm text-gray-500">4 hours ago</p>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="p-2 bg-purple-100 rounded-full">
                        <i class="fas fa-users text-purple-600"></i>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">New prospect registered</p>
                        <p class="text-sm text-gray-500">6 hours ago</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
