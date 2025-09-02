<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">
                    {{ $isEdit ? 'Edit Landing Page' : 'Tambah Landing Page Baru' }}
                </h1>
                <p class="text-gray-600">
                    {{ $isEdit ? 'Kemaskini maklumat landing page' : 'Cipta landing page baru' }}
                </p>
            </div>
            <a href="{{ route('landing-page.index') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali ke Senarai
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
            <h3 class="text-xl font-semibold text-gray-900">Maklumat Landing Page</h3>
            <p class="text-gray-600 text-sm mt-1">
                {{ $isEdit ? 'Kemaskini maklumat landing page di bawah' : 'Sila isi semua maklumat landing page yang diperlukan' }}
            </p>
        </div>

        <form wire:submit.prevent="save" class="p-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content Column -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Tajuk Landing Page
                        </label>
                        <input type="text" wire:model="title" placeholder="Masukkan tajuk landing page"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('title') border-red-500 bg-red-50 @enderror">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Slug URL
                        </label>
                        <input type="text" wire:model="slug" placeholder="landing-page-url"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('slug') border-red-500 bg-red-50 @enderror">
                        <p class="mt-1 text-sm text-gray-500">URL akan menjadi: {{ url('/') }}/page/<span id="slug-preview">{{ $slug }}</span></p>
                        @error('slug')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Content (Rich Text Editor) -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Kandungan
                        </label>
                        <textarea wire:model="content" id="content-editor" rows="15"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('content') border-red-500 bg-red-50 @enderror"></textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="space-y-6">
                    <!-- Business -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Bisnes
                        </label>
                        <select wire:model="bisnes_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('bisnes_id') border-red-500 bg-red-50 @enderror">
                            <option value="">Pilih Bisnes</option>
                            @foreach($bisnes as $b)
                                <option value="{{ $b->id }}">{{ $b->nama_bisnes }}</option>
                            @endforeach
                        </select>
                        @error('bisnes_id')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Status
                        </label>
                        <select wire:model="status"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('status') border-red-500 bg-red-50 @enderror">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                        @error('status')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Template -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">
                            Template
                        </label>
                        <select wire:model="template"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-300 @error('template') border-red-500 bg-red-50 @enderror">
                            <option value="default">Default</option>
                            <option value="minimal">Minimal</option>
                            <option value="corporate">Corporate</option>
                        </select>
                        @error('template')
                            <p class="mt-2 text-sm text-red-600 flex items-center">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="text-sm font-semibold text-gray-800 mb-3">SEO Settings</h4>

                        <!-- Meta Title -->
                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Meta Title
                            </label>
                            <input type="text" wire:model="meta_title" placeholder="Meta title untuk SEO"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 @error('meta_title') border-red-500 bg-red-50 @enderror">
                            @error('meta_title')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">
                                Meta Description
                            </label>
                            <textarea wire:model="meta_description" rows="3" placeholder="Meta description untuk SEO"
                                class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 @error('meta_description') border-red-500 bg-red-50 @enderror"></textarea>
                            @error('meta_description')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('landing-page.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                    Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-blue-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    <i class="fas fa-save mr-2"></i>
                    {{ $isEdit ? 'Kemaskini Landing Page' : 'Simpan Landing Page' }}
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('livewire:loaded', function () {
    // Initialize TinyMCE when the component is loaded
    if (typeof window.initTinyMCE === 'function') {
        window.initTinyMCE('#content-editor', 500);
    }

    // Update slug preview
    document.addEventListener('input', function(e) {
        if (e.target.matches('[wire\\:model="slug"]')) {
            document.getElementById('slug-preview').textContent = e.target.value;
        }
    });
});

// Reinitialize TinyMCE when content changes
document.addEventListener('livewire:updated', function () {
    if (typeof window.initTinyMCE === 'function') {
        // Destroy existing instance if it exists
        if (tinymce.get('content-editor')) {
            tinymce.remove('#content-editor');
        }
        // Reinitialize
        window.initTinyMCE('#content-editor', 500);
    }
});
</script>
@endpush