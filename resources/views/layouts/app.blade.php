<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Business Management System')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-01.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @livewireStyles
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }
    </style>

    <script>
        function toggleBisnesDropdown() {
            const dropdown = document.getElementById('bisnes-dropdown');
            dropdown.classList.toggle('hidden');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('bisnes-dropdown');
            const button = document.getElementById('bisnes-menu-button');

            if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</head>

<body class="bg-gray-50">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-semibold text-gray-900">Business Management System</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Business Selector -->
                    <div class="relative">
                        @php
                            $userBisnes = \App\Models\Bisnes::where('user_id', Auth::id())->get();
                            $selectedBisnes = session('selected_bisnes_id')
                                ? \App\Models\Bisnes::find(session('selected_bisnes_id'))
                                : $userBisnes->first();
                        @endphp

                        @if ($userBisnes->count() > 0)
                            <div class="relative inline-block text-left">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                    id="bisnes-menu-button" aria-expanded="true" aria-haspopup="true"
                                    onclick="toggleBisnesDropdown()">
                                    <i class="fas fa-building mr-2"></i>
                                    {{ $selectedBisnes ? $selectedBisnes->nama_bines : 'Pilih Bisnes' }}
                                    <i class="fas fa-chevron-down ml-2"></i>
                                </button>

                                <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden"
                                    id="bisnes-dropdown" role="menu" aria-orientation="vertical"
                                    aria-labelledby="bisnes-menu-button">
                                    <div class="py-1" role="none">
                                        @foreach ($userBisnes as $bisnes)
                                            <a href="{{ route('switch-bisnes', $bisnes->id) }}"
                                                class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 {{ $selectedBisnes && $selectedBisnes->id == $bisnes->id ? 'bg-gray-50 font-medium' : '' }}"
                                                role="menuitem">
                                                <i class="fas fa-building mr-3 text-gray-400"></i>
                                                <div>
                                                    <div class="font-medium">{{ $bisnes->nama_bines }}</div>
                                                    <div class="text-xs text-gray-500">{{ $bisnes->nama_syarikat }}
                                                    </div>
                                                </div>
                                                @if ($selectedBisnes && $selectedBisnes->id == $bisnes->id)
                                                    <i class="fas fa-check ml-auto text-green-500"></i>
                                                @endif
                                            </a>
                                        @endforeach

                                        <div class="border-t border-gray-100"></div>
                                        <a href="{{ route('bisnes.index') }}"
                                            class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                            role="menuitem">
                                            <i class="fas fa-cog mr-3 text-gray-400"></i>
                                            Urus Bisnes
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('bisnes.create') }}"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Bisnes
                            </a>
                        @endif
                    </div>

                    <span class="text-sm text-gray-700">Welcome, {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm text-gray-500 hover:text-gray-700">
                            <i class="fas fa-sign-out-alt mr-1"></i>Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
            <div class="p-4">
                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('dashboard') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Business Management Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Business
                            Management</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('bisnes.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('bisnes.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-building"></i>
                                <span>Bisnes</span>
                            </a>
                            <a href="{{ route('produk.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('produk.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-box"></i>
                                <span>Produk</span>
                            </a>
                            <a href="{{ route('gambar.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('gambar.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-images"></i>
                                <span>Gambar</span>
                            </a>
                        </div>
                    </div>

                    <!-- Customer Management Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer
                            Management</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('prospek.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('prospek.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-users"></i>
                                <span>Prospek</span>
                            </a>
                            <a href="{{ route('prospek-alamat.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('prospek-alamat.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Alamat Prospek</span>
                            </a>
                            <a href="{{ route('prospek-buy.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('prospek-buy.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Pembelian</span>
                            </a>
                        </div>
                    </div>

                    <!-- Account Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('settings.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 {{ request()->routeIs('settings.*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700 hover:bg-gray-100' }} rounded-lg transition-colors">
                                <i class="fas fa-cog"></i>
                                <span>Tetapan</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    @yield('scripts')
    @livewireScripts
</body>

</html>
