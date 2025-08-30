@extends('layouts.app')

@section('title', 'Business Management')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-building text-blue-500 mr-3"></i>
                        Business Management
                    </h1>
                    <p class="text-gray-600">Manage your business entities and operations</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            <i class="fas fa-chart-line mr-2"></i>
                            Total Businesses: {{ $bisnes->count() }}
                        </div>
                        <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                            <i class="fas fa-check-circle mr-2"></i>
                            Active: {{ $bisnes->where('exp_date', '>', now())->count() }}
                        </div>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors duration-200">
                        <i class="fas fa-tachometer-alt mr-1"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('bisnes.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-plus mr-2"></i>
                        Add New Business
                    </a>
                </div>
            </div>
        </div>

        <!-- Business Cards Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
            @forelse($bisnes as $item)
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:scale-105">
                    <!-- Business Image -->
                    <div class="relative h-48 bg-gradient-to-br from-blue-100 to-indigo-100">
                        @if ($item->gambar)
                            <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($item->gambar) }}"
                                alt="{{ $item->nama_bines }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-building text-4xl text-gray-400"></i>
                                </div>
                            </div>
                        @endif

                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            @if ($item->exp_date && \Carbon\Carbon::parse($item->exp_date)->isPast())
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Expired
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Active
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Business Info -->
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $item->nama_bines }}</h3>
                            <p class="text-gray-600 text-sm">{{ $item->nama_syarikat }}</p>
                        </div>

                        <!-- Business Details -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-id-card text-blue-500 mr-3 w-4"></i>
                                <span>{{ $item->no_pendaftaran ?: 'No registration' }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-tag text-purple-500 mr-3 w-4"></i>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $item->jenis_bisnes }}
                                </span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <i class="fas fa-phone text-green-500 mr-3 w-4"></i>
                                <span>{{ $item->no_tel }}</span>
                            </div>

                            @if ($item->exp_date)
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-calendar-times text-red-500 mr-3 w-4"></i>
                                    <span>Expires: {{ \Carbon\Carbon::parse($item->exp_date)->format('d M Y') }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('bisnes.show', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                <i class="fas fa-eye mr-2"></i>
                                View
                            </a>
                            <a href="{{ route('bisnes.edit', $item) }}"
                                class="flex-1 inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                                <i class="fas fa-edit mr-2"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Empty State -->
                <div class="col-span-full">
                    <div class="bg-white rounded-2xl shadow-xl p-12 text-center">
                        <div class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-building text-4xl text-gray-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">No businesses found</h3>
                        <p class="text-gray-600 mb-6">Start by creating your first business entity</p>
                        <a href="{{ route('bisnes.create') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <i class="fas fa-plus mr-2"></i>
                            Create Your First Business
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if (isset($bisnes) && $bisnes->hasPages())
            <div class="bg-white rounded-2xl shadow-xl p-6">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Showing <span class="font-medium">{{ $bisnes->firstItem() }}</span> to <span class="font-medium">{{ $bisnes->lastItem() }}</span> of <span class="font-medium">{{ $bisnes->total() }}</span> businesses
                    </div>
                    <div class="flex space-x-2">
                        {{ $bisnes->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
@endsection
