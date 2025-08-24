@extends('layouts.app')

@section('title', 'Pengurusan Alamat Prospek')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-light text-gray-800 mb-2">Pengurusan Alamat Prospek</h1>
                    <p class="text-gray-500">Urus alamat prospek anda</p>
                </div>
                <a href="{{ route('prospek-alamat.create') }}" class="px-4 py-2 bg-gray-800 text-white hover:bg-gray-900">
                    Tambah Alamat Baru
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700">
                {{ session('message') }}
            </div>
        @endif

        <!-- Table -->
        <div class="bg-white border border-gray-200">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm text-gray-600">Prospek</th>
                        <th class="px-6 py-4 text-left text-sm text-gray-600">Alamat</th>
                        <th class="px-6 py-4 text-left text-sm text-gray-600">Bandar</th>
                        <th class="px-6 py-4 text-left text-sm text-gray-600">Poskod</th>
                        <th class="px-6 py-4 text-left text-sm text-gray-600">Negeri</th>
                        <th class="px-6 py-4 text-left text-sm text-gray-600">Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @if(isset($prospekAlamat) && $prospekAlamat->count() > 0)
                        @foreach($prospekAlamat as $item)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $item->prospek->gelaran ?? 'N/A' }} - {{ $item->prospek->no_tel ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <div class="max-w-xs truncate">{{ $item->alamat ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->bandar ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->poskod ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->negeri ?? 'N/A' }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('prospek-alamat.show', $item) }}" class="text-gray-600 hover:text-gray-800">Lihat</a>
                                        <a href="{{ route('prospek-alamat.edit', $item) }}" class="text-gray-600 hover:text-gray-800">Edit</a>
                                        <form method="POST" action="{{ route('prospek-alamat.destroy', $item) }}" class="inline"
                                              onsubmit="return confirm('Adakah anda pasti mahu memadamkan alamat ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800">Padam</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div>Tiada alamat dijumpai</div>
                                <a href="{{ route('prospek-alamat.create') }}" class="text-gray-800 hover:underline mt-2 inline-block">
                                    Tambah alamat pertama anda
                                </a>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- Pagination -->
            @if(isset($prospekAlamat) && $prospekAlamat->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $prospekAlamat->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
