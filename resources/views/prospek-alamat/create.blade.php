@extends('layouts.app')

@section('title', 'Tambah Alamat Prospek Baru')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-2xl font-light text-gray-800 mb-2">Tambah Alamat Prospek Baru</h1>
            <p class="text-gray-500">Cipta alamat baru untuk prospek</p>
        </div>

        <!-- Form -->
        <div class="bg-white border border-gray-200">
            <div class="p-8">
                <form method="POST" action="{{ route('prospek-alamat.store') }}">
                    @csrf

                    <div class="space-y-6">
                        <!-- Prospek -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Prospek *</label>
                            <select name="prospek_id" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('prospek_id') border-red-300 bg-red-50 @enderror">
                                <option value="">Pilih Prospek</option>
                                @foreach($prospek as $item)
                                    <option value="{{ $item->id }}" {{ old('prospek_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->gelaran }} - {{ $item->no_tel }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prospek_id')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Alamat -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Alamat *</label>
                            <textarea name="alamat" rows="3" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('alamat') border-red-300 bg-red-50 @enderror">{{ old('alamat') }}</textarea>
                            @error('alamat')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bandar -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Bandar *</label>
                            <input type="text" name="bandar" value="{{ old('bandar') }}" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('bandar') border-red-300 bg-red-50 @enderror">
                            @error('bandar')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poskod -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Poskod *</label>
                            <input type="text" name="poskod" value="{{ old('poskod') }}" required maxlength="5"
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('poskod') border-red-300 bg-red-50 @enderror">
                            @error('poskod')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Negeri -->
                        <div>
                            <label class="block text-sm text-gray-600 mb-2">Negeri *</label>
                            <select name="negeri" required
                                class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none @error('negeri') border-red-300 bg-red-50 @enderror">
                                <option value="">Pilih Negeri</option>
                                <option value="Johor" {{ old('negeri') == 'Johor' ? 'selected' : '' }}>Johor</option>
                                <option value="Kedah" {{ old('negeri') == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                                <option value="Kelantan" {{ old('negeri') == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                                <option value="Melaka" {{ old('negeri') == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                                <option value="Negeri Sembilan" {{ old('negeri') == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                                <option value="Pahang" {{ old('negeri') == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                                <option value="Perak" {{ old('negeri') == 'Perak' ? 'selected' : '' }}>Perak</option>
                                <option value="Perlis" {{ old('negeri') == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                                <option value="Pulau Pinang" {{ old('negeri') == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                                <option value="Sabah" {{ old('negeri') == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                                <option value="Sarawak" {{ old('negeri') == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                                <option value="Selangor" {{ old('negeri') == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                                <option value="Terengganu" {{ old('negeri') == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                                <option value="Kuala Lumpur" {{ old('negeri') == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                                <option value="Labuan" {{ old('negeri') == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                                <option value="Putrajaya" {{ old('negeri') == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                            </select>
                            @error('negeri')
                                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('prospek-alamat.index') }}" class="px-6 py-2 text-gray-600 hover:text-gray-800">Batal</a>
                        <button type="submit" class="px-6 py-2 bg-gray-800 text-white hover:bg-gray-900">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
