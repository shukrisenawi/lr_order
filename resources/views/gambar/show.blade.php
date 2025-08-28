@extends('layouts.app')

@section('title', 'Lihat Gambar')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Gambar</h1>
                    <p class="text-gray-600">Butiran gambar</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('gambar.edit', $gambar) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
                    <a href="{{ route('gambar.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Galeri
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Image Display -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Gambar</h3>
                </div>
                <div class="p-6">
                    @if ($gambar->path)
                        <div class="rounded-xl mb-5 overflow-hidden border border-gray-200 shadow-sm">
                            <img src="{{ $gambar->path }}" alt="{{ $gambar->nama ?? 'Gambar' }}" class="max-w-full">
                        </div>
                        @if ($gambar->ai_search)
                            <span class="badge badge-success rounded-2xl px-3"><i
                                    class="fas fa-check-circle text-green-600"></i>
                                Carian AI</span>
                        @endif
                    @else
                        <div
                            class="w-full h-96 bg-gradient-to-br from-purple-100 to-indigo-100 rounded-xl flex items-center justify-center">
                            <i class="fas fa-image text-purple-400 text-6xl"></i>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Image Details -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                    <h3 class="text-xl font-semibold text-gray-900">Maklumat Gambar</h3>
                </div>

                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tajuk</label>
                            <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                                {{ $gambar->nama ?? 'Tanpa Tajuk' }}
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Keterangan</label>
                            <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200 min-h-16">
                                {{ $gambar->keterangan ?? 'Tiada keterangan' }}
                            </div>
                        </div>

                        <!-- File Info -->
                        @if ($gambar->path)
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Laluan Fail</label>
                                <div
                                    class="text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200 font-mono text-sm break-words">
                                    {{ $gambar->path }}
                                </div>
                            </div>
                        @endif

                        <!-- Created Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Dicipta</label>
                            <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                                <i class="far fa-calendar-alt text-gray-500 mr-2"></i>
                                {{ $gambar->created_at->format('d/m/Y H:i') }}
                            </div>
                        </div>

                        <!-- Updated Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Kemaskini</label>
                            <div class="text-gray-900 bg-gray-50 px-4 py-3 rounded-xl border border-gray-200">
                                <i class="far fa-calendar-check text-gray-500 mr-2"></i>
                                {{ $gambar->updated_at->format('d/m/Y H:i') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('gambar.edit', $gambar) }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                <i class="fas fa-edit mr-2"></i>
                Edit Gambar
            </a>

            <form method="POST" action="{{ route('gambar.destroy', $gambar) }}" class="inline"
                onsubmit="return confirm('Adakah anda pasti mahu memadamkan gambar ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    <i class="fas fa-trash mr-2"></i>
                    Padam Gambar
                </button>
            </form>
        </div>
    </div>
@endsection
