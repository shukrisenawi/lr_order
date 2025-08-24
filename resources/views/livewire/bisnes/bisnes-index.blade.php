<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-light text-gray-800 mb-2">Pengurusan Bisnes</h1>
                <p class="text-gray-500">Urus entiti bisnes anda</p>
            </div>
            <a href="{{ route('bisnes.create') }}" class="px-4 py-2 bg-gray-800 text-white hover:bg-gray-900">
                Tambah Bisnes Baru
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700">
            {{ session('message') }}
        </div>
    @endif

    <!-- Search -->
    <div class="mb-6">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari bisnes..."
            class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none">
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer"
                        wire:click="sortBy('nama_bines')">
                        Nama Bisnes
                        @if ($sortField === 'nama_bines')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer"
                        wire:click="sortBy('nama_syarikat')">
                        Nama Syarikat
                        @if ($sortField === 'nama_syarikat')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">No. Pendaftaran</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Jenis</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Telefon</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Tindakan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bisnes as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50" wire:key="bisnes-{{ $item->id }}">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                @if ($item->gambar)
                                    <img src="{{ asset('storage/bisnes/' . $item->gambar) }}"
                                        alt="{{ $item->nama_bines }}"
                                        class="w-8 h-8 object-cover border border-gray-200 mr-3">
                                @else
                                    <div class="w-8 h-8 bg-gray-100 border border-gray-200 mr-3"></div>
                                @endif
                                <div class="text-sm text-gray-800">{{ $item->nama_bines }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->nama_syarikat }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_pendaftaran }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->jenis_bisnes }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_tel }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('bisnes.show', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">Lihat</a>
                                <a href="{{ route('bisnes.edit', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">Edit</a>
                                <button wire:click="delete({{ $item->id }})"
                                    wire:confirm="Adakah anda pasti mahu memadamkan bisnes ini?"
                                    class="text-red-600 hover:text-red-800">Padam</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <div>Tiada bisnes dijumpai</div>
                            <a href="{{ route('bisnes.create') }}"
                                class="text-gray-800 hover:underline mt-2 inline-block">
                                Tambah bisnes pertama anda
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($bisnes->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bisnes->links() }}
            </div>
        @endif
    </div>
</div>
