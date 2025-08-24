@extends('layouts.app')

@section('title', 'Token API')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-light text-gray-800 mb-2">Token API</h1>
                    <p class="text-gray-500">Urus token API untuk akses luar sistem</p>
                </div>
                <button onclick="openCreateModal()" 
                        class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700">
                    Cipta Token Baru
                </button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('new_token'))
            <div class="mb-6 bg-blue-50 border border-blue-200 p-4 rounded">
                <h4 class="font-medium text-blue-900 mb-2">Token Baru Dicipta</h4>
                <p class="text-sm text-blue-700 mb-2">Sila simpan token ini dengan selamat. Anda tidak akan dapat melihatnya lagi.</p>
                <div class="bg-white border border-blue-300 p-3 rounded font-mono text-sm break-all">
                    {{ session('new_token') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        @endif

        <!-- API Tokens Table -->
        <div class="bg-white border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Token API Anda</h3>
            </div>
            
            @if($tokens->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Token</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir Digunakan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dicipta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tindakan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tokens as $token)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $token->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500 font-mono">{{ $token->masked_token }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($token->is_active && !$token->isExpired())
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @elseif($token->isExpired())
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                                Tamat Tempoh
                                            </span>
                                        @else
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Tidak Aktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $token->last_used_at ? $token->last_used_at->format('d/m/Y H:i') : 'Belum digunakan' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $token->created_at->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <form method="POST" action="{{ route('settings.api-tokens.delete', $token->id) }}" 
                                              onsubmit="return confirm('Adakah anda pasti mahu memadamkan token ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                Padam
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-8 text-center">
                    <i class="fas fa-key text-gray-400 text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tiada Token API</h3>
                    <p class="text-gray-500 mb-4">Anda belum mencipta sebarang token API.</p>
                    <button onclick="openCreateModal()" 
                            class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700">
                        Cipta Token Pertama
                    </button>
                </div>
            @endif
        </div>

        <!-- Quick Links -->
        <div class="mt-8 bg-gray-50 border border-gray-200 p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Pautan Pantas</h3>
            <div class="flex space-x-4">
                <a href="{{ route('settings.api-documentation') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-book mr-2"></i>
                    Dokumentasi API
                </a>
                <a href="{{ route('settings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Tetapan
                </a>
            </div>
        </div>
    </div>

    <!-- Create Token Modal -->
    <div id="createTokenModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <form method="POST" action="{{ route('settings.api-tokens.create') }}">
                    @csrf
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Cipta Token API Baru</h3>
                    </div>
                    
                    <div class="px-6 py-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Token</label>
                            <input type="text" name="name" required 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="cth: Mobile App Token">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tarikh Tamat (Pilihan)</label>
                            <input type="datetime-local" name="expires_at" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-xs text-gray-500 mt-1">Kosongkan untuk token yang tidak tamat tempoh</p>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                        <button type="button" onclick="closeCreateModal()" 
                                class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                            Batal
                        </button>
                        <button type="submit" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Cipta Token
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openCreateModal() {
            document.getElementById('createTokenModal').classList.remove('hidden');
        }
        
        function closeCreateModal() {
            document.getElementById('createTokenModal').classList.add('hidden');
        }
        
        // Close modal when clicking outside
        document.getElementById('createTokenModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCreateModal();
            }
        });
    </script>
@endsection
