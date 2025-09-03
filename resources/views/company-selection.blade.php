@extends('layouts.app')

@section('title', 'Pilih Syarikat')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 flex items-center justify-center p-4">
        <div class="max-w-full mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                    Pilih Syarikat Anda
                </h1>
                <p class="text-lg text-gray-600">
                    Sila pilih syarikat yang ingin anda uruskan untuk meneruskan ke dashboard
                </p>
            </div>

            <!-- Company Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($userBisnes as $bisnes)
                    <div
                        class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 border border-gray-200 overflow-hidden">
                        <div class="p-6">
                            <!-- Company Logo -->
                            <div class="flex items-center justify-center mb-4">
                                @if ($bisnes->gambar)
                                    <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) }}"
                                        alt="{{ $bisnes->nama_bisnes }}"
                                        class="w-16 h-16 rounded-full object-cover border-4 border-blue-100 shadow-lg">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-purple-500 flex items-center justify-center shadow-lg">
                                        <span
                                            class="text-white font-bold text-xl">{{ strtoupper(substr($bisnes->nama_bisnes, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>

                            <!-- Company Info -->
                            <div class="text-center mb-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $bisnes->nama_bisnes }}</h3>
                                <p class="text-sm text-gray-600">{{ $bisnes->nama_syarikat }}</p>
                                @if ($bisnes->bisnesType)
                                    <span
                                        class="inline-block mt-2 px-3 py-1 bg-blue-100 text-blue-800 text-xs font-medium rounded-full">
                                        {{ $bisnes->bisnesType->name ?? 'Business' }}
                                    </span>
                                @endif
                            </div>

                            <!-- Company Stats -->
                            <div class="grid grid-cols-3 gap-4 mb-6 text-center">
                                <div>
                                    <div class="text-2xl font-bold text-blue-600">{{ $bisnes->prospeks()->count() }}</div>
                                    <div class="text-xs text-gray-500">Prospek</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-green-600">
                                        {{ \App\Models\Customer::where('bisnes_id', $bisnes->id)->count() }}</div>
                                    <div class="text-xs text-gray-500">Pelanggan</div>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-purple-600">
                                        {{ \App\Models\Invoice::where('bisnes_id', $bisnes->id)->count() }}</div>
                                    <div class="text-xs text-gray-500">Invoice</div>
                                </div>
                            </div>

                            <!-- Select Button -->
                            <a href="{{ route('switch-bisnes', $bisnes->id) }}"
                                class="block w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-medium py-3 px-4 rounded-lg text-center transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <i class="fas fa-arrow-right mr-2"></i>
                                Pilih Syarikat Ini
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Add New Company -->
            <div class="text-center mt-8">
                <a href="{{ route('bisnes.create') }}"
                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-blue-500 hover:from-green-600 hover:to-blue-600 text-white font-medium rounded-lg transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Syarikat Baru
                </a>
            </div>

            <!-- Footer -->
            <div class="text-center mt-8 text-gray-500 text-sm">
                <p>&copy; 2024 Sistem Tempahan Perniagaan. Semua hak terpelihara.</p>
            </div>
        </div>
    </div>
@endsection
