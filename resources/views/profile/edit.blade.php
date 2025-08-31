@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<div class="w-full px-2 sm:px-4 lg:px-6 py-4 min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 via-purple-50 to-pink-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Edit Profile</h1>
                <p class="text-sm text-gray-600">Update your account information and preferences</p>
            </div>
            <a href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center px-4 py-2 bg-gradient-to-r from-gray-500 to-gray-600 text-white font-medium rounded-lg shadow-md hover:from-gray-600 hover:to-gray-700 transition-all duration-300">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Dashboard
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="mb-6 p-3 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 text-green-700 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-500 mr-2"></i>
                <span class="text-sm">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 p-3 bg-gradient-to-r from-red-50 to-pink-50 border border-red-200 text-red-700 rounded-lg shadow-sm">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
                <span class="text-sm">{{ $errors->first() }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Avatar Section -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Profile Picture</h2>

                <div class="flex flex-col items-center space-y-4">
                    <div class="relative">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar_url }}"
                                 alt="Profile Picture"
                                 class="w-24 h-24 rounded-full object-cover border-4 border-blue-100 shadow-lg"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="w-24 h-24 rounded-full bg-gradient-to-r from-red-400 to-pink-500 flex items-center justify-center border-4 border-red-100 shadow-lg hidden">
                                <span class="text-white text-2xl font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @else
                            <div class="w-24 h-24 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center border-4 border-blue-100 shadow-lg">
                                <span class="text-white text-2xl font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('profile.avatar.delete') }}" class="absolute -top-2 -right-2">
                            @csrf
                            @method('DELETE')
                            @if(Auth::user()->avatar)
                                <button type="submit"
                                        class="w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center hover:bg-red-600 transition-colors"
                                        title="Remove avatar">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            @endif
                        </form>
                    </div>

                    <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="w-full" id="avatar-form">
                        @csrf
                        <div class="space-y-3">
                            <input type="file"
                                   name="avatar"
                                   id="avatar-input"
                                   accept="image/*"
                                   onchange="previewAvatar(this)"
                                   class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <div id="file-info" class="text-xs text-gray-500 hidden"></div>
                            <button type="submit"
                                    id="upload-btn"
                                    class="w-full px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300">
                                <i class="fas fa-upload mr-2"></i>
                                Upload New Avatar
                            </button>
                        </div>
                    </form>

                    <script>
                        function previewAvatar(input) {
                            const file = input.files[0];
                            const fileInfo = document.getElementById('file-info');

                            if (file) {
                                fileInfo.classList.remove('hidden');
                                fileInfo.innerHTML = `
                                    <strong>File selected:</strong> ${file.name}<br>
                                    <strong>Size:</strong> ${(file.size / 1024).toFixed(2)} KB<br>
                                    <strong>Type:</strong> ${file.type}
                                `;

                                // Preview image
                                const reader = new FileReader();
                                reader.onload = function(e) {
                                    const previewImg = document.querySelector('.relative img') || document.querySelector('.relative div');
                                    if (previewImg.tagName === 'IMG') {
                                        previewImg.src = e.target.result;
                                    }
                                };
                                reader.readAsDataURL(file);
                            } else {
                                fileInfo.classList.add('hidden');
                            }
                        }

                        // Debug form submission
                        document.getElementById('avatar-form').addEventListener('submit', function(e) {
                            const fileInput = document.getElementById('avatar-input');
                            const btn = document.getElementById('upload-btn');

                            if (!fileInput.files[0]) {
                                e.preventDefault();
                                alert('Please select a file first!');
                                return;
                            }

                            console.log('Form submitted with file:', fileInput.files[0]);
                            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';
                            btn.disabled = true;
                        });
                    </script>
                </div>
            </div>
        </div>

        <!-- Account Information -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Profile Information -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Account Information</h2>

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', Auth::user()->name) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <input type="email"
                                   id="email"
                                   name="email"
                                   value="{{ old('email', Auth::user()->email) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-medium rounded-lg shadow-md hover:from-blue-600 hover:to-indigo-700 transition-all duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h2>

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password"
                                   id="current_password"
                                   name="current_password"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                   required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password"
                                       id="password"
                                       name="password"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       required>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                       required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="px-6 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-medium rounded-lg shadow-md hover:from-green-600 hover:to-emerald-700 transition-all duration-300">
                            <i class="fas fa-key mr-2"></i>
                            Change Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection