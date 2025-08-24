@extends('layouts.app')

@section('title', 'Lihat Alamat Prospek')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-light text-gray-800 mb-2">Lihat Alamat Prospek</h1>
            <p class="text-gray-500">Maklumat alamat prospek</p>
        </div>

        <!-- Address Details -->
        <div class="bg-white border border-gray-200">
            <div class="p-8">
                <div class="space-y-6">
                    <!-- Prospek -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Prospek</label>
                        <div class="px-4 py-3 bg-gray-50 border border-gray-200">
                            @if ($prospekAlamat->prospek)
                                <p class="text-gray-900 font-medium">{{ $prospekAlamat->prospek->gelaran }}</p>
                                <p class="text-gray-600 text-sm">{{ $prospekAlamat->prospek->no_tel }}</p>
                                @if ($prospekAlamat->prospek->bisnes)
                                    <p class="text-gray-500 text-xs">{{ $prospekAlamat->prospek->bisnes->nama_bines }}</p>
                                @endif
                            @else
                                <p class="text-gray-500">Tiada prospek ditetapkan</p>
                            @endif
                        </div>
                    </div>

                    <!-- Nama Penerima -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Nama Penerima</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">
                            {{ $prospekAlamat->nama_penerima ?? 'Tiada' }}</p>
                    </div>

                    <!-- Alamat -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Alamat</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">{{ $prospekAlamat->alamat ?? 'Tiada' }}</p>
                    </div>

                    <!-- Bandar -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Bandar</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">{{ $prospekAlamat->bandar ?? 'Tiada' }}</p>
                    </div>

                    <!-- Poskod -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Poskod</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">{{ $prospekAlamat->poskod ?? 'Tiada' }}</p>
                    </div>

                    <!-- Negeri -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Negeri</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">{{ $prospekAlamat->negeri ?? 'Tiada' }}</p>
                    </div>

                    <!-- No Telefon -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">No Telefon</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">{{ $prospekAlamat->no_tel ?? 'Tiada' }}</p>
                    </div>

                    <!-- Tarikh Dicipta -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Tarikh Dicipta</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">
                            {{ $prospekAlamat->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>

                    <!-- Tarikh Kemaskini -->
                    <div>
                        <label class="block text-sm text-gray-600 mb-2">Tarikh Kemaskini</label>
                        <p class="px-4 py-3 bg-gray-50 border border-gray-200">
                            {{ $prospekAlamat->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>

                <!-- Alamat Lengkap -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <label class="block text-sm text-gray-600 mb-2">Alamat Lengkap</label>
                    <div class="px-4 py-3 bg-gray-50 border border-gray-200">
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
                <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ route('prospek-alamat.index') }}"
                        class="px-6 py-2 text-gray-600 hover:text-gray-800">Kembali</a>
                    <div class="flex space-x-3">
                        <a href="{{ route('prospek-alamat.edit', $prospekAlamat) }}"
                            class="px-6 py-2 bg-gray-800 text-white hover:bg-gray-900">Kemaskini</a>
                        <form method="POST" action="{{ route('prospek-alamat.destroy', $prospekAlamat) }}" class="inline"
                            onsubmit="return confirm('Adakah anda pasti mahu memadamkan alamat ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-6 py-2 bg-red-600 text-white hover:bg-red-700">Padam</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
