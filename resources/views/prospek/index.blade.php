@extends('layouts.app')

@section('title', 'Pengurusan Prospek')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Prospek</h1>
                    <p class="text-gray-600">Urus prospek dan pelanggan anda</p>
                    <div class="flex items-center gap-4 mt-3">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <i class="fas fa-users mr-1"></i>
                            Jumlah: {{ $prospek->total() ?? 0 }}
                        </span>
                    </div>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('prospek.create') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-plus mr-2"></i>
                        Tambah Prospek Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('success'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-red-50 to-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

    <!-- Prospects Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No Telefon</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Gelaran</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Perniagaan</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dicipta</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($prospek as $item)
                        <tr class="hover:bg-blue-50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $item->id }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_tel }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-tag mr-1"></i>
                                    {{ $item->gelaran }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->bisnes->nama_bines ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-3">
                                    <a href="{{ route('prospek.show', $item) }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('prospek.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('prospek.destroy', $item) }}" class="inline"
                                          onsubmit="return confirm('Adakah anda pasti mahu memadam prospek ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                            <i class="fas fa-trash mr-1"></i>
                                            Padam
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-users text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tiada prospek dijumpai</h3>
                                    <p class="text-gray-500 mb-4">Mula dengan menambah prospek pertama anda</p>
                                    <a href="{{ route('prospek.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg shadow hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Prospek Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($prospek) && $prospek->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $prospek->firstItem() }}</span> ke <span class="font-medium">{{ $prospek->lastItem() }}</span> daripada <span class="font-medium">{{ $prospek->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $prospek->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
