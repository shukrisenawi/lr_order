@extends('layouts.app')

@section('title', 'Edit Tracking')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Edit Tracking</h1>
                <p class="text-gray-600">Kemaskini maklumat tracking penghantaran</p>
                <div class="flex items-center mt-2">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                        <i class="fas fa-hashtag mr-1"></i>
                        ID: {{ $tracking->id }}
                    </span>
                </div>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('tracking.show', $tracking) }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-indigo-600 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <i class="fas fa-eye mr-2"></i>
                    Lihat
                </a>
                <a href="{{ route('tracking.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Tracking
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="mb-8 p-4 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-8 p-4 bg-gradient-to-r from-red-50 to-red-50 border border-red-200 text-red-700 rounded-xl shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif

    <!-- Form Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 px-6 py-4">
            <h2 class="text-xl font-semibold text-white flex items-center">
                <i class="fas fa-edit mr-3"></i>
                Kemaskini Maklumat Tracking
            </h2>
        </div>

        <form method="POST" action="{{ route('tracking.update', $tracking) }}" class="p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Invoice Selection -->
                <div class="space-y-2">
                    <label for="invoice_id" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-file-invoice mr-2 text-blue-500"></i>
                        Invoice (Pilihan)
                    </label>
                    <select id="invoice_id" name="invoice_id"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                        <option value="">Pilih Invoice</option>
                        @foreach($invoices as $invoice)
                            <option value="{{ $invoice->id }}" {{ $tracking->invoice_id == $invoice->id ? 'selected' : '' }}>
                                Invoice #{{ $invoice->id }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Courier -->
                <div class="space-y-2">
                    <label for="kurier" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-truck mr-2 text-green-500"></i>
                        Kurier
                    </label>
                    <select id="kurier" name="kurier" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                        <option value="J&T" {{ $tracking->kurier == 'J&T' ? 'selected' : '' }}>J&T Express</option>
                        <option value="PosLaju" {{ $tracking->kurier == 'PosLaju' ? 'selected' : '' }}>Pos Laju</option>
                        <option value="DHL" {{ $tracking->kurier == 'DHL' ? 'selected' : '' }}>DHL</option>
                        <option value="FedEx" {{ $tracking->kurier == 'FedEx' ? 'selected' : '' }}>FedEx</option>
                    </select>
                </div>

                <!-- Recipient Name -->
                <div class="space-y-2">
                    <label for="nama_penerima" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-user mr-2 text-purple-500"></i>
                        Nama Penerima
                    </label>
                    <input type="text" id="nama_penerima" name="nama_penerima" value="{{ old('nama_penerima', $tracking->nama_penerima) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                        placeholder="Masukkan nama penerima">
                    @error('nama_penerima')
                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div class="space-y-2">
                    <label for="no_tel" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-phone mr-2 text-indigo-500"></i>
                        Nombor Telefon
                    </label>
                    <input type="text" id="no_tel" name="no_tel" value="{{ old('no_tel', $tracking->no_tel) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                        placeholder="Contoh: 0123456789">
                    @error('no_tel')
                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="md:col-span-2 space-y-2">
                    <label for="alamat" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                        Alamat
                    </label>
                    <textarea id="alamat" name="alamat" rows="3" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm resize-none"
                        placeholder="Masukkan alamat lengkap">{{ old('alamat', $tracking->alamat) }}</textarea>
                    @error('alamat')
                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Postcode -->
                <div class="space-y-2">
                    <label for="poskod" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-mailbox mr-2 text-yellow-500"></i>
                        Poskod
                    </label>
                    <input type="text" id="poskod" name="poskod" value="{{ old('poskod', $tracking->poskod) }}" required
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                        placeholder="Contoh: 12345">
                    @error('poskod')
                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Parcel Content -->
                <div class="space-y-2">
                    <label for="kandungan_parcel" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-box-open mr-2 text-orange-500"></i>
                        Kandungan Parcel
                    </label>
                    <input type="text" id="kandungan_parcel" name="kandungan_parcel" value="{{ old('kandungan_parcel', $tracking->kandungan_parcel) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                        placeholder="Contoh: Buku, Pakaian, Elektronik">
                    @error('kandungan_parcel')
                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Parcel Type -->
                <div class="space-y-2">
                    <label for="jenis_parcel" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-cube mr-2 text-teal-500"></i>
                        Jenis Parcel
                    </label>
                    <select id="jenis_parcel" name="jenis_parcel"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
                        <option value="">Pilih Jenis</option>
                        <option value="Document" {{ $tracking->jenis_parcel == 'Document' ? 'selected' : '' }}>Dokumen</option>
                        <option value="Package" {{ $tracking->jenis_parcel == 'Package' ? 'selected' : '' }}>Pakej</option>
                        <option value="Fragile" {{ $tracking->jenis_parcel == 'Fragile' ? 'selected' : '' }}>Mudah Pecah</option>
                    </select>
                </div>

                <!-- Weight -->
                <div class="space-y-2">
                    <label for="berat" class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-weight mr-2 text-pink-500"></i>
                        Berat (kg)
                    </label>
                    <input type="number" step="0.01" id="berat" name="berat" value="{{ old('berat', $tracking->berat) }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                        placeholder="Contoh: 1.5">
                    @error('berat')
                        <div class="mt-2 p-2 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Dimensions -->
                <div class="md:col-span-2 space-y-4">
                    <label class="block text-sm font-semibold text-gray-800 flex items-center">
                        <i class="fas fa-ruler-combined mr-2 text-cyan-500"></i>
                        Dimensi (cm)
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="space-y-2">
                            <label for="panjang" class="block text-xs font-medium text-gray-600">Panjang</label>
                            <input type="number" step="0.01" id="panjang" name="panjang" value="{{ old('panjang', $tracking->panjang) }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-white focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                                placeholder="0.00">
                        </div>
                        <div class="space-y-2">
                            <label for="lebar" class="block text-xs font-medium text-gray-600">Lebar</label>
                            <input type="number" step="0.01" id="lebar" name="lebar" value="{{ old('lebar', $tracking->lebar) }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-white focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                                placeholder="0.00">
                        </div>
                        <div class="space-y-2">
                            <label for="tinggi" class="block text-xs font-medium text-gray-600">Tinggi</label>
                            <input type="number" step="0.01" id="tinggi" name="tinggi" value="{{ old('tinggi', $tracking->tinggi) }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg bg-white focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm"
                                placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <a href="{{ route('tracking.index') }}"
                       class="inline-flex items-center justify-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-xl shadow-sm hover:shadow-md transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit"
                            class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        <i class="fas fa-save mr-2"></i>
                        Kemaskini Tracking
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
