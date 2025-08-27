@extends('layouts.app')

@section('title', 'Pengurusan Alamat Customer')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Alamat Customer</h1>
                    <p class="text-gray-600">Urus alamat customer anda</p>
                </div>
                <a href="{{ route('customer-alamat.create') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-xl shadow-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Alamat Baru
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                    <span>{{ session('message') }}</span>
                </div>
            </div>
        @endif

        @if (session()->has('error'))
            <div
                class="mb-8 p-4 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Customer</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Alamat</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Bandar</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Poskod</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Negeri</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if (isset($customerAlamat) && $customerAlamat->count() > 0)
                            @foreach ($customerAlamat as $item)
                                <tr class="hover:bg-amber-50 transition-colors duration-200">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $item->customer->gelaran ?? 'N/A' }} - {{ $item->customer->no_tel ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        <div class="max-w-xs truncate">{{ $item->alamat ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->bandar ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $item->poskod ?? 'N/A' }}</td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-800">
                                            {{ $item->negeri ?? 'N/A' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('customer-alamat.show', $item) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-amber-700 bg-amber-50 rounded-lg hover:bg-amber-100 transition-colors duration-200">
                                                <i class="fas fa-eye mr-1"></i>
                                                Lihat
                                            </a>
                                            <a href="{{ route('customer-alamat.edit', $item) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-orange-700 bg-orange-50 rounded-lg hover:bg-orange-100 transition-colors duration-200">
                                                <i class="fas fa-edit mr-1"></i>
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('customer-alamat.destroy', $item) }}"
                                                class="inline"
                                                onsubmit="return confirm('Adakah anda pasti mahu memadamkan alamat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                                    <i class="fas fa-trash mr-1"></i>
                                                    Padam
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="bg-gray-100 rounded-full p-4 mb-4">
                                            <i class="fas fa-map-marker-alt text-gray-400 text-2xl"></i>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">Tiada alamat dijumpai</h3>
                                        <p class="text-gray-500 mb-4">Cuba tambah alamat baru</p>
                                        <a href="{{ route('customer-alamat.create') }}"
                                            class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-medium rounded-lg shadow hover:from-amber-600 hover:to-orange-700 transition-all duration-300">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah alamat pertama anda
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($customerAlamat) && $customerAlamat->hasPages())
                <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menunjukkan <span class="font-medium">{{ $customerAlamat->firstItem() }}</span> ke <span
                                class="font-medium">{{ $customerAlamat->lastItem() }}</span> daripada <span
                                class="font-medium">{{ $customerAlamat->total() }}</span> rekod
                        </div>
                        <div>
                            {{ $customerAlamat->links('vendor.pagination.tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
