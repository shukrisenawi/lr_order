@extends('layouts.app')

@section('title', 'Create Tracking')

@section('content')
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Tracking</h1>
                <p class="text-gray-600">Add new shipment tracking information</p>
            </div>
            <a href="{{ route('tracking.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Tracking
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <form method="POST" action="{{ route('tracking.store') }}">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Invoice Selection -->
                <div>
                    <label for="invoice_id" class="block text-sm font-medium text-gray-700">Invoice (Optional)</label>
                    <select id="invoice_id" name="invoice_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Invoice</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}">Invoice #{{ $invoice->id }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Courier -->
                <div>
                    <label for="kurier" class="block text-sm font-medium text-gray-700">Courier</label>
                    <select id="kurier" name="kurier" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="J&T">J&T Express</option>
                        <option value="PosLaju">Pos Laju</option>
                        <option value="DHL">DHL</option>
                        <option value="FedEx">FedEx</option>
                    </select>
                </div>

                <!-- Recipient Name -->
                <div>
                    <label for="nama_penerima" class="block text-sm font-medium text-gray-700">Recipient Name</label>
                    <input type="text" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('nama_penerima')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="no_tel" class="block text-sm font-medium text-gray-700">Phone Number</label>
                    <input type="text" id="no_tel" name="no_tel" value="{{ old('no_tel') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('no_tel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2">
                    <label for="alamat" class="block text-sm font-medium text-gray-700">Address</label>
                    <textarea id="alamat" name="alamat" rows="3" required
                              class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Postcode -->
                <div>
                    <label for="poskod" class="block text-sm font-medium text-gray-700">Postcode</label>
                    <input type="text" id="poskod" name="poskod" value="{{ old('poskod') }}" required
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('poskod')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parcel Content -->
                <div>
                    <label for="kandungan_parcel" class="block text-sm font-medium text-gray-700">Parcel Content</label>
                    <input type="text" id="kandungan_parcel" name="kandungan_parcel" value="{{ old('kandungan_parcel') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('kandungan_parcel')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Parcel Type -->
                <div>
                    <label for="jenis_parcel" class="block text-sm font-medium text-gray-700">Parcel Type</label>
                    <select id="jenis_parcel" name="jenis_parcel" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Select Type</option>
                        <option value="Document">Document</option>
                        <option value="Package">Package</option>
                        <option value="Fragile">Fragile</option>
                    </select>
                </div>

                <!-- Weight -->
                <div>
                    <label for="berat" class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                    <input type="text" id="berat" name="berat" value="{{ old('berat') }}"
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('berat')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dimensions -->
                <div class="grid grid-cols-3 gap-4 md:col-span-2">
                    <div>
                        <label for="panjang" class="block text-sm font-medium text-gray-700">Length (cm)</label>
                        <input type="text" id="panjang" name="panjang" value="{{ old('panjang') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="lebar" class="block text-sm font-medium text-gray-700">Width (cm)</label>
                        <input type="text" id="lebar" name="lebar" value="{{ old('lebar') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label for="tinggi" class="block text-sm font-medium text-gray-700">Height (cm)</label>
                        <input type="text" id="tinggi" name="tinggi" value="{{ old('tinggi') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('tracking.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-lg mr-3">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    Create Tracking
                </button>
            </div>
        </form>
    </div>
@endsection
