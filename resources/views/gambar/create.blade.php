@extends('layouts.app')

@section('title', 'Muat Naik Gambar')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">Muat Naik Gambar Baru</h1>
                    <p class="text-gray-600">Tambah gambar baru ke galeri anda</p>
                </div>
                <a href="{{ route('gambar.index') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-gray-500 to-gray-700 text-white font-medium rounded-xl shadow-lg hover:from-gray-600 hover:to-gray-800 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Galeri
                </a>
            </div>
        </div>

        <!-- Upload Form -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-gray-100">
                <h3 class="text-xl font-semibold text-gray-900">Maklumat Gambar</h3>
                <p class="text-gray-600 text-sm mt-1">Sila isi maklumat gambar di bawah</p>
            </div>

            <form method="POST" action="{{ route('gambar.store') }}" enctype="multipart/form-data" class="p-6">
                @csrf

                <div class="grid grid-cols-1 gap-8">
                    <!-- Form Fields -->
                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="nama" class="block text-sm font-semibold text-gray-800 mb-2">Nama Gambar</label>
                            <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-300 @error('nama') border-red-500 @enderror">
                            @error('nama')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Image Files -->
                        <div>
                            <label for="gambar" class="block text-sm font-semibold text-gray-800 mb-2">Fail Gambar (Boleh
                                pilih lebih dari satu)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-gray-300 rounded-xl hover:border-purple-400 transition-colors duration-300 cursor-pointer"
                                onclick="document.getElementById('gambar').click()">
                                <div class="space-y-1 text-center">
                                    <div
                                        class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-purple-100">
                                        <i class="fas fa-cloud-upload-alt text-purple-600 text-xl"></i>
                                    </div>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="gambar"
                                            class="relative cursor-pointer bg-white rounded-md font-medium text-purple-600 hover:text-purple-500 focus-within:outline-none">
                                            <span>Muat naik fail</span>
                                        </label>
                                        <p class="pl-1">atau seret dan lepaskan</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, GIF sehingga 2MB setiap fail</p>
                                    <p class="text-xs text-purple-600 font-medium">Klik di mana-mana untuk pilih gambar</p>
                                </div>
                            </div>

                            <!-- Hidden file input -->
                            <input id="gambar" name="gambar[]" type="file" accept="image/*" multiple class="hidden">

                            <!-- Selected files preview -->
                            <div id="selected-files" class="mt-4 hidden">
                                <h4 class="text-sm font-medium text-gray-700 mb-3">Gambar yang dipilih:</h4>
                                <div id="files-list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                            </div>

                            @error('gambar')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                            @error('gambar.*')
                                <p class="mt-2 text-sm text-red-600 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                </div>

                <!-- Submit Buttons -->
                <div class="mt-10 flex flex-col sm:flex-row justify-end space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('gambar.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-colors duration-300">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 text-white font-medium rounded-xl shadow-lg hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
                        <i class="fas fa-upload mr-2"></i>
                        Muat Naik Gambar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle multiple file selection and preview
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('gambar');
            const selectedFilesDiv = document.getElementById('selected-files');
            const filesListDiv = document.getElementById('files-list');
            const form = document.querySelector('form');

            // Handle file selection
            fileInput.addEventListener('change', function(e) {
                const files = Array.from(e.target.files);

                if (files.length > 0) {
                    selectedFilesDiv.classList.remove('hidden');
                    filesListDiv.innerHTML = '';

                    files.forEach((file, index) => {
                        // Create thumbnail container
                        const thumbnailContainer = document.createElement('div');
                        thumbnailContainer.className =
                            'relative bg-white rounded-lg border-2 border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow';

                        // Create image element
                        const img = document.createElement('img');
                        img.className = 'w-full h-32 object-cover bg-gray-100';
                        img.alt = file.name;

                        // Create file reader to generate thumbnail
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            img.src = e.target.result;
                        };
                        reader.onerror = function() {
                            // If image fails to load, show a placeholder
                            img.src =
                                'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEyOCIgdmlld0JveD0iMCAwIDIwMCAxMjgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMTI4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik04NyA0OEw5MyA1NEw5OSA0OEwxMDUgNTRMMTEzIDQ2VjgySDg3VjQ4WiIgZmlsbD0iIzlDQTNBRiIvPgo8Y2lyY2xlIGN4PSI5NSIgY3k9IjU4IiByPSI0IiBmaWxsPSIjOUNBM0FGIi8+Cjx0ZXh0IHg9IjEwMCIgeT0iNzAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM2QjcyODAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxMiI+SW1hZ2U8L3RleHQ+Cjwvc3ZnPgo=';
                        };

                        // Only read as data URL if it's an image file
                        if (file.type.startsWith('image/')) {
                            reader.readAsDataURL(file);
                        } else {
                            img.src =
                                'data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjEyOCIgdmlld0JveD0iMCAwIDIwMCAxMjgiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxyZWN0IHdpZHRoPSIyMDAiIGhlaWdodD0iMTI4IiBmaWxsPSIjRjNGNEY2Ii8+CjxwYXRoIGQ9Ik04NyA0OEw5MyA1NEw5OSA0OEwxMDUgNTRMMTEzIDQ2VjgySDg3VjQ4WiIgZmlsbD0iIzlDQTNBRiIvPgo8Y2lyY2xlIGN4PSI5NSIgY3k9IjU4IiByPSI0IiBmaWxsPSIjOUNBM0FGIi8+Cjx0ZXh0IHg9IjEwMCIgeT0iNzAiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IiM2QjcyODAiIGZvbnQtZmFtaWx5PSJBcmlhbCIgZm9udC1zaXplPSIxMiI+SW1hZ2U8L3RleHQ+Cjwvc3ZnPgo=';
                        }

                        // Remove button
                        const removeBtn = document.createElement('button');
                        removeBtn.type = 'button';
                        removeBtn.className =
                            'absolute top-2 right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center hover:bg-red-600 transition-colors';
                        removeBtn.innerHTML = '×';
                        removeBtn.onclick = function(e) {
                            e.stopPropagation();
                            removeFile(index);
                        };

                        // File info at bottom
                        const fileInfo = document.createElement('div');
                        fileInfo.className =
                            'absolute bottom-0 left-0 right-0 bg-black bg-opacity-75 text-white p-2';
                        fileInfo.innerHTML = `
                            <p class="text-xs font-medium truncate">${file.name}</p>
                            <p class="text-xs opacity-75">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        `;

                        thumbnailContainer.appendChild(img);
                        thumbnailContainer.appendChild(removeBtn);
                        thumbnailContainer.appendChild(fileInfo);
                        filesListDiv.appendChild(thumbnailContainer);
                    });
                } else {
                    selectedFilesDiv.classList.add('hidden');
                }
            });

            // Function to remove file from selection
            function removeFile(indexToRemove) {
                const dt = new DataTransfer();
                const files = Array.from(fileInput.files);

                files.forEach((file, index) => {
                    if (index !== indexToRemove) {
                        dt.items.add(file);
                    }
                });

                fileInput.files = dt.files;
                fileInput.dispatchEvent(new Event('change'));
            }

            // Handle drag and drop
            const dropZone = document.querySelector('.border-dashed');

            dropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                dropZone.classList.add('border-purple-500', 'bg-purple-50');
            });

            dropZone.addEventListener('dragleave', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-purple-500', 'bg-purple-50');
            });

            dropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                dropZone.classList.remove('border-purple-500', 'bg-purple-50');

                const files = Array.from(e.dataTransfer.files).filter(file =>
                    file.type.startsWith('image/')
                );

                if (files.length > 0) {
                    const dt = new DataTransfer();
                    files.forEach(file => dt.items.add(file));
                    fileInput.files = dt.files;
                    fileInput.dispatchEvent(new Event('change'));
                }
            });

            // Form validation before submission
            form.addEventListener('submit', function(e) {
                if (fileInput.files.length === 0) {
                    e.preventDefault();
                    alert('Sila pilih sekurang-kurangnya satu gambar untuk dimuat naik.');
                    return false;
                }
            });
        });
    </script>
@endsection
