@extends('layouts.app')

@section('title', 'Ringkasan Bisnes')

@section('content')
    @php
        // exit();
    @endphp
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Ringkasan Syarikat</h1>
                    <p class="text-gray-600">Maklumat ini dibaca oleh AI</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Business Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Ringkasan {{ $bisnes->nama_bisnes }}</h3>
            </div>

            <div class="p-6">
                {!! nl2br(e($bisnes->summary)) !!}
                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
