@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="bg-white/20 p-3 rounded-xl">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h1 class="text-2xl font-bold text-white">Pengurusan Scan Cula</h1>
                                    <p class="text-indigo-100 mt-1">Kelola data scan cula dengan mudah dan efisien</p>
                                </div>
                            </div>
                            <div class="hidden md:block">
                                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-4 py-2">
                                    <div class="text-white text-sm">
                                        <div class="font-semibold">{{ now()->format('l, d F Y') }}</div>
                                        <div class="text-indigo-100">{{ now()->format('H:i') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
                <livewire:scan-cula-crud />
            </div>
        </div>
    </div>
@endsection