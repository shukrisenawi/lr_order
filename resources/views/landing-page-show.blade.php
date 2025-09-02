@extends('layouts.app')

@section('title', 'Lihat Landing Page')

@section('content')
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Landing Page</h1>
                    <p class="text-gray-600">Maklumat terperinci landing page</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('landing-page.edit', $landingPage) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Landing Page
                    </a>
                    <a href="{{ route('landing-page.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali ke Senarai
                    </a>
                </div>
            </div>
        </div>

        <!-- Landing Page Details -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">{{ $landingPage->title }}</h3>
                <p class="text-gray-600 text-sm mt-1">Status: <span class="font-medium {{ $landingPage->status === 'published' ? 'text-green-600' : 'text-yellow-600' }}">{{ ucfirst($landingPage->status) }}</span></p>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 gap-8">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tajuk</label>
                        <p class="text-gray-900">{{ $landingPage->title }}</p>
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Slug</label>
                        <p class="text-gray-900">{{ $landingPage->slug }}</p>
                        @if($landingPage->status === 'published')
                            <p class="text-sm text-blue-600 mt-1">
                                <a href="{{ route('landing-page.public.show', $landingPage->slug) }}" target="_blank" class="hover:underline">
                                    <i class="fas fa-external-link-alt mr-1"></i>
                                    Lihat halaman awam
                                </a>
                            </p>
                        @endif
                    </div>

                    <!-- Content Preview -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Kandungan</label>
                        <div class="bg-gray-50 p-4 rounded-lg border max-h-96 overflow-y-auto">
                            {!! $landingPage->content !!}
                        </div>
                    </div>

                    <!-- SEO Information -->
                    @if($landingPage->meta_title || $landingPage->meta_description)
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-800 mb-3">SEO Information</h4>
                            @if($landingPage->meta_title)
                                <div class="mb-2">
                                    <label class="block text-xs font-medium text-blue-700">Meta Title</label>
                                    <p class="text-sm text-blue-900">{{ $landingPage->meta_title }}</p>
                                </div>
                            @endif
                            @if($landingPage->meta_description)
                                <div>
                                    <label class="block text-xs font-medium text-blue-700">Meta Description</label>
                                    <p class="text-sm text-blue-900">{{ $landingPage->meta_description }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    <!-- Template and Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Template</label>
                            <p class="text-gray-900">{{ ucfirst($landingPage->template) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-2">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $landingPage->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ ucfirst($landingPage->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Created/Updated Info -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Maklumat Sistem</label>
                        <p class="text-sm text-gray-600">Dicipta: {{ $landingPage->created_at->format('d M Y, H:i') }}</p>
                        <p class="text-sm text-gray-600">Dikemaskini: {{ $landingPage->updated_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection