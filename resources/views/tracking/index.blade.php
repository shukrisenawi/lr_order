<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-10">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Pengurusan Tracking</h1>
                <p class="text-gray-600">Urus penghantaran dan maklumat tracking anda</p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('tracking.create') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Tracking Baru
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

    <!-- Search -->
    <div class="mb-8">
        <div class="relative max-w-md">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fas fa-search text-gray-400"></i>
            </div>
            <input type="text" id="search" placeholder="Cari tracking mengikut nama, telefon, atau alamat..."
                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl bg-white focus:bg-white focus:border-blue-500 focus:ring-4 focus:ring-blue-100 focus:outline-none transition-all duration-300 shadow-sm">
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Kurier</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Nama Penerima</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">No Telefon</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Alamat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Berat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Dibuat</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($tracking as $item)
                        <tr class="hover:bg-blue-50 transition-colors duration-200" id="tracking-row-{{ $item->id }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">#{{ $item->id }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($item->kurier === 'J&T') bg-green-100 text-green-800
                                    @elseif($item->kurier === 'PosLaju') bg-blue-100 text-blue-800
                                    @elseif($item->kurier === 'DHL') bg-orange-100 text-orange-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    <i class="fas fa-truck mr-1"></i>
                                    {{ $item->kurier ?? 'J&T' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->nama_penerima }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->no_tel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600 max-w-xs truncate" title="{{ $item->alamat }}">{{ $item->alamat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                @if($item->berat)
                                    {{ $item->berat }} kg
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('tracking.show', $item) }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-700 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('tracking.edit', $item) }}"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-indigo-700 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors duration-200">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                    <button onclick="deleteTracking({{ $item->id }})"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-red-700 bg-red-50 rounded-lg hover:bg-red-100 transition-colors duration-200">
                                        <i class="fas fa-trash mr-1"></i>
                                        Padam
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <div class="bg-gray-100 rounded-full p-4 mb-4">
                                        <i class="fas fa-shipping-fast text-gray-400 text-2xl"></i>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-1">Tiada rekod tracking</h3>
                                    <p class="text-gray-500 mb-4">Mula tambah rekod tracking pertama anda</p>
                                    <a href="{{ route('tracking.create') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-medium rounded-lg shadow hover:from-blue-600 hover:to-blue-700 transition-all duration-300">
                                        <i class="fas fa-plus mr-2"></i>
                                        Tambah Tracking Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if(isset($tracking) && $tracking->hasPages())
            <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
                <div class="flex items-center justify-between">
                    <div class="text-sm text-gray-700">
                        Menunjukkan <span class="font-medium">{{ $tracking->firstItem() }}</span> ke <span
                            class="font-medium">{{ $tracking->lastItem() }}</span> daripada <span
                            class="font-medium">{{ $tracking->total() }}</span> rekod
                    </div>
                    <div>
                        {{ $tracking->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mt-4">Padam Tracking</h3>
            <div class="mt-2 px-7 py-3">
                <p class="text-sm text-gray-500">
                    Adakah anda pasti mahu memadam rekod tracking ini? Tindakan ini tidak boleh dibuat asal.
                </p>
            </div>
            <div class="flex items-center px-4 py-3 space-x-4">
                <button id="cancel-delete" class="flex-1 px-4 py-2 bg-gray-300 text-gray-900 text-base font-medium rounded-md shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300">
                    Batal
                </button>
                <form id="delete-form" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Padam
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('search').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('tbody tr');

    rows.forEach(row => {
        if (row.id && row.id.startsWith('tracking-row-')) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        }
    });
});

// Delete functionality
function deleteTracking(id) {
    const modal = document.getElementById('delete-modal');
    const form = document.getElementById('delete-form');
    const cancelBtn = document.getElementById('cancel-delete');

    form.action = `/tracking/${id}`;

    modal.classList.remove('hidden');

    cancelBtn.onclick = function() {
        modal.classList.add('hidden');
    };

    // Close modal when clicking outside
    modal.onclick = function(event) {
        if (event.target === modal) {
            modal.classList.add('hidden');
        }
    };
}
</script>
