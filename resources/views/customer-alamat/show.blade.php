@extends('layouts.app')

@section('title', 'Lihat Alamat Prospek')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Alamat Prospek</h1>
                    <p class="text-gray-600">Maklumat alamat prospek</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('prospek-alamat.edit', $prospekAlamat) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Kemaskini
                    </a>
                    <a href="{{ route('prospek-alamat.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Address Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Alamat</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Prospek -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Prospek</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                @if ($prospekAlamat->prospek)
                                    <p class="text-gray-900 font-medium">{{ $prospekAlamat->prospek->gelaran }}</p>
                                    <p class="text-gray-600 text-sm">{{ $prospekAlamat->prospek->no_tel }}</p>
                                    @if ($prospekAlamat->prospek->bisnes)
                                        <p class="text-gray-500 text-xs mt-1">
                                            {{ $prospekAlamat->prospek->bisnes->nama_bines }}</p>
                                    @endif
                                @else
                                    <p class="text-gray-500">Tiada prospek ditetapkan</p>
                                @endif
                            </div>
                        </div>

                        <!-- Nama Penerima -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Penerima</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $prospekAlamat->nama_penerima ?? 'Tiada' }}</p>
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $prospekAlamat->alamat ?? 'Tiada' }}</p>
                            </div>
                        </div>

                        <!-- Bandar -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Bandar</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $prospekAlamat->bandar ?? 'Tiada' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Poskod -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $prospekAlamat->poskod ?? 'Tiada' }}</p>
                            </div>
                        </div>

                        <!-- Negeri -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Negeri</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $prospekAlamat->negeri ?? 'Tiada' }}</p>
                            </div>
                        </div>

                        <!-- No Telefon -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">No Telefon</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900">{{ $prospekAlamat->no_tel ?? 'Tiada' }}</p>
                            </div>
                        </div>

                        <!-- Tarikh Dicipta -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Dicipta</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900 flex items-center">
                                    <i class="far fa-calendar-alt text-gray-500 mr-2"></i>
                                    {{ $prospekAlamat->created_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>

                        <!-- Tarikh Kemaskini -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Kemaskini</label>
                            <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                                <p class="text-gray-900 flex items-center">
                                    <i class="far fa-calendar-check text-gray-500 mr-2"></i>
                                    {{ $prospekAlamat->updated_at->format('d/m/Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat Lengkap</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                        <p class="text-gray-900">
                            {{ $prospekAlamat->nama_penerima ?? '' }}<br>
                            {{ $prospekAlamat->alamat ?? 'Tiada' }}<br>
                            {{ $prospekAlamat->poskod ?? '' }} {{ $prospekAlamat->bandar ?? '' }}<br>
                            {{ $prospekAlamat->negeri ?? '' }}<br>
                            {{ $prospekAlamat->no_tel ?? '' }}
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('prospek-alamat.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Kembali
                    </a>
                    <a href="{{ route('prospek-alamat.edit', $prospekAlamat) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Kemaskini
                    </a>
                    <form method="POST" action="{{ route('prospek-alamat.destroy', $prospekAlamat) }}" class="inline"
                        onsubmit="return confirm('Adakah anda pasti mahu memadamkan alamat ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-trash mr-2"></i>
                            Padam
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
