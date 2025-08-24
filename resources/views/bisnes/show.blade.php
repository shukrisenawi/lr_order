@extends('layouts.app')

@section('title', 'View Bisnes')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">View Bisnes</h1>
                <p class="text-gray-600">Business details</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('bisnes.edit', $bisnes) }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit
                </a>
                <a href="{{ route('bisnes.index') }}"
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Business Details -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Business Information</h3>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Business Image -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Business Image</label>
                    @if ($bisnes->gambar)
                        <img src="{{ \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) }}"
                            alt="{{ $bisnes->nama_bines }}"
                            class="w-32 h-32 rounded-lg object-cover border border-gray-300">
                    @else
                        <div
                            class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center border border-gray-300">
                            <i class="fas fa-building text-gray-400 text-2xl"></i>
                        </div>
                    @endif
                </div>

                <!-- Business Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Bisnes</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $bisnes->nama_bines }}</p>
                </div>

                <!-- Company Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nama Syarikat</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $bisnes->nama_syarikat }}</p>
                </div>

                <!-- Registration Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Pendaftaran</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $bisnes->no_pendaftaran }}</p>
                </div>

                <!-- Business Type -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Bisnes</label>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $bisnes->jenis_bisnes }}
                    </span>
                </div>

                <!-- Expiry Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh Tamat</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        @if ($bisnes->exp_date)
                            {{ \Carbon\Carbon::parse($bisnes->exp_date)->format('d/m/Y') }}
                        @else
                            Tiada tarikh tamat
                        @endif
                    </p>
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">No Telefon</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $bisnes->no_tel }}</p>
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alamat</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $bisnes->alamat }}</p>
                </div>

                <!-- Postcode -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Poskod</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">{{ $bisnes->poskod }}</p>
                </div>

                <!-- Created Date -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh Dicipta</label>
                    <p class="text-gray-900 bg-gray-50 px-3 py-2 rounded-lg">
                        @if ($bisnes->created_at)
                            {{ $bisnes->created_at->format('d/m/Y H:i') }}
                        @else
                            Tiada tarikh dicipta
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <a href="{{ route('bisnes.edit', $bisnes) }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Edit Bisnes
        </a>
        <form method="POST" action="{{ route('bisnes.destroy', $bisnes) }}" class="inline"
            onsubmit="return confirm('Adakah anda pasti ingin memadam bisnes ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center">
                <i class="fas fa-trash mr-2"></i>
                Delete Bisnes
            </button>
        </form>
    </div>
@endsection
