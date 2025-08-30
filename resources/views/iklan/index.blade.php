@extends('layouts.app')

@section('title', 'Pengurusan Iklan')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header -->
            <div class="mb-10">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                    <div>
                        <h1
                            class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-3">
                            <i class="fas fa-bullhorn text-blue-500 mr-4"></i>
                            Pengurusan Iklan
                        </h1>
                        <p class="text-gray-600 text-lg">Urus dan pantau semua iklan anda dengan teknologi AI terkini</p>
                        <div class="flex items-center gap-4 mt-6">
                            <div
                                class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border-2 border-blue-200 shadow-sm">
                                <i class="fas fa-brain mr-2 text-blue-600"></i>
                                AI Powered
                            </div>
                            <div
                                class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200 shadow-sm">
                                <i class="fas fa-chart-line mr-2 text-green-600"></i>
                                Real-time Analytics
                            </div>
                            <div
                                class="inline-flex items-center px-5 py-3 rounded-full text-sm font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border-2 border-purple-200 shadow-sm">
                                <i class="fas fa-magic mr-2 text-purple-600"></i>
                                Smart Automation
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('iklan.index') }}"
                            class="inline-flex items-center justify-center px-6 py-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold rounded-xl shadow-lg border-2 border-gray-200 transition-all duration-300 hover:shadow-xl">
                            <i class="fas fa-list mr-2"></i>
                            Semua Iklan
                        </a>
                        <a href="{{ route('iklan.create') }}"
                            class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                            <i class="fas fa-plus mr-3"></i>
                            Tambah Iklan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
                <div
                    class="bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-700 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-blue-100 text-sm font-semibold uppercase tracking-wide">Jumlah Iklan</p>
                            <p class="text-4xl font-bold mt-2">{{ $iklan->total() ?? 0 }}</p>
                            <p class="text-blue-200 text-xs mt-1">Total dalam sistem</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-ad text-3xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-green-500 via-emerald-600 to-teal-700 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-green-100 text-sm font-semibold uppercase tracking-wide">Aktif Hari Ini</p>
                            <p class="text-4xl font-bold mt-2">{{ $iklan->where('on', 1)->count() ?? 0 }}</p>
                            <p class="text-green-200 text-xs mt-1">Iklan yang aktif</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-play-circle text-3xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-purple-500 via-pink-600 to-rose-600 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-purple-100 text-sm font-semibold uppercase tracking-wide">Purata Hari</p>
                            <p class="text-4xl font-bold mt-2">{{ round($iklan->avg('hari') ?? 0) }}</p>
                            <p class="text-purple-200 text-xs mt-1">Hari purata</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-calendar-day text-3xl"></i>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-gradient-to-br from-orange-500 via-red-500 to-pink-600 rounded-3xl p-8 text-white shadow-2xl transform hover:scale-105 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-orange-100 text-sm font-semibold uppercase tracking-wide">Performance</p>
                            <p class="text-4xl font-bold mt-2">{{ $iklan->where('on', 1)->count() > 0 ? 'A+' : 'B' }}</p>
                            <p class="text-orange-200 text-xs mt-1">Tahap prestasi</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                            <i class="fas fa-trophy text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden mb-8">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Carian & Penapisan</h3>
                            <p class="text-gray-600 text-sm mt-1">Cari iklan dengan mudah</p>
                        </div>
                        <div class="flex gap-4">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" placeholder="Cari nama iklan..."
                                    class="w-80 pl-12 pr-4 py-3 border border-gray-300 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                            </div>
                            <select
                                class="px-4 py-3 border border-gray-300 rounded-xl bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                                <option value="">Semua Status</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Iklan Table -->
            <div class="bg-white rounded-3xl shadow-2xl overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 via-white to-gray-50">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-900">Senarai Iklan</h3>
                            <p class="text-gray-600 text-sm mt-1">Pengurusan semua iklan dalam sistem</p>
                        </div>
                        <div class="flex items-center gap-4">
                            <span class="text-sm text-gray-500">Menunjukkan {{ $iklan->count() }} daripada
                                {{ $iklan->total() }} iklan</span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gradient-to-r from-blue-50 to-indigo-50 border-b-2 border-blue-100">
                            <tr>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">ID
                                </th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">
                                    Nama Iklan</th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">
                                    Keterangan</th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">
                                    Hari</th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">
                                    Status AI</th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">
                                    Dicipta</th>
                                <th class="px-8 py-5 text-left text-sm font-bold text-blue-800 uppercase tracking-wider">
                                    Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($iklan as $item)
                                <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 group"
                                    wire:key="iklan-{{ $item->id }}">
                                    <td
                                        class="px-8 py-6 text-sm font-bold text-gray-900 group-hover:text-blue-700 transition-colors">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-white text-xs font-bold">#{{ $item->id }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-r from-purple-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                                                <i class="fas fa-ad text-white text-sm"></i>
                                            </div>
                                            <div>
                                                <div
                                                    class="text-sm font-bold text-gray-900 group-hover:text-purple-700 transition-colors">
                                                    {{ $item->nama_iklan ?? 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">Iklan ID: {{ $item->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-sm text-gray-600 max-w-xs">
                                        <div class="line-clamp-2" title="{{ $item->keterangan ?? 'N/A' }}">
                                            {{ Str::limit($item->keterangan ?? 'N/A', 60) }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-r from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3">
                                                <i class="fas fa-calendar-day text-white text-xs"></i>
                                            </div>
                                            <span
                                                class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200">
                                                Hari {{ $item->hari ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        @if ($item->on)
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-green-500 rounded-full mr-3 animate-pulse"></div>
                                                <span
                                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border-2 border-green-200 shadow-sm">
                                                    <i class="fas fa-robot mr-2 text-green-600"></i>
                                                    AI Aktif
                                                </span>
                                            </div>
                                        @else
                                            <div class="flex items-center">
                                                <div class="w-3 h-3 bg-gray-400 rounded-full mr-3"></div>
                                                <span
                                                    class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-gradient-to-r from-gray-100 to-gray-200 text-gray-800 border-2 border-gray-300 shadow-sm">
                                                    <i class="fas fa-pause-circle mr-2 text-gray-600"></i>
                                                    Tidak Aktif
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 text-sm text-gray-500">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-plus text-blue-500 mr-2"></i>
                                            <span class="font-medium">{{ $item->created_at->format('d M Y') }}</span>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $item->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="flex gap-3">
                                            <a href="{{ route('iklan.show', $item) }}"
                                                class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-blue-700 bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl hover:from-blue-100 hover:to-blue-200 transition-all duration-300 shadow-sm hover:shadow-md border-2 border-blue-200 hover:border-blue-300 transform hover:scale-105">
                                                <i class="fas fa-eye mr-2"></i>
                                                Lihat
                                            </a>
                                            <a href="{{ route('iklan.edit', $item) }}"
                                                class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-indigo-700 bg-gradient-to-r from-indigo-50 to-indigo-100 rounded-xl hover:from-indigo-100 hover:to-indigo-200 transition-all duration-300 shadow-sm hover:shadow-md border-2 border-indigo-200 hover:border-indigo-300 transform hover:scale-105">
                                                <i class="fas fa-edit mr-2"></i>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('iklan.destroy', $item) }}"
                                                class="inline"
                                                onsubmit="return confirm('Adakah anda pasti mahu memadamkan iklan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-4 py-2.5 text-sm font-bold text-red-700 bg-gradient-to-r from-red-50 to-red-100 rounded-xl hover:from-red-100 hover:to-red-200 transition-all duration-300 shadow-sm hover:shadow-md border-2 border-red-200 hover:border-red-300 transform hover:scale-105">
                                                    <i class="fas fa-trash mr-2"></i>
                                                    Padam
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-gradient-to-r from-blue-100 to-indigo-100 rounded-full flex items-center justify-center mb-6 shadow-lg">
                                                <i class="fas fa-ad text-blue-500 text-4xl"></i>
                                            </div>
                                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Tiada iklan dijumpai</h3>
                                            <p class="text-gray-600 mb-8 text-lg">Mula cipta iklan pertama anda dengan
                                                teknologi AI terkini</p>
                                            <a href="{{ route('iklan.create') }}"
                                                class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-2xl shadow-xl hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-300 focus:ring-offset-2 transform hover:scale-105 hover:shadow-2xl">
                                                <i class="fas fa-plus mr-3 text-xl"></i>
                                                Cipta Iklan Pertama Anda
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (isset($iklan) && $iklan->hasPages())
                    <div class="px-8 py-6 border-t border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-700 font-medium">
                                Menunjukkan <span class="font-bold text-blue-600">{{ $iklan->firstItem() }}</span> ke
                                <span class="font-bold text-blue-600">{{ $iklan->lastItem() }}</span> daripada <span
                                    class="font-bold text-blue-600">{{ $iklan->total() }}</span> rekod
                            </div>
                            <div class="flex items-center gap-2">
                                {{ $iklan->links('vendor.pagination.tailwind') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
