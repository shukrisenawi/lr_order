<div class="max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-light text-gray-800 mb-2">Pengurusan Prospek</h1>
                <p class="text-gray-500">Urus prospek anda</p>
            </div>
            <a href="{{ route('prospek.create') }}" class="px-4 py-2 bg-gray-800 text-white hover:bg-gray-900">
                Tambah Prospek Baru
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
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Cari prospek mengikut nama, telefon, atau emel..."
            class="w-full px-4 py-3 border border-gray-200 bg-gray-50 focus:bg-white focus:border-gray-400 focus:outline-none">
    </div>

    <!-- Table -->
    <div class="bg-white border border-gray-200">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer" wire:click="sortBy('gelaran')">
                        Name
                        @if ($sortField === 'gelaran')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600 cursor-pointer" wire:click="sortBy('no_tel')">
                        Phone
                        @if ($sortField === 'no_tel')
                            @if ($sortDirection === 'asc')
                                ↑
                            @else
                                ↓
                            @endif
                        @endif
                    </th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Email</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Business</th>
                    <th class="px-6 py-4 text-left text-sm text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prospek as $item)
                    <tr class="border-b border-gray-100 hover:bg-gray-50" wire:key="prospek-{{ $item->id }}">
                        <td class="px-6 py-4 text-sm text-gray-800">{{ $item->gelaran }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_tel }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->email ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $item->bisnes->nama_bines ?? 'N/A' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex space-x-2">
                                <a href="{{ route('prospek.show', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">View</a>
                                <a href="{{ route('prospek.edit', $item) }}"
                                    class="text-gray-600 hover:text-gray-800">Edit</a>
                                <button wire:click="delete({{ $item->id }})"
                                    wire:confirm="Are you sure you want to delete this prospect?"
                                    class="text-red-600 hover:text-red-800">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div>No prospects found</div>
                            <a href="{{ route('prospek.create') }}"
                                class="text-gray-800 hover:underline mt-2 inline-block">
                                Add your first prospect
                            </a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if ($prospek->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $prospek->links() }}
            </div>
        @endif
    </div>
</div>
