@php
    use Illuminate\Support\Str;
@endphp
<div>
    <div class="px-6 py-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex items-center space-x-3">
                <div class="bg-gradient-to-r from-indigo-500 to-purple-500 p-2 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900">
                        Data Scan Cula
                        <span class="text-sm font-normal text-gray-500">
                            -
                            {{ $activeTab === 'baru' ? 'Data Baru (Menunggu Persetujuan)' : 'Rekod Cula (Telah Disetujui)' }}
                        </span>
                    </h2>
                    <p class="text-sm text-gray-600">
                        {{ $activeTab === 'baru' ? 'Kelola data scan cula yang belum disetujui' : 'Pantau data scan cula yang telah disetujui' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="px-6 py-0">
        <!-- Tab Navigation -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                    <!-- Tab Baru (approve=0) -->
                    <button style="cursor: pointer" wire:click="setActiveTab('baru')"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200 {{ $activeTab === 'baru' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 {{ $activeTab === 'baru' ? 'text-indigo-500' : 'text-gray-400' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Baru
                            <span
                                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activeTab === 'baru' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ \App\Models\ScanCula::where('approve', false)->count() }}
                            </span>
                        </div>
                    </button>

                    <!-- Tab Rekod Cula (approve=1) -->
                    <button style="cursor: pointer" wire:click="setActiveTab('rekod')"
                        class="whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm transition-all duration-200 {{ $activeTab === 'rekod' ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 {{ $activeTab === 'rekod' ? 'text-indigo-500' : 'text-gray-400' }}"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Rekod Cula
                            <span
                                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $activeTab === 'rekod' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ \App\Models\ScanCula::where('approve', true)->count() }}
                            </span>
                        </div>
                    </button>
                </nav>
            </div>
        </div>

        <!-- Search Form -->
        <div class="mb-6">
            <div class="relative max-w-md">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <input wire:model.live="search" type="text"
                    class="block w-full pl-12 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white placeholder-gray-400 focus:outline-none focus:placeholder-gray-600 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 shadow-sm"
                    placeholder="Cari berdasarkan nama, no KP, atau alamat...">
                @if ($search)
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center">
                        <button wire:click="$set('search', '')"
                            class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
            @if ($search)
                <p class="mt-2 text-sm text-gray-600">
                    Menampilkan hasil untuk: <span class="font-medium text-indigo-600">"{!! $search !!}"</span>
                </p>
            @endif
        </div>

        <!-- Bulk Actions Bar -->
        @if (!empty($selectedItems))
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-sm font-medium text-blue-800">
                            {{ count($selectedItems) }} item dipilih
                        </span>
                    </div>
                    <div class="flex space-x-2">
                        @if ($activeTab === 'baru')
                            <button wire:click="bulkApprove" wire:loading.attr="disabled"
                                wire:loading.class="opacity-50 cursor-not-allowed" wire:target="bulkApprove"
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span wire:loading.remove wire:target="bulkApprove">Setujui Terpilih</span>
                                <span wire:loading wire:target="bulkApprove">Menyetujui...</span>
                            </button>
                        @elseif ($activeTab === 'rekod')
                            <button wire:click="bulkUnapprove"
                                class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal Setuju Terpilih
                            </button>
                        @endif
                        <button wire:click="bulkDelete"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus {{ count($selectedItems) }} item yang dipilih?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                </path>
                            </svg>
                            Hapus Terpilih
                        </button>
                        <button wire:click="$set('selectedItems', [])"
                            class="inline-flex items-center px-4 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal Pilih
                        </button>
                    </div>
                </div>
            </div>
        @endif

        <!-- Data Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Desktop Table View -->
            <div class="hidden md:block">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                            <tr>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    <input type="checkbox" wire:model.live="selectAll"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                </th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    No KP</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Nama Pemilih</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Alamat</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Cula</th>
                                <th
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($scanCulas as $scanCula)
                                <tr class="table-row hover:bg-indigo-50/30 transition-colors duration-200"
                                    data-row-id="{{ $scanCula->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <input type="checkbox" wire:model.live="selectedItems"
                                            value="{{ $scanCula->id }}"
                                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        @if ($editingNoKpId === $scanCula->id)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" wire:model="editingNoKpValue"
                                                    wire:keydown.enter="saveNoKp({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingNoKp"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-sm border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Masukkan no_kp...">
                                                <button wire:click="saveNoKp({{ $scanCula->id }})"
                                                    class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                    title="Simpan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="cancelEditingNoKp"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2 group">
                                                <span>{{ $scanCula->no_kp }}</span>
                                                <button wire:click="startEditingNoKp({{ $scanCula->id }})"
                                                    class="edit-nokp-btn p-1 text-indigo-600 hover:bg-indigo-50 rounded opacity-0 group-hover:opacity-100 transition-opacity"
                                                    title="Edit no_kp">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if ($editingNamaPemilihId === $scanCula->id)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" wire:model="editingNamaPemilihValue"
                                                    wire:keydown.enter="saveNamaPemilih({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingNamaPemilih"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-sm border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Masukkan nama pemilih...">
                                                <button wire:click="saveNamaPemilih({{ $scanCula->id }})"
                                                    class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                    title="Simpan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="cancelEditingNamaPemilih"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2 group">
                                                <span>{{ $scanCula->nama_pemilih }}</span>
                                                <button wire:click="startEditingNamaPemilih({{ $scanCula->id }})"
                                                    class="edit-namapemilih-btn p-1 text-indigo-600 hover:bg-indigo-50 rounded opacity-0 group-hover:opacity-100 transition-opacity"
                                                    title="Edit nama pemilih">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700 max-w-xs">
                                        @if ($editingAlamatId === $scanCula->id)
                                            <div class="flex items-center space-x-2">
                                                <textarea wire:model="editingAlamatValue"
                                                    wire:keydown.ctrl.enter="saveAlamat({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingAlamat"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-sm border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                                                    rows="2"
                                                    placeholder="Masukkan alamat...">{{ $editingAlamatValue }}</textarea>
                                                <div class="flex flex-col space-y-1">
                                                    <button wire:click="saveAlamat({{ $scanCula->id }})"
                                                        class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                        title="Simpan">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                    <button wire:click="cancelEditingAlamat"
                                                        class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <div class="flex items-start space-x-2 group">
                                                <span class="truncate" title="{{ $scanCula->alamat }}">{{ Str::limit($scanCula->alamat, 40) }}</span>
                                                <button wire:click="startEditingAlamat({{ $scanCula->id }})"
                                                    class="edit-alamat-btn p-1 text-indigo-600 hover:bg-indigo-50 rounded opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0"
                                                    title="Edit alamat">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-indigo-600">
                                        @if ($editingCulaId === $scanCula->id)
                                            <div class="flex items-center space-x-2">
                                                <input type="text" wire:model="editingCulaValue"
                                                    wire:keydown.enter="saveCula({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingCula"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-sm border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Masukkan cula...">
                                                <button wire:click="saveCula({{ $scanCula->id }})"
                                                    class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                    title="Simpan">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="cancelEditingCula"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex items-center space-x-2 group">
                                                <span>{{ $scanCula->cula }}</span>
                                                <button wire:click="startEditingCula({{ $scanCula->id }})"
                                                    class="edit-cula-btn p-1 text-indigo-600 hover:bg-indigo-50 rounded opacity-0 group-hover:opacity-100 transition-opacity"
                                                    title="Edit cula">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if (!$scanCula->approve)
                                                <form wire:submit.prevent="submitApprove({{ $scanCula->id }})" class="inline-block">
                                                    <button type="submit"
                                                        wire:loading.class="opacity-50 cursor-not-allowed"
                                                        onclick="console.log('Approve button clicked for ID: {{ $scanCula->id }}')"
                                                        class="inline-flex items-center px-3 py-1.5 bg-green-50 text-green-700 text-xs font-medium rounded-lg hover:bg-green-100 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span wire:loading.remove
                                                            wire:target="submitApprove({{ $scanCula->id }})">Setuju</span>
                                                        <span wire:loading
                                                            wire:target="submitApprove({{ $scanCula->id }})">Menyetujui...</span>
                                                    </button>
                                                </form>
                                            @else
                                                <button style="cursor: pointer"
                                                    wire:click="unapprove({{ $scanCula->id }})"
                                                    class="inline-flex items-center px-3 py-1.5 bg-orange-50 text-orange-700 text-xs font-medium rounded-lg hover:bg-orange-100 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                    Batal Setuju
                                                </button>
                                            @endif
                                            <button
                                                onclick="copyToClipboard('/kemascula {{ $scanCula->no_kp }}', this)"
                                                class="copy-button inline-flex items-center px-3 py-1.5 bg-purple-500 text-white text-xs font-medium rounded-lg hover:bg-purple-600 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span class="copy-text">Copy Code</span>
                                                <span class="copied-text hidden">Copied!</span>
                                            </button>
                                            {{-- <button wire:click="edit({{ $scanCula->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-blue-50 text-blue-700 text-xs font-medium rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </button> --}}
                                            <button wire:click="delete({{ $scanCula->id }})"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-700 text-xs font-medium rounded-lg hover:bg-red-100 transition-colors duration-200"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">
                                                {{ $activeTab === 'baru' ? 'Belum ada data baru' : 'Belum ada rekod cula' }}
                                            </h3>
                                            <p class="text-gray-500">
                                                {{ $activeTab === 'baru' ? 'Data scan cula baru akan muncul di sini setelah ditambahkan.' : 'Data scan cula yang telah disetujui akan muncul di sini.' }}
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Mobile Bulk Actions Bar -->
            @if (!empty($selectedItems))
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4 md:hidden">
                    <div class="flex flex-col space-y-3">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm font-medium text-blue-800">
                                {{ count($selectedItems) }} item dipilih
                            </span>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @if ($activeTab === 'baru')
                                <button wire:click="bulkApprove" wire:loading.attr="disabled"
                                    wire:loading.class="opacity-50 cursor-not-allowed" wire:target="bulkApprove"
                                    class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-sm font-medium rounded-lg hover:bg-green-700 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span wire:loading.remove wire:target="bulkApprove">Setujui</span>
                                    <span wire:loading wire:target="bulkApprove">Menyetujui...</span>
                                </button>
                            @elseif ($activeTab === 'rekod')
                                <button wire:click="bulkUnapprove"
                                    class="inline-flex items-center px-3 py-2 bg-orange-600 text-white text-sm font-medium rounded-lg hover:bg-orange-700 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    Batal Setuju
                                </button>
                            @endif
                            <button wire:click="bulkDelete"
                                class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors duration-200"
                                onclick="return confirm('Apakah Anda yakin ingin menghapus {{ count($selectedItems) }} item yang dipilih?')">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Hapus
                            </button>
                            <button wire:click="$set('selectedItems', [])"
                                class="inline-flex items-center px-3 py-2 bg-gray-600 text-white text-sm font-medium rounded-lg hover:bg-gray-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Batal
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Mobile Card View -->
            <div class="md:hidden">
                <!-- Mobile Master Checkbox -->
                <div class="p-4 bg-gray-50 border-b border-gray-200">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model.live="selectAll"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded mr-3">
                        <span class="text-sm font-medium text-gray-700">Pilih Semua</span>
                    </label>
                </div>
                <div class="divide-y divide-gray-200">
                    @forelse($scanCulas as $scanCula)
                        <div class="mobile-card p-4 hover:bg-gray-50 transition-colors duration-200"
                            data-card-id="{{ $scanCula->id }}">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" wire:model.live="selectedItems"
                                        value="{{ $scanCula->id }}"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded mr-3">
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center space-x-2 mb-2">
                                        @if ($editingNamaPemilihId === $scanCula->id)
                                            <div class="flex items-center space-x-2 flex-1">
                                                <input type="text" wire:model="editingNamaPemilihValue"
                                                    wire:keydown.enter="saveNamaPemilih({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingNamaPemilih"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-xs border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Masukkan nama pemilih...">
                                                <button wire:click="saveNamaPemilih({{ $scanCula->id }})"
                                                    class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                    title="Simpan">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="cancelEditingNamaPemilih"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <h4 class="text-sm font-medium text-gray-900 truncate flex-1">
                                                {{ $scanCula->nama_pemilih }}</h4>
                                            <button wire:click="startEditingNamaPemilih({{ $scanCula->id }})"
                                                class="edit-namapemilih-btn p-1 text-indigo-600 hover:bg-indigo-50 rounded flex-shrink-0"
                                                title="Edit nama pemilih">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $scanCula->approve ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} flex-shrink-0">
                                            {{ $scanCula->approve ? '✓' : '○' }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-600 mb-1">
                                        <strong>KP:</strong>
                                        @if ($editingNoKpId === $scanCula->id)
                                            <div class="flex items-center space-x-2 mt-1">
                                                <input type="text" wire:model="editingNoKpValue"
                                                    wire:keydown.enter="saveNoKp({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingNoKp"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-xs border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Masukkan no_kp...">
                                                <button wire:click="saveNoKp({{ $scanCula->id }})"
                                                    class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                    title="Simpan">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="cancelEditingNoKp"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <span>{{ $scanCula->no_kp }}</span>
                                            <button wire:click="startEditingNoKp({{ $scanCula->id }})"
                                                class="edit-nokp-btn ml-1 p-1 text-indigo-600 hover:bg-indigo-50 rounded inline-block"
                                                title="Edit no_kp">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-600 mb-1">
                                        <strong>Cula:</strong>
                                        @if ($editingCulaId === $scanCula->id)
                                            <div class="flex items-center space-x-2 mt-1">
                                                <input type="text" wire:model="editingCulaValue"
                                                    wire:keydown.enter="saveCula({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingCula"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-xs border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                                    placeholder="Masukkan cula...">
                                                <button wire:click="saveCula({{ $scanCula->id }})"
                                                    class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                    title="Simpan">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                    </svg>
                                                </button>
                                                <button wire:click="cancelEditingCula"
                                                    class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @else
                                            <span class="font-medium text-indigo-600">{{ $scanCula->cula }}</span>
                                            <button wire:click="startEditingCula({{ $scanCula->id }})"
                                                class="edit-cula-btn ml-1 p-1 text-indigo-600 hover:bg-indigo-50 rounded inline-block"
                                                title="Edit cula">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-600">
                                        <strong>Alamat:</strong>
                                        @if ($editingAlamatId === $scanCula->id)
                                            <div class="flex items-center space-x-2 mt-1">
                                                <textarea wire:model="editingAlamatValue"
                                                    wire:keydown.ctrl.enter="saveAlamat({{ $scanCula->id }})"
                                                    wire:keydown.escape="cancelEditingAlamat"
                                                    class="inline-edit-input flex-1 px-2 py-1 text-xs border border-indigo-300 rounded focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 resize-none"
                                                    rows="2"
                                                    placeholder="Masukkan alamat...">{{ $editingAlamatValue }}</textarea>
                                                <div class="flex flex-col space-y-1">
                                                    <button wire:click="saveAlamat({{ $scanCula->id }})"
                                                        class="p-1 text-green-600 hover:bg-green-50 rounded"
                                                        title="Simpan">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                    <button wire:click="cancelEditingAlamat"
                                                        class="p-1 text-red-600 hover:bg-red-50 rounded" title="Batal">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @else
                                            <span class="truncate block" title="{{ $scanCula->alamat }}">{{ Str::limit($scanCula->alamat, 30) }}</span>
                                            <button wire:click="startEditingAlamat({{ $scanCula->id }})"
                                                class="edit-alamat-btn ml-1 p-1 text-indigo-600 hover:bg-indigo-50 rounded inline-block"
                                                title="Edit alamat">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </p>
                                </div>
                                <div class="flex space-x-2 ml-4">
                                    @if (!$scanCula->approve)
                                        <form wire:submit.prevent="submitApprove({{ $scanCula->id }})" class="inline-block">
                                            <button type="submit"
                                                wire:loading.attr="disabled"
                                                wire:loading.class="opacity-50 cursor-not-allowed"
                                                wire:target="submitApprove({{ $scanCula->id }})"
                                                class="p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                                title="Setujui data">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <button wire:click="unapprove({{ $scanCula->id }})"
                                            class="p-2 text-orange-600 hover:bg-orange-50 rounded-lg transition-colors duration-200"
                                            title="Batal setujui">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    @endif
                                    <button onclick="copyToClipboard('/kemascula {{ $scanCula->no_kp }}', this)"
                                        class="copy-button p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200"
                                        title="Copy Code">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="edit({{ $scanCula->id }})"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-200"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                            </path>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $scanCula->id }})"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"
                                        title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">
                                {{ $activeTab === 'baru' ? 'Belum ada data baru' : 'Belum ada rekod cula' }}
                            </h3>
                            <p class="text-gray-500">
                                {{ $activeTab === 'baru' ? 'Data scan cula baru akan muncul di sini setelah ditambahkan.' : 'Data scan cula yang telah disetujui akan muncul di sini.' }}
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Enhanced Pagination -->
            @if (method_exists($scanCulas, 'links'))
                <div class="bg-gradient-to-r from-gray-50 to-gray-100 px-6 py-4 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            Menampilkan <span class="font-medium">{{ $scanCulas->firstItem() ?? 0 }}</span> sampai
                            <span class="font-medium">{{ $scanCulas->lastItem() ?? 0 }}</span> dari <span
                                class="font-medium">{{ $scanCulas->total() }}</span> hasil
                        </div>
                        <div class="flex items-center space-x-2">
                            {{ $scanCulas->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            @endif

            <style>
                .copy-button.copied-permanently {
                    background-color: #10b981 !important;
                    /* green-500 */
                    border-color: #10b981 !important;
                }

                .copy-button.copied-permanently:hover {
                    background-color: #059669 !important;
                    /* green-600 */
                    border-color: #059669 !important;
                }

                .copy-button.copied-permanently .copy-text {
                    display: none !important;
                }

                .copy-button.copied-permanently .copied-text {
                    display: inline !important;
                }

                /* Row highlight styles */
                .table-row.copying-row {
                    background-color: #fef3c7 !important;
                    /* yellow-50 */
                    border-left: 4px solid #f59e0b !important;
                    /* yellow-500 */
                    transition: all 0.3s ease;
                }

                .mobile-card.copying-card {
                    background-color: #fef3c7 !important;
                    /* yellow-50 */
                    border-left: 4px solid #f59e0b !important;
                    /* yellow-500 */
                    transition: all 0.3s ease;
                }

                /* Smooth transitions for all row highlights */
                .table-row,
                .mobile-card {
                    transition: background-color 0.3s ease, border-left 0.3s ease;
                }

                /* Inline editing styles */
                .inline-edit-input {
                    min-width: 120px;
                }

                .inline-edit-input:focus {
                    outline: none;
                    box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.2);
                }

                /* Hide edit button on mobile by default, show on hover/tap */
                @media (max-width: 768px) {
                    .edit-cula-btn,
                    .edit-nokp-btn,
                    .edit-namapemilih-btn,
                    .edit-alamat-btn {
                        opacity: 0.7;
                    }
                }
            </style>

            <script>
                function copyToClipboard(text, button) {
                    // Find the parent row or card to highlight
                    const tableRow = button.closest('.table-row');
                    const mobileCard = button.closest('.mobile-card');

                    // Copy text to clipboard
                    navigator.clipboard.writeText(text).then(function() {
                        // Add permanent copied class for color change
                        button.classList.add('copied-permanently');

                        // Remove highlight from all other rows/cards first
                        document.querySelectorAll('.table-row.copying-row').forEach(row => {
                            if (row !== tableRow) {
                                row.classList.remove('copying-row');
                            }
                        });
                        document.querySelectorAll('.mobile-card.copying-card').forEach(card => {
                            if (card !== mobileCard) {
                                card.classList.remove('copying-card');
                            }
                        });

                        // Highlight the current row/card
                        if (tableRow) {
                            tableRow.classList.add('copying-row');
                        } else if (mobileCard) {
                            mobileCard.classList.add('copying-card');
                        }

                        // Show success feedback
                        const copyText = button.querySelector('.copy-text');
                        const copiedText = button.querySelector('.copied-text');

                        if (copyText && copiedText) {
                            copyText.classList.add('hidden');
                            copiedText.classList.remove('hidden');

                            // Keep the "Copied!" text visible permanently
                            // Don't reset the text back to "Copy Code"
                        }

                        // Optional: Show toast notification
                        showToast('Code berhasil disalin!', 'success');
                    }).catch(function(err) {
                        console.error('Failed to copy: ', err);
                        showToast('Gagal menyalin code', 'error');
                    });
                }

                function showToast(message, type) {
                    // Create toast element
                    const toast = document.createElement('div');
                    toast.className = `fixed top-4 right-4 px-4 py-2 rounded-lg text-white text-sm font-medium z-50 transition-all duration-300 ${
                        type === 'success' ? 'bg-green-500' : 'bg-red-500'
                    }`;
                    toast.textContent = message;

                    // Add to page
                    document.body.appendChild(toast);

                    // Remove after 3 seconds
                    setTimeout(function() {
                        toast.remove();
                    }, 3000);
                }

                // Bulk selection helper functions
                function toggleAllCheckboxes(checked) {
                    const checkboxes = document.querySelectorAll('input[type="checkbox"][wire\\:model\\.live="selectedItems"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = checked;
                    });
                }

                function updateSelectionCount() {
                    const selectedCheckboxes = document.querySelectorAll(
                        'input[type="checkbox"][wire\\:model\\.live="selectedItems"]:checked');
                    const count = selectedCheckboxes.length;

                    // Update any selection count displays
                    const countDisplays = document.querySelectorAll('.selection-count');
                    countDisplays.forEach(display => {
                        display.textContent = count + ' item dipilih';
                    });

                    return count;
                }

                // Listen for checkbox changes to update UI
                document.addEventListener('change', function(e) {
                    if (e.target.matches('input[type="checkbox"][wire\\:model\\.live="selectedItems"]')) {
                        updateSelectionCount();
                    }
                });

                // Listen for Livewire updates to refresh selection state
                document.addEventListener('livewire:updated', function() {
                    updateSelectionCount();
                });

                // Debug approve button clicks
                document.addEventListener('click', function(e) {
                    if (e.target.closest('button[wire\\:click*="approve"]')) {
                        console.log('Approve button clicked:', e.target);
                    }
                });

                // Listen for Livewire errors
                document.addEventListener('livewire:error', function(e) {
                    console.error('Livewire error:', e.detail);
                    showToast('Terjadi kesalahan: ' + e.detail.message, 'error');
                });
            </script>
        </div>
    </div>

    <!-- Enhanced Modal -->
    @if ($isOpen)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Background overlay with blur -->
                <div class="fixed inset-0 bg-gray-900 bg-opacity-50 backdrop-blur-sm transition-opacity"
                    aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Modal panel -->
                <div
                    class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="bg-white/20 p-2 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-white" id="modal-title">
                                    {{ $scanCulaId ? 'Edit Data Scan Cula' : 'Tambah Data Scan Cula' }}
                                </h3>
                            </div>
                            <button wire:click="closeModal"
                                class="text-white/70 hover:text-white transition-colors duration-200">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form Content -->
                    <div class="px-6 py-6">
                        <form wire:submit.prevent="store" class="space-y-6">
                            <!-- No KP Field -->
                            <div>
                                <label for="no_kp" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2">
                                            </path>
                                        </svg>
                                        No KP
                                    </span>
                                </label>
                                <input type="text" wire:model="no_kp" id="no_kp"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Masukkan nomor KP" required>
                                @error('no_kp')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Nama Pemilih Field -->
                            <div>
                                <label for="nama_pemilih" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                        Nama Pemilih
                                    </span>
                                </label>
                                <input type="text" wire:model="nama_pemilih" id="nama_pemilih"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Masukkan nama pemilih" required>
                                @error('nama_pemilih')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Alamat Field -->
                            <div>
                                <label for="alamat" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Alamat
                                    </span>
                                </label>
                                <textarea wire:model="alamat" id="alamat" rows="3"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white resize-none"
                                    placeholder="Masukkan alamat lengkap" required></textarea>
                                @error('alamat')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Cula Field -->
                            <div>
                                <label for="cula" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                            </path>
                                        </svg>
                                        Cula
                                    </span>
                                </label>
                                <input type="text" wire:model="cula" id="cula"
                                    class="block w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Masukkan data cula" required>
                                @error('cula')
                                    <p class="mt-2 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Approve Checkbox -->
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                <input id="approve" type="checkbox" wire:model="approve"
                                    class="h-5 w-5 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded transition-all duration-200">
                                <label for="approve" class="ml-3 block text-sm font-medium text-gray-700">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Setujui data ini
                                    </span>
                                </label>
                            </div>
                        </form>
                    </div>

                    <!-- Footer -->
                    <div
                        class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                        <button type="button" wire:click="closeModal"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-4 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Batal
                        </button>
                        <button type="submit" wire:click="store"
                            class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-sm font-medium rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:scale-105 shadow-lg">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $scanCulaId ? 'Update Data' : 'Simpan Data' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
