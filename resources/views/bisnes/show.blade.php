@extends('layouts.app')

@section('title', 'View Bisnes')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Lihat Bisnes</h1>
                    <p class="text-gray-600">Maklumat terperinci untuk {{ $bisnes->nama_bines }}</p>
                </div>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('bisnes.edit', $bisnes) }}"
                        class="inline-flex items-center justify-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit
                    </a>
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
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Bisnes</h3>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Business Image -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Logo Bisnes</label>
                        <div class="flex items-center">
                            @if ($bisnes->gambar)
                                <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) }}"
                                    alt="{{ $bisnes->nama_bines }}"
                                    class="w-32 h-32 rounded-xl object-cover border border-gray-300 shadow-sm">
                            @else
                                <div
                                    class="w-32 h-32 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-xl flex items-center justify-center border border-gray-300 shadow-sm">
                                    <i class="fas fa-building text-blue-500 text-3xl"></i>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Business Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Bisnes</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $bisnes->nama_bines }}</p>
                        </div>
                    </div>

                    <!-- Company Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nama Syarikat</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $bisnes->nama_syarikat }}</p>
                        </div>
                    </div>

                    <!-- Registration Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">No Pendaftaran</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $bisnes->no_pendaftaran }}</p>
                        </div>
                    </div>

                    <!-- Business Type -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Jenis Bisnes</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ $bisnes->jenis_bisnes }}
                            </span>
                        </div>
                    </div>

                    <!-- Expiry Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Tamat</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-alt text-gray-500 mr-2"></i>
                                @if ($bisnes->exp_date)
                                    {{ \Carbon\Carbon::parse($bisnes->exp_date)->format('d/m/Y') }}
                                @else
                                    Tiada tarikh tamat
                                @endif
                            </p>
                        </div>
                    </div>

                    <!-- Phone Number -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">No Telefon</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $bisnes->no_tel }}</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Alamat</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $bisnes->alamat }}</p>
                        </div>
                    </div>

                    <!-- Postcode -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Poskod</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900">{{ $bisnes->poskod }}</p>
                        </div>
                    </div>

                    <!-- Created Date -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Tarikh Dicipta</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-gray-900 flex items-center">
                                <i class="far fa-calendar-plus text-gray-500 mr-2"></i>
                                @if ($bisnes->created_at)
                                    {{ $bisnes->created_at->format('d/m/Y H:i') }}
                                @else
                                    Tiada tarikh dicipta
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('bisnes.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Kembali
                    </a>
                    <a href="{{ route('bisnes.edit', $bisnes) }}"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Bisnes
                    </a>
                    <form method="POST" action="{{ route('bisnes.destroy', $bisnes) }}" class="inline"
                        onsubmit="return confirm('Adakah anda pasti ingin memadam bisnes ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="inline-flex items-center justify-center w-full sm:w-auto px-6 py-3 bg-gradient-to-r from-red-500 to-rose-600 text-white font-medium rounded-xl shadow-lg hover:from-red-600 hover:to-rose-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                            <i class="fas fa-trash mr-2"></i>
                            Padam Bisnes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
