@extends('layouts.app')

@section('title', 'Business Details')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                        <i class="fas fa-building text-green-500 mr-3"></i>
                        Business Details
                    </h1>
                    <p class="text-gray-600">Complete information for {{ $bisnes->nama_bines }}</p>
                    <div class="flex items-center gap-4 mt-4">
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                            <i class="fas fa-id-badge mr-2"></i>
                            ID: {{ $bisnes->id }}
                        </div>
                        <div
                            class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                            <i class="fas fa-tag mr-2"></i>
                            {{ $bisnes->bisnesType->type }}
                        </div>
                        @if ($bisnes->exp_date && \Carbon\Carbon::parse($bisnes->exp_date)->isPast())
                            <div
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border border-red-200">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                Expired
                            </div>
                        @else
                            <div
                                class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200">
                                <i class="fas fa-check-circle mr-2"></i>
                                Active
                            </div>
                        @endif
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('bisnes.edit', $bisnes) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Business
                    </a>
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Business Overview Card -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden mb-8">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                <div class="flex items-center">
                    <div
                        class="flex-shrink-0 w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-eye text-white"></i>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-gray-900">Business Overview</h3>
                        <p class="text-gray-600 text-sm mt-1">Complete business information and details</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <!-- Business Logo Section -->
                <div class="mb-8">
                    <div class="flex items-center justify-center">
                        <div class="relative">
                            @if ($bisnes->gambar)
                                <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) }}"
                                    alt="{{ $bisnes->nama_bines }}"
                                    class="w-40 h-40 rounded-2xl object-cover border-4 border-white shadow-xl">
                            @else
                                <div
                                    class="w-40 h-40 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl flex items-center justify-center border-4 border-white shadow-xl">
                                    <i class="fas fa-building text-blue-500 text-5xl"></i>
                                </div>
                            @endif
                            <div
                                class="absolute -bottom-2 -right-2 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center border-4 border-white">
                                <i class="fas fa-check text-white text-xs"></i>
                            </div>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-900 text-center mt-4">{{ $bisnes->nama_bines }}</h2>
                    <p class="text-gray-600 text-center">{{ $bisnes->nama_syarikat }}</p>
                </div>

                <!-- Business Information Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <!-- Business Information Card -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl p-6 border border-blue-100">
                        <div class="flex items-center mb-4">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-info-circle text-white text-sm"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-semibold text-gray-900">Business Information</h4>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Business Name</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $bisnes->nama_bisnes }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Company Name</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $bisnes->nama_syarikat }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-blue-100">
                                <span class="text-sm font-medium text-gray-600">Registration No</span>
                                <span
                                    class="text-sm font-semibold text-gray-900">{{ $bisnes->no_pendaftaran ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-medium text-gray-600">System Type</span>
                                <span
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $bisnes->bisnesType->type }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information Card -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl p-6 border border-green-100">
                        <div class="flex items-center mb-4">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-address-book text-white text-sm"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-semibold text-gray-900">Contact Information</h4>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-green-100">
                                <span class="text-sm font-medium text-gray-600 flex items-center">
                                    <i class="fas fa-phone text-green-500 mr-2"></i>
                                    Phone Number
                                </span>
                                <span class="text-sm font-semibold text-gray-900">{{ $bisnes->no_tel }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-green-100">
                                <span class="text-sm font-medium text-gray-600 flex items-center">
                                    <i class="fas fa-mailbox text-orange-500 mr-2"></i>
                                    Postcode
                                </span>
                                <span class="text-sm font-semibold text-gray-900">{{ $bisnes->poskod }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-medium text-gray-600 flex items-center">
                                    <i class="fas fa-map-marker-alt text-red-500 mr-2"></i>
                                    Address
                                </span>
                                <span class="text-sm font-semibold text-gray-900 text-right max-w-xs truncate"
                                    title="{{ $bisnes->alamat }}">
                                    {{ $bisnes->alamat }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- System Settings Card -->
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                        <div class="flex items-center mb-4">
                            <div
                                class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cogs text-white text-sm"></i>
                            </div>
                            <h4 class="ml-3 text-lg font-semibold text-gray-900">System Settings</h4>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between py-2 border-b border-purple-100">
                                <span class="text-sm font-medium text-gray-600">Prefix</span>
                                <span class="text-sm font-semibold text-gray-900">{{ $bisnes->prefix ?? '-' }}</span>
                            </div>
                            <div class="flex items-center justify-between py-2 border-b border-purple-100">
                                <span class="text-sm font-medium text-gray-600">Expiry Date</span>
                                <span class="text-sm font-semibold text-gray-900 flex items-center">
                                    <i class="far fa-calendar-alt text-gray-500 mr-2"></i>
                                    @if ($bisnes->exp_date)
                                        {{ \Carbon\Carbon::parse($bisnes->exp_date)->format('d M Y') }}
                                    @else
                                        No expiry
                                    @endif
                                </span>
                            </div>
                            <div class="flex items-center justify-between py-2">
                                <span class="text-sm font-medium text-gray-600">Created</span>
                                <span class="text-sm font-semibold text-gray-900 flex items-center">
                                    <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                    @if ($bisnes->created_at)
                                        {{ $bisnes->created_at->format('d M Y') }}
                                    @else
                                        -
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- AI Instructions Section -->
                <div class="mt-8 bg-gradient-to-r from-purple-50 to-pink-50 rounded-xl p-6 border border-purple-100">
                    <div class="flex items-center mb-4">
                        <div
                            class="flex-shrink-0 w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-brain text-white text-sm"></i>
                        </div>
                        <h4 class="ml-3 text-lg font-semibold text-gray-900">AI System Instructions</h4>
                    </div>
                    <div class="bg-white rounded-lg p-4 border border-purple-200">
                        <p class="text-gray-900 leading-relaxed whitespace-pre-line">{!! nl2br($bisnes->system_message) !!}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('bisnes.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Kembali
                </a>
                <a href="{{ route('bisnes.edit', $bisnes) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Bisnes
                </a>
                <form method="POST" action="{{ route('bisnes.destroy', $bisnes) }}" class="inline"
                    onsubmit="return confirm('Adakah anda pasti ingin memadam bisnes ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        <i class="fas fa-trash mr-2"></i>
                        Padam Bisnes
                    </button>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
