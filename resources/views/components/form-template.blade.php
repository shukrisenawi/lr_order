{{-- Form Template menggunakan Utility Classes --}}
{{-- Copy template ini untuk membuat form baru yang konsisten --}}

<div class="w-full px-2 sm:px-3 lg:px-4 py-2 bg-gray-50 min-h-screen">
    {{-- Header --}}
    <div class="mb-3">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div class="flex-1">
                <div class="flex items-center gap-2">
                    <h1 class="text-lg md:text-xl font-bold text-gray-900">
                        {{ $title ?? 'Form Title' }}
                    </h1>
                    @if(isset($subtitle))
                        <p class="text-gray-600 text-xs mt-0.5">{{ $subtitle }}</p>
                    @endif
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ $backUrl ?? '#' }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    {{-- Flash Messages --}}
    @if (session()->has('success'))
        <div class="info-box info-box-success mb-3">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-1"></i>
                <span class="text-xs">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="info-box info-box-error mb-3">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-1"></i>
                <span class="text-xs">{{ session('error') }}</span>
            </div>
        </div>
    @endif

    {{-- Form --}}
    <form wire:submit.prevent="{{ $submitMethod ?? 'save' }}" class="space-y-2">
        {{-- Two Column Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Left Column --}}
            <div class="space-y-2">
                {{-- Card 1 --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-sm font-semibold text-white flex items-center">
                            <i class="fas fa-info-circle mr-2"></i>
                            Section Title
                        </h2>
                    </div>

                    <div class="form-card-body">
                        {{-- 2 Column Grid --}}
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Field Label</label>
                                <input type="text" class="form-input" placeholder="Placeholder text">
                                @error('field_name')
                                    <div class="form-error">
                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="form-label-flex">
                                    <i class="fas fa-envelope mr-1 text-blue-500"></i>
                                    Email
                                </label>
                                <input type="email" class="form-input" placeholder="email@example.com">
                            </div>
                        </div>

                        {{-- Full Width Field --}}
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-textarea" rows="2" placeholder="Enter description"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Card 2 --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-sm font-semibold text-white flex items-center">
                            <i class="fas fa-cog mr-2"></i>
                            Settings
                        </h2>
                    </div>

                    <div class="form-card-body">
                        <div class="form-grid-2">
                            <div class="form-group">
                                <label class="form-label">Status</label>
                                <select class="form-select">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Priority</label>
                                <select class="form-select">
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="space-y-2">
                {{-- Card 3 --}}
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="text-sm font-semibold text-white flex items-center">
                            <i class="fas fa-list mr-2"></i>
                            Items List
                        </h2>
                    </div>

                    <div class="form-card-body">
                        {{-- Items will be added here --}}
                        <div class="text-center py-8 text-gray-500">
                            <i class="fas fa-plus-circle text-3xl mb-2"></i>
                            <p class="text-sm">No items added yet</p>
                            <button type="button" class="btn-small mt-2">
                                <i class="fas fa-plus mr-1"></i>
                                Add Item
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Summary Card --}}
                <div class="info-box info-box-info">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <i class="fas fa-calculator text-blue-600 text-lg mr-2"></i>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Summary</h3>
                                <p class="text-xs text-gray-600">Total items: 0</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-lg font-bold text-blue-600">RM 0.00</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="form-card">
            <div class="form-card-header">
                <h2 class="text-sm font-semibold text-white flex items-center">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Actions
                </h2>
            </div>
            <div class="form-card-body">
                <div class="flex flex-col sm:flex-row gap-3 justify-end">
                    <a href="#" class="btn-secondary">
                        <i class="fas fa-times mr-1"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-1"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- Usage Instructions --}}
{{--
Untuk menggunakan template ini:

1. Copy file ini ke lokasi form baru
2. Ganti variable placeholders:
   - $title: Judul form
   - $subtitle: Subjudul (optional)
   - $backUrl: URL untuk tombol kembali
   - $submitMethod: Method Livewire untuk submit

3. Sesuaikan field-field sesuai kebutuhan
4. Gunakan utility classes yang tersedia:
   - .form-card, .form-card-header, .form-card-body
   - .form-input, .form-select, .form-textarea
   - .form-label, .form-label-flex
   - .form-group
   - .form-grid-2, .form-grid-3
   - .btn-primary, .btn-secondary, .btn-small
   - .info-box, .info-box-success, .info-box-error, .info-box-info
   - .form-error

4. Template ini sudah responsive dan mengikuti design system
--}}