@extends('layouts.app')

@section('title', 'Tambah Prospek Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-light text-gray-800 mb-2">Tambah Prospek Baru</h1>
            <p class="text-gray-500">Cipta prospek baru</p>
        </div>

        <!-- Form -->
        <div class="bg-white border border-gray-200">
            <div class="p-8">
                <form method="POST" action="{{ route('prospek.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- No Telefon -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">No. Telefon *</label>
                            <input type="text" name="no_tel" value="{{ old('no_tel') }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('no_tel') border-red-300 bg-red-50 @enderror">
                            @error('no_tel')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gelaran -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Nama/Gelaran *</label>
                            <input type="text" name="gelaran" value="{{ old('gelaran') }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('gelaran') border-red-300 bg-red-50 @enderror">
                            @error('gelaran')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Emel (Pilihan)</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('email') border-red-300 bg-red-50 @enderror">
                            @error('email')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bisnes -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Bisnes *</label>
                            <select name="bisnes_id" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('bisnes_id') border-red-300 bg-red-50 @enderror">
                                <option value="">Pilih Bisnes</option>
                                @foreach ($bisnes as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('bisnes_id', $selectedBisnes->id ?? '') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_bines }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bisnes_id')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('prospek.index') }}"
                            class="px-6 py-2 text-gray-600 hover:text-gray-800">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white hover:bg-gray-900">Simpan
                            Prospek</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
