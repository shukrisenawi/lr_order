@extends('layouts.app')

@section('title', 'Lihat Iklan')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1 class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                            <i class="fas fa-eye text-blue-500 mr-4"></i>
                            Lihat Iklan
                        </h1>
                        <p class="text-gray-600 text-lg">Maklumat terperinci untuk <span class="font-bold text-blue-600">{{ $iklan->nama_iklan ?? 'N/A' }}</span></p>
                        <div class="flex items-center gap-4 mt-6">
                            <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-2 border-blue-200 shadow-sm">
                                <i class="fas fa-hashtag mr-2 text-blue-600"></i>
                                Iklan #{{ $iklan->id }}
                            </div>
                            <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200 shadow-sm">
                                <i class="fas fa-calendar-day mr-2 text-green-600"></i>
                                Hari {{ $iklan->hari }}
                            </div>
                            <div class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold
                                {{ $iklan->on ? 'bg-green-100 text-green-800 border-2 border-green-200' : 'bg-gray-100 text-gray-800 border-2 border-gray-200' }} shadow-sm">
                                <i class="fas fa-{{ $iklan->on ? 'robot' : 'pause' }} mr-2"></i>
                                {{ $iklan->on ? 'AI Aktif' : 'AI Tidak Aktif' }}
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('iklan.edit', $iklan) }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                            <i class="fas fa-edit mr-3 text-lg"></i>
                            Edit Iklan
                        </a>
                        <a href="{{ route('iklan.index') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-bold rounded-xl shadow-xl hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-gray-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                            <i class="fas fa-arrow-left mr-3 text-lg"></i>
                            Kembali ke Senarai
                        </a>
                    </div>
                </div>
            </div>

            <!-- Iklan Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-10">
                    <!-- Basic Information Card -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-info-circle text-white text-xl"></i>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">Maklumat Asas</h3>
                                    <p class="text-gray-600 text-lg mt-1">Maklumat utama iklan dengan teknologi AI</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <!-- Nama Iklan -->
                                <div class="relative">
                                    <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-tag text-white text-sm"></i>
                                        </div>
                                        Nama Iklan
                                    </label>
                                    <div class="px-6 py-5 bg-gradient-to-r from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl shadow-sm">
                                        <p class="text-gray-900 font-bold text-xl">{{ $iklan->nama_iklan ?? 'N/A' }}</p>
                                    </div>
                                </div>

                                <!-- Hari -->
                                <div class="relative">
                                    <label class="block text-lg font-bold text-gray-800 mb-4 flex items-center">
                                        <div class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                            <i class="fas fa-calendar-day text-white text-sm"></i>
                                        </div>
                                        Hari Tayangan
                                    </label>
                                    <div class="px-6 py-5 bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-200 rounded-2xl shadow-sm">
                                        <p class="text-gray-900 font-bold text-xl flex items-center">
                                            <i class="fas fa-hashtag text-green-600 mr-3 text-lg"></i>
                                            Hari {{ $iklan->hari ?? 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description Card -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-file-alt text-white text-xl"></i>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">Keterangan Iklan</h3>
                                    <p class="text-gray-600 text-lg mt-1">Kandungan dan maklumat terperinci iklan</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="bg-gradient-to-r from-purple-50 via-pink-50 to-rose-50 border-2 border-purple-200 rounded-3xl p-8 shadow-inner">
                                <div class="prose prose-xl max-w-none">
                                    @if ($iklan->keterangan)
                                        <div class="text-gray-900 leading-relaxed whitespace-pre-wrap text-lg font-medium">{{ $iklan->keterangan }}</div>
                                    @else
                                        <div class="text-gray-500 italic flex items-center text-lg">
                                            <i class="fas fa-info-circle mr-3 text-xl"></i>
                                            Tiada keterangan tersedia
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
            </div>

                <!-- Sidebar -->
                <div class="space-y-10">
                    <!-- Status Card -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-chart-line text-white text-xl"></i>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">Status & AI</h3>
                                    <p class="text-gray-600 text-lg mt-1">Status semasa iklan dengan AI</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 space-y-8">
                            <!-- AI Status -->
                            <div class="flex items-center justify-between p-6 bg-white/60 rounded-2xl border border-green-100">
                                <div>
                                    <p class="text-lg font-bold text-gray-900">AI Status</p>
                                    <p class="text-sm text-gray-600 mt-1">Pengurusan automatik pintar</p>
                                </div>
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-lg font-bold
                                    {{ $iklan->on ? 'bg-green-100 text-green-800 border-2 border-green-200' : 'bg-gray-100 text-gray-800 border-2 border-gray-200' }} shadow-sm">
                                    <i class="fas fa-{{ $iklan->on ? 'robot' : 'pause' }} mr-3 text-xl"></i>
                                    {{ $iklan->on ? 'AI Aktif' : 'AI Tidak Aktif' }}
                                </span>
                            </div>

                            <!-- Activity Status -->
                            <div class="flex items-center justify-between p-6 bg-white/60 rounded-2xl border border-blue-100">
                                <div>
                                    <p class="text-lg font-bold text-gray-900">Status Aktiviti</p>
                                    <p class="text-sm text-gray-600 mt-1">Status tayangan semasa</p>
                                </div>
                                <span class="inline-flex items-center px-6 py-3 rounded-full text-lg font-bold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-2 border-blue-200 shadow-sm">
                                    <i class="fas fa-play-circle mr-3 text-xl"></i>
                                    Hari {{ $iklan->hari }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Timestamps Card -->
                    <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <i class="fas fa-clock text-white text-xl"></i>
                                </div>
                                <div class="ml-6">
                                    <h3 class="text-2xl font-bold text-gray-900">Maklumat Masa</h3>
                                    <p class="text-gray-600 text-lg mt-1">Tarikh penting dan aktiviti</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8 space-y-6">
                            <!-- Created Date -->
                            <div class="flex items-center justify-between p-6 bg-white/60 rounded-2xl border border-blue-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-sm">
                                        <i class="fas fa-calendar-plus text-white text-lg"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-lg font-bold text-gray-900">Dicipta</p>
                                        <p class="text-sm text-gray-600">{{ $iklan->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500 font-medium">{{ $iklan->created_at->format('H:i') }}</span>
                            </div>

                            <!-- Updated Date -->
                            <div class="flex items-center justify-between p-6 bg-white/60 rounded-2xl border border-green-100">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-sm">
                                        <i class="fas fa-calendar-check text-white text-lg"></i>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-lg font-bold text-gray-900">Kemaskini</p>
                                        <p class="text-sm text-gray-600">{{ $iklan->updated_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500 font-medium">{{ $iklan->updated_at->format('H:i') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-12 flex flex-col sm:flex-row justify-end space-y-6 sm:space-y-0 sm:space-x-6">
            <a href="{{ route('iklan.index') }}"
                class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-sm hover:shadow-md">
                <i class="fas fa-arrow-left mr-3 text-lg"></i>
                Kembali ke Senarai
            </a>
            <a href="{{ route('iklan.edit', $iklan) }}"
                class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                <i class="fas fa-edit mr-3 text-lg"></i>
                Edit Iklan
            </a>
            <form method="POST" action="{{ route('iklan.destroy', $iklan) }}" class="inline"
                onsubmit="return confirm('Adakah anda pasti mahu memadamkan iklan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold rounded-2xl shadow-xl hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-red-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                    <i class="fas fa-trash mr-3 text-lg"></i>
                    Padam Iklan
                </button>
            </form>
        </div>
    </div>
@endsection
