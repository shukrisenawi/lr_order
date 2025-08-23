@extends('layouts.app')

@section('title', 'Create Prospect')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Prospect</h1>
                <p class="text-gray-600">Add a new prospect to your customer list</p>
            </div>
            <a href="{{ route('prospek.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Create Form -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Prospect Information</h3>
        </div>
        
        <form method="POST" action="{{ route('prospek.store') }}" class="p-6">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Phone Number -->
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700 mb-2">No Telefon</label>
                    <input type="text" name="no_tel" id="no_tel" value="{{ old('no_tel') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('no_tel') border-red-500 @enderror">
                    @error('no_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title/Greeting -->
                <div>
                    <label for="gelaran" class="block text-sm font-medium text-gray-700 mb-2">Gelaran</label>
                    <select name="gelaran" id="gelaran" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('gelaran') border-red-500 @enderror">
                        <option value="">Select Gelaran</option>
                        <option value="Encik" {{ old('gelaran') == 'Encik' ? 'selected' : '' }}>Encik</option>
                        <option value="Puan" {{ old('gelaran') == 'Puan' ? 'selected' : '' }}>Puan</option>
                        <option value="Cik" {{ old('gelaran') == 'Cik' ? 'selected' : '' }}>Cik</option>
                        <option value="Dato" {{ old('gelaran') == 'Dato' ? 'selected' : '' }}>Dato</option>
                        <option value="Datuk" {{ old('gelaran') == 'Datuk' ? 'selected' : '' }}>Datuk</option>
                        <option value="Tan Sri" {{ old('gelaran') == 'Tan Sri' ? 'selected' : '' }}>Tan Sri</option>
                        <option value="Dr" {{ old('gelaran') == 'Dr' ? 'selected' : '' }}>Dr</option>
                    </select>
                    @error('gelaran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Business -->
                <div class="md:col-span-2">
                    <label for="bisnes_id" class="block text-sm font-medium text-gray-700 mb-2">Business</label>
                    <select name="bisnes_id" id="bisnes_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('bisnes_id') border-red-500 @enderror">
                        <option value="">Select Business</option>
                        @foreach($bisnes as $business)
                            <option value="{{ $business->id }}" {{ old('bisnes_id') == $business->id ? 'selected' : '' }}>
                                {{ $business->nama_bines }} - {{ $business->nama_syarikat }}
                            </option>
                        @endforeach
                    </select>
                    @error('bisnes_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('prospek.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Create Prospect
                </button>
            </div>
        </form>
    </div>
@endsection
