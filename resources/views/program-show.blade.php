@extends('layouts.app')

@section('title', 'Lihat Program')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Program</h1>
                    <p class="text-gray-600">Maklumat terperinci program</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('program.edit', $program) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Program
                    </a>
                    <a href="{{ route('program.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Program Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">{{ $program->tajuk }}</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Banner Image -->
                        @if($program->gambar_banner)
                            <div>
                                <label class="block text-sm font-semibold text-gray-800 mb-2">Gambar Banner</label>
                                <img src="{{ asset('storage/' . $program->gambar_banner) }}" alt="Banner" class="w-full max-w-md h-48 object-cover rounded-lg">
                            </div>
                        @endif

                        <!-- Tajuk -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tajuk Program</label>
                            <p class="text-gray-900">{{ $program->tajuk }}</p>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        <!-- Keterangan -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Keterangan</label>
                            <p class="text-gray-900">{{ $program->keterangan ?: 'Tiada keterangan' }}</p>
                        </div>

                        <!-- Tarikh & Masa Program -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh & Masa Program</label>
                            <p class="text-gray-900">
                                @if($program->tarikh_masa_program)
                                    {{ $program->tarikh_masa_program->format('d M Y, H:i') }}
                                @else
                                    Tidak ditetapkan
                                @endif
                            </p>
                        </div>

                        <!-- Created/Updated Info -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Maklumat Sistem</label>
                            <p class="text-sm text-gray-600">Dicipta: {{ $program->created_at->format('d M Y, H:i') }}</p>
                            <p class="text-sm text-gray-600">Dikemaskini: {{ $program->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection