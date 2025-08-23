@extends('layouts.app')

@section('title', 'Edit Prospect Address')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Address</h1>
                <p class="text-gray-600">Update prospect address information</p>
            </div>
            <a href="{{ route('prospek-alamat.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Address Information</h3>
        </div>
        
        <form method="POST" action="{{ route('prospek-alamat.update', $prospekAlamat) }}" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prospect -->
                <div class="md:col-span-2">
                    <label for="prospek_id" class="block text-sm font-medium text-gray-700 mb-2">Prospect</label>
                    <select name="prospek_id" id="prospek_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('prospek_id') border-red-500 @enderror">
                        <option value="">Select Prospect</option>
                        @foreach($prospek as $prospect)
                            <option value="{{ $prospect->id }}" {{ old('prospek_id', $prospekAlamat->prospek_id) == $prospect->id ? 'selected' : '' }}>
                                {{ $prospect->gelaran }} - {{ $prospect->no_tel }}
                            </option>
                        @endforeach
                    </select>
                    @error('prospek_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <textarea name="alamat" id="alamat" rows="3" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('alamat') border-red-500 @enderror">{{ old('alamat', $prospekAlamat->alamat) }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- City -->
                <div>
                    <label for="bandar" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                    <input type="text" name="bandar" id="bandar" value="{{ old('bandar', $prospekAlamat->bandar) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bandar') border-red-500 @enderror">
                    @error('bandar')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Postcode -->
                <div>
                    <label for="poskod" class="block text-sm font-medium text-gray-700 mb-2">Postcode</label>
                    <input type="text" name="poskod" id="poskod" value="{{ old('poskod', $prospekAlamat->poskod) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('poskod') border-red-500 @enderror">
                    @error('poskod')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- State -->
                <div>
                    <label for="negeri" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                    <select name="negeri" id="negeri" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('negeri') border-red-500 @enderror">
                        <option value="">Select State</option>
                        <option value="Johor" {{ old('negeri', $prospekAlamat->negeri) == 'Johor' ? 'selected' : '' }}>Johor</option>
                        <option value="Kedah" {{ old('negeri', $prospekAlamat->negeri) == 'Kedah' ? 'selected' : '' }}>Kedah</option>
                        <option value="Kelantan" {{ old('negeri', $prospekAlamat->negeri) == 'Kelantan' ? 'selected' : '' }}>Kelantan</option>
                        <option value="Melaka" {{ old('negeri', $prospekAlamat->negeri) == 'Melaka' ? 'selected' : '' }}>Melaka</option>
                        <option value="Negeri Sembilan" {{ old('negeri', $prospekAlamat->negeri) == 'Negeri Sembilan' ? 'selected' : '' }}>Negeri Sembilan</option>
                        <option value="Pahang" {{ old('negeri', $prospekAlamat->negeri) == 'Pahang' ? 'selected' : '' }}>Pahang</option>
                        <option value="Perak" {{ old('negeri', $prospekAlamat->negeri) == 'Perak' ? 'selected' : '' }}>Perak</option>
                        <option value="Perlis" {{ old('negeri', $prospekAlamat->negeri) == 'Perlis' ? 'selected' : '' }}>Perlis</option>
                        <option value="Pulau Pinang" {{ old('negeri', $prospekAlamat->negeri) == 'Pulau Pinang' ? 'selected' : '' }}>Pulau Pinang</option>
                        <option value="Sabah" {{ old('negeri', $prospekAlamat->negeri) == 'Sabah' ? 'selected' : '' }}>Sabah</option>
                        <option value="Sarawak" {{ old('negeri', $prospekAlamat->negeri) == 'Sarawak' ? 'selected' : '' }}>Sarawak</option>
                        <option value="Selangor" {{ old('negeri', $prospekAlamat->negeri) == 'Selangor' ? 'selected' : '' }}>Selangor</option>
                        <option value="Terengganu" {{ old('negeri', $prospekAlamat->negeri) == 'Terengganu' ? 'selected' : '' }}>Terengganu</option>
                        <option value="Kuala Lumpur" {{ old('negeri', $prospekAlamat->negeri) == 'Kuala Lumpur' ? 'selected' : '' }}>Kuala Lumpur</option>
                        <option value="Labuan" {{ old('negeri', $prospekAlamat->negeri) == 'Labuan' ? 'selected' : '' }}>Labuan</option>
                        <option value="Putrajaya" {{ old('negeri', $prospekAlamat->negeri) == 'Putrajaya' ? 'selected' : '' }}>Putrajaya</option>
                    </select>
                    @error('negeri')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Country -->
                <div>
                    <label for="negara" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                    <input type="text" name="negara" id="negara" value="{{ old('negara', $prospekAlamat->negara) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('negara') border-red-500 @enderror">
                    @error('negara')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('prospek-alamat.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Update Address
                </button>
            </div>
        </form>
    </div>
@endsection
