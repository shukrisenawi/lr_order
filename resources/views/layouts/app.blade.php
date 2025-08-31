@php
    use App\Models\Bisnes;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Business Management System')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo-01.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @livewireStyles
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --sidebar-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #f093fb 100%);
            --sidebar-gradient-mobile: linear-gradient(135deg, #667eea 0%, #764ba2 30%, #f093fb 70%, #f5576c 100%);
            --sidebar-overlay: linear-gradient(45deg, rgba(102, 126, 234, 0.1) 0%, rgba(240, 147, 251, 0.1) 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
            padding-top: 3.5rem;
            /* Account for fixed header */
        }

        @media (max-width: 640px) {
            body {
                padding-top: 3rem;
                /* Smaller padding for mobile */
            }
        }

        .gradient-header {
            background: var(--primary-gradient);
        }

        .sidebar-gradient {
            background: var(--sidebar-gradient);
            position: relative;
            overflow: hidden;
        }

        .sidebar-gradient::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: var(--sidebar-overlay);
            pointer-events: none;
        }

        .sidebar-gradient::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
            animation: sidebar-shine 8s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes sidebar-shine {

            0%,
            100% {
                transform: translate(-50%, -50%) rotate(0deg);
                opacity: 0.3;
            }

            50% {
                transform: translate(-50%, -50%) rotate(180deg);
                opacity: 0.6;
            }
        }

        /* Mobile sidebar specific styles */
        @media (max-width: 768px) {
            .sidebar-gradient {
                background: var(--sidebar-gradient-mobile);
            }

            .sidebar-gradient::after {
                animation-duration: 6s;
            }

            /* Adjust sidebar width for very small screens */
            #mobile-menu .sidebar-gradient {
                width: 100vw;
                max-width: 320px;
            }

            /* Better spacing for small screens */
            .nav-link {
                padding: 1rem;
                margin: 0 0.5rem;
            }

            .nav-link .w-8 {
                width: 2rem;
                height: 2rem;
            }
        }

        /* Large screen enhancements */
        @media (min-width: 1024px) {
            .sidebar-gradient::before {
                background: linear-gradient(45deg, rgba(102, 126, 234, 0.15) 0%, rgba(240, 147, 251, 0.15) 50%, rgba(245, 87, 108, 0.15) 100%);
            }

            .sidebar-gradient::after {
                animation-duration: 10s;
            }
        }

        /* Hover effects for better interactivity */
        .nav-link:hover {
            transform: translateX(2px) scale(1.02);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .nav-link.active {
            transform: translateX(4px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
        }

        /* Smooth transitions for all elements */
        * {
            transition: all 0.3s ease;
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-5px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 10px rgba(102, 126, 234, 0.4);
            }

            to {
                box-shadow: 0 0 20px rgba(102, 126, 234, 0.8);
            }
        }

        .sidebar-link:hover {
            transform: translateX(5px);
            transition: all 0.3s ease;
        }

        .sidebar-link.active {
            background: rgba(255, 255, 255, 0.15);
            border-left: 4px solid #ffffff;
        }

        .dropdown-enter {
            opacity: 0;
            transform: translateY(-10px);
            transition: all 0.3s ease;
        }

        .dropdown-enter-active {
            opacity: 1;
            transform: translateY(0);
        }

        .mobile-menu-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        #mobile-menu {
            transform: translateX(-100%);
        }

        #mobile-menu.transform {
            transform: translateX(0);
        }

        .nav-section-title {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 700;
            letter-spacing: 0.05em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .nav-section-header {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 8px;
            padding: 0.375rem 0.5rem;
            margin: 0.375rem 0.25rem 0.25rem 0.25rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .nav-section-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, rgba(255, 255, 255, 0.6) 50%, transparent 100%);
        }

        .nav-section-header .section-icon {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.8) 0%, rgba(240, 147, 251, 0.8) 100%);
            box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 0.375rem 0.5rem;
            font-size: 0.875rem;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 2px solid white;
        }

        .h-screen-minus-header {
            height: calc(100vh - 3.5rem);
        }

        @media (max-width: 640px) {
            .h-screen-minus-header {
                height: calc(100vh - 3rem);
            }
        }
    </style>

    <script>
        function toggleBisnesDropdown() {
            const dropdown = document.getElementById('bisnes-dropdown');
            dropdown.classList.toggle('hidden');
            dropdown.classList.toggle('dropdown-enter');
            dropdown.classList.toggle('dropdown-enter-active');
        }

        function toggleMobileMenu() {
            const mobileMenu = document.getElementById('mobile-menu');
            const overlay = document.getElementById('mobile-overlay');

            if (mobileMenu.classList.contains('hidden')) {
                // Show menu
                mobileMenu.classList.remove('hidden');
                overlay.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.add('transform', 'translate-x-0');
                }, 10);
            } else {
                // Hide menu
                mobileMenu.classList.remove('transform', 'translate-x-0');
                overlay.classList.add('hidden');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('bisnes-dropdown');
            const button = document.getElementById('bisnes-menu-button');

            if (dropdown && button && !button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add('hidden');
                dropdown.classList.remove('dropdown-enter-active');
            }
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobile-menu');
            const menuButton = document.getElementById('mobile-menu-button');
            const overlay = document.getElementById('mobile-overlay');

            if (mobileMenu && menuButton &&
                !menuButton.contains(event.target) &&
                !mobileMenu.contains(event.target) &&
                !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                overlay.classList.add('hidden');
            }
        });
    </script>
</head>

<body class="bg-gray-50">
    <!-- Mobile menu overlay -->
    <div id="mobile-overlay" class="mobile-menu-overlay fixed inset-0 z-40 hidden" onclick="toggleMobileMenu()"></div>

    @php
        $userBisnes = Bisnes::where('user_id', Auth::id())->get();
        $selectedBisnes = session('selected_bisnes_id') ? Bisnes::find(session('selected_bisnes_id')) : null;
        $isFromAi = request()->has('from') && request('from') === 'ai';

    @endphp
    <!-- Header -->
    <header class="gradient-header shadow-xl backdrop-blur-sm border-b border-white/10 fixed top-0 left-0 right-0 z-50">
        <div class="max-w-7xl mx-auto px-3 sm:px-4 lg:px-6">
            <div class="flex justify-between items-center h-12 sm:h-14">
                <!-- Left Section: Logo and Title -->
                <div class="flex items-center space-x-2">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" type="button"
                        class="md:hidden inline-flex items-center justify-center p-1 rounded-lg text-white hover:bg-white/10 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200"
                        onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-sm"></i>
                    </button>

                    <!-- Logo -->
                    <div class="flex items-center space-x-2">
                        <img src="{{ asset('img/logo-01.png') }}" alt="Logo"
                            class="w-6 h-6 sm:w-8 sm:h-8 rounded-full object-cover border-2 border-white/30 shadow-lg">
                        <div class="hidden sm:block">
                            <h1 class="text-sm sm:text-base font-bold text-white leading-tight">SISTEM TEMPAHAN</h1>
                            <p class="text-sm text-white/80 font-medium">PERNIAGAAN</p>
                        </div>
                        <div class="sm:hidden">
                            <h1 class="text-sm font-bold text-white">LR ORDER</h1>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Business Selector and User Menu -->
                <div class="flex items-center space-x-1">
                    <!-- Business Selector -->
                    <div class="relative hidden sm:block">
                        @if ($userBisnes->count() > 0)
                            <div class="relative inline-block text-left">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-1.5 border border-white/20 shadow-lg text-sm leading-4 font-medium rounded-lg text-white bg-white/10 hover:bg-white/20 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200 backdrop-blur-sm"
                                    id="bisnes-menu-button" aria-expanded="true" aria-haspopup="true"
                                    onclick="toggleBisnesDropdown()">
                                    <img src="{{ $selectedBisnes && $selectedBisnes->gambar ? \App\Helpers\ImageHelper::businessImageUrl($selectedBisnes->gambar) : asset('img/logo-01.png') }}"
                                        alt="Business Logo"
                                        class="w-5 h-5 rounded-full object-cover mr-2 border-2 border-white/40 shadow-sm">
                                    <span
                                        class="hidden lg:inline text-sm">{{ $selectedBisnes ? Str::limit($selectedBisnes->nama_bisnes, 15) : 'Pilih Senarai' }}</span>
                                    <i class="fas fa-chevron-down ml-1 text-white/80 text-sm"></i>
                                </button>

                                <div class="origin-top-right absolute right-0 mt-3 w-72 rounded-2xl shadow-2xl bg-white/95 backdrop-blur-lg ring-1 ring-black/10 focus:outline-none hidden z-50 border border-white/20"
                                    id="bisnes-dropdown" role="menu" aria-orientation="vertical"
                                    aria-labelledby="bisnes-menu-button">
                                    <div class="py-3" role="none">
                                        @foreach ($userBisnes as $bisnes)
                                            <a href="{{ route('switch-bisnes', $bisnes->id) }}"
                                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 {{ $selectedBisnes && $selectedBisnes->id == $bisnes->id ? 'bg-gradient-to-r from-blue-100 to-purple-100 font-medium' : '' }} transition-all duration-200 rounded-lg mx-2"
                                                role="menuitem">
                                                <img src="{{ $bisnes && $bisnes->gambar ? \App\Helpers\ImageHelper::businessImageUrl($bisnes->gambar) : asset('img/logo-01.png') }}"
                                                    alt="Business Logo"
                                                    class="w-8 h-8 rounded-full object-cover mr-3 border-2 border-white/50 shadow-sm">
                                                <div class="flex-1">
                                                    <div class="font-medium text-gray-900">{{ $bisnes->nama_bisnes }}
                                                    </div>
                                                    <div class="text-xs text-gray-500">
                                                        {{ Str::limit($bisnes->nama_syarikat, 25) }}</div>
                                                </div>
                                                @if ($selectedBisnes && $selectedBisnes->id == $bisnes->id)
                                                    <i class="fas fa-check text-green-500 text-lg"></i>
                                                @endif
                                            </a>
                                        @endforeach

                                        <div class="border-t border-gray-200 my-2 mx-2"></div>
                                        <a href="{{ route('bisnes.index') }}"
                                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200 rounded-lg mx-2"
                                            role="menuitem">
                                            <i class="fas fa-building mr-3 text-gray-400"></i>
                                            <span class="font-medium">Senarai Bisnes</span>
                                            @if (!$selectedBisnes)
                                                <i class="fas fa-check ml-auto text-green-500"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('bisnes.create') }}"
                                class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs leading-4 font-medium rounded-lg text-white bg-gradient-to-r from-green-500/20 to-blue-500/20 hover:from-green-500/30 hover:to-blue-500/30 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200 pulse-glow hover:scale-105 shadow-lg backdrop-blur-sm">
                                <i class="fas fa-plus mr-1"></i>
                                <span class="hidden lg:inline">Tambah Bisnes</span>
                            </a>
                        @endif
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-1">
                        <!-- User Info -->
                        <div
                            class="hidden sm:flex items-center space-x-2 bg-white/10 rounded-lg px-2 py-1 backdrop-blur-sm">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar_url }}" alt="Avatar"
                                    class="w-6 h-6 rounded-full object-cover shadow-lg border-2 border-white/30"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div
                                    class="w-6 h-6 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center shadow-lg border-2 border-white/30 hidden">
                                    <span
                                        class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @else
                                <div
                                    class="w-6 h-6 rounded-full bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center shadow-lg border-2 border-white/30">
                                    <span
                                        class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                </div>
                            @endif
                            <span
                                class="text-white font-medium text-sm hidden lg:inline">{{ Auth::user()->name }}</span>
                        </div>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-white hover:bg-white/10 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200 shadow-lg backdrop-blur-sm"
                                title="Logout">
                                <i class="fas fa-sign-out-alt text-sm"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex h-screen-minus-header">
        <!-- Mobile Sidebar -->
        <div id="mobile-menu"
            class="md:hidden fixed inset-0 z-50 hidden transform transition-transform duration-300 ease-in-out">
            <div class="sidebar-gradient h-full w-64 sm:w-72 p-3 overflow-y-auto shadow-2xl relative">
                <!-- Decorative elements -->
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-white/5 to-transparent rounded-full -translate-y-16 translate-x-16">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-24 h-24 bg-gradient-to-tr from-white/5 to-transparent rounded-full translate-y-12 -translate-x-12">
                </div>
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-3 border-b border-white/20">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/logo-01.png') }}" alt="Logo"
                            class="w-10 h-10 rounded-full object-cover border-2 border-white/30 shadow-lg">
                        <div>
                            <h2 class="text-white text-xl font-bold">Menu</h2>
                            <p class="text-white/70 text-sm">Navigation</p>
                        </div>
                    </div>
                    <button onclick="toggleMobileMenu()"
                        class="text-white hover:bg-white/10 p-2 rounded-xl transition-all duration-200 hover:scale-105">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
                <nav class="space-y-0.5">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="nav-link flex items-center space-x-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('dashboard') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-home text-xs"></i>
                        </div>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>

                    <!-- Data Table -->
                    <a href="{{ route('data-table') }}"
                        class="nav-link flex items-center space-x-2 px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('data-table') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-table text-xs"></i>
                        </div>
                        <span class="font-medium text-sm">Jadual Data</span>
                    </a>

                    <!-- Create by AI -->
                    <a href="{{ route('ai') }}"
                        class="nav-link flex items-center justify-between px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ request()->routeIs('ai') || (request()->has('from') && request('from') === 'ai') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                <i class="fas fa-robot text-xs"></i>
                            </div>
                            <span class="font-medium text-sm">Create By AI</span>
                        </div>
                        <span id="ai-badge"
                            class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse shadow-lg">0</span>
                    </a>

                    <!-- Business Management Section -->
                    <div class="pt-1.5">
                        <h3 class="nav-section-header flex items-center">
                            <div class="section-icon w-6 h-6 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-briefcase text-xs text-white"></i>
                            </div>
                            <div class="flex-1">
                                <span class="nav-section-title text-xs block">Business Management</span>
                                <span class="text-xs text-white/60 block">Kelola perniagaan anda</span>
                            </div>
                        </h3>
                        <div class="space-y-0.5">
                            <a href="{{ route('bisnes.index') }}"
                                class="nav-link flex items-center space-x-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('bisnes.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-building text-xs"></i>
                                </div>
                                <span class="font-medium text-sm">Bisnes</span>
                            </a>
                            <a href="{{ route('gambar.index') }}"
                                class="nav-link flex items-center space-x-2 px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('gambar.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-images text-xs"></i>
                                </div>
                                <span class="font-medium text-sm">Gambar</span>
                            </a>

                            <a href="{{ route('iklan.index') }}"
                                class="nav-link flex items-center justify-between px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('iklan.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                        <i class="fas fa-bullhorn text-xs"></i>
                                    </div>
                                    <span class="font-medium text-sm">Iklan</span>
                                </div>
                            </a>
                            <a href="{{ route('produk.index') }}"
                                class="nav-link flex items-center justify-between px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('produk.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                        <i class="fas fa-box text-xs"></i>
                                    </div>
                                    <span class="font-medium text-sm">Produk</span>
                                </div>
                                <span id="produk-badge"
                                    class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse shadow-lg">0</span>
                            </a>
                        </div>
                    </div>

                    <!-- Customer Management Section -->
                    <div class="pt-1.5">
                        <h3 class="nav-section-header flex items-center">
                            <div class="section-icon w-6 h-6 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-users text-xs text-white"></i>
                            </div>
                            <div class="flex-1">
                                <span class="nav-section-title text-xs block">Customer Management</span>
                                <span class="text-xs text-white/60 block">Urus pelanggan & prospek</span>
                            </div>
                        </h3>
                        <div class="space-y-0.5">
                            <a href="{{ route('prospek.index') }}"
                                class="nav-link flex items-center justify-between rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('prospek.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                        <i class="fas fa-search-plus text-xs"></i>
                                    </div>
                                    <span class="font-medium text-sm">Prospek</span>
                                </div>
                                <span id="customer-badge"
                                    class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse shadow-lg">0</span>
                            </a>
                            <a href="{{ route('customer.index') }}"
                                class="nav-link flex items-center justify-between px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('customer.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="flex items-center space-x-2">
                                    <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                        <i class="fas fa-handshake text-xs"></i>
                                    </div>
                                    <span class="font-medium text-sm">Pelanggan</span>
                                </div>
                                <span id="customer-buy-badge"
                                    class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse shadow-lg">0</span>
                            </a>
                        </div>
                    </div>

                    <!-- Account Section -->
                    <div class="pt-1.5">
                        <h3 class="nav-section-header flex items-center">
                            <div class="section-icon w-6 h-6 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-user text-xs text-white"></i>
                            </div>
                            <div class="flex-1">
                                <span class="nav-section-title text-xs block">Account</span>
                                <span class="text-xs text-white/60 block">Tetapan & profil</span>
                            </div>
                        </h3>
                        <div class="space-y-0.5">
                            <a href="{{ route('settings.index') }}"
                                class="nav-link flex items-center space-x-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('settings.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-cog text-xs"></i>
                                </div>
                                <span class="font-medium text-sm">Tetapan</span>
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="nav-link flex items-center space-x-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('profile.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-user text-xs"></i>
                                </div>
                                <span class="font-medium text-sm">Profil</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <aside class="hidden md:block w-56 lg:w-64 sidebar-gradient h-screen sticky top-0">
            <div class="p-2 lg:p-3 overflow-y-auto h-full relative">
                <!-- Decorative elements for desktop -->
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-white/5 to-transparent rounded-full -translate-y-10 translate-x-10">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-16 h-16 bg-gradient-to-tr from-white/5 to-transparent rounded-full translate-y-8 -translate-x-8">
                </div>
                <!-- Header -->
                <div class="flex items-center mb-4 pb-2 border-b border-white/20">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('img/logo-01.png') }}" alt="Logo"
                            class="w-8 h-8 rounded-full object-cover border-2 border-white/30 shadow-lg">
                        <div>
                            <h2 class="text-white text-lg font-bold">Menu</h2>
                        </div>
                    </div>
                </div>
                <nav class="space-y-0.5">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="nav-link flex items-center space-x-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('dashboard') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                        <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                            <i class="fas fa-home text-xs"></i>
                        </div>
                        <span class="font-medium text-sm">Dashboard</span>
                    </a>
                    @if ($selectedBisnes && $selectedBisnes->type_id == 1)
                        <!-- Create by AI -->
                        <a href="{{ route('ai') }}"
                            class="nav-link flex items-center justify-between px-2 py-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ request()->routeIs('ai') || (request()->has('from') && request('from') === 'ai') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                            <div class="flex items-center space-x-2">
                                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-robot text-xs"></i>
                                </div>
                                <span class="font-medium text-sm">Create By AI</span>
                            </div>
                            <span id="ai-badge-desktop"
                                class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-1.5 py-0.5 animate-pulse shadow-lg">0</span>
                        </a>
                    @endif
                    <!-- Business Management Section -->
                    <div class="pt-1.5">
                        <h3 class="nav-section-header flex items-center">
                            <div class="section-icon w-6 h-6 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-briefcase text-xs text-white"></i>
                            </div>
                            <div class="flex-1">
                                <span class="nav-section-title text-xs block">Business Management</span>
                                <span class="text-xs text-white/60 block">Kelola perniagaan anda</span>
                            </div>
                        </h3>
                        <div class="space-y-0.5">
                            <a href="{{ route('bisnes.index') }}"
                                class="nav-link flex items-center space-x-2 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('bisnes.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-6 h-6 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-building text-xs"></i>
                                </div>
                                <span class="font-medium text-sm">Syarikat</span>
                            </a>
                            @if (session('selected_bisnes_id'))
                                <a href="{{ route('gambar.index') }}"
                                    class="nav-link flex items-center space-x-3 px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('gambar.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                    <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                        <i class="fas fa-images text-sm"></i>
                                    </div>
                                    <span class="font-medium">Gambar</span>
                                </a>
                                @if ($selectedBisnes && $selectedBisnes->type_id == 1)
                                    <a href="{{ route('iklan.index') }}"
                                        class="nav-link flex items-center justify-between px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('iklan.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                                <i class="fas fa-bullhorn text-sm"></i>
                                            </div>
                                            <span class="font-medium">Iklan AI</span>
                                        </div>
                                    </a>

                                    <a href="{{ route('produk.index') }}"
                                        class="nav-link flex items-center justify-between px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('produk.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                                <i class="fas fa-box text-sm"></i>
                                            </div>
                                            <span class="font-medium">Produk</span>
                                        </div>
                                        <span id="produk-badge-desktop"
                                            class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-2 py-1 animate-pulse shadow-lg">0</span>
                                    </a>
                                @endif
                            @endif
                        </div>
                    </div>
                    @if (session('selected_bisnes_id'))
                        <!-- Customer Management Section -->
                        <div class="pt-2">
                            <h3 class="nav-section-header flex items-center">
                                <div class="section-icon w-8 h-8 rounded-xl flex items-center justify-center mr-4">
                                    <i class="fas fa-users text-sm text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <span class="nav-section-title text-sm block">Customer Management</span>
                                    <span class="text-xs text-white/60 block">Urus pelanggan & prospek</span>
                                </div>
                            </h3>
                            <div class="space-y-0.5">
                                <a href="{{ route('prospek.index') }}"
                                    class="nav-link flex items-center justify-between rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('prospek.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                            <i class="fas fa-search-plus text-sm"></i>
                                        </div>
                                        <span class="font-medium">Prospek</span>
                                    </div>
                                    <span id="customer-badge-desktop"
                                        class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-2 py-1 animate-pulse shadow-lg">0</span>
                                </a>
                                @if ($selectedBisnes && $selectedBisnes->type_id == 1)
                                    <a href="{{ route('customer.index') }}"
                                        class="nav-link flex items-center justify-between px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('customer.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                                <i class="fas fa-handshake text-sm"></i>
                                            </div>
                                            <span class="font-medium">Pelanggan</span>
                                        </div>
                                        <span id="customer-buy-badge-desktop"
                                            class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-2 py-1 animate-pulse shadow-lg">0</span>
                                    </a>

                                    <a href="{{ route('invoice.index') }}"
                                        class="nav-link flex items-center justify-between px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('invoice.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                                <i class="fas fa-file-invoice-dollar text-sm"></i>
                                            </div>
                                            <span class="font-medium">Invoice</span>
                                        </div>
                                        <span id="customer-buy-badge-desktop"
                                            class="hidden bg-gradient-to-r from-red-500 to-pink-500 text-white text-xs rounded-full px-2 py-1 animate-pulse shadow-lg">0</span>
                                    </a>
                                    <a href="{{ route('tracking.index') }}"
                                        class="nav-link flex items-center justify-between px-3 py-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('tracking.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                                <i class="fas fa-route text-sm"></i>
                                            </div>
                                            <span class="font-medium">Tracking</span>
                                        </div>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                    <!-- Account Section -->
                    <div class="pt-2">
                        <h3 class="nav-section-header flex items-center">
                            <div class="section-icon w-8 h-8 rounded-xl flex items-center justify-center mr-4">
                                <i class="fas fa-user text-sm text-white"></i>
                            </div>
                            <div class="flex-1">
                                <span class="nav-section-title text-sm block">Account</span>
                                <span class="text-xs text-white/60 block">Tetapan & profil</span>
                            </div>
                        </h3>
                        <div class="space-y-0.5">
                            <a href="{{ route('settings.index') }}"
                                class="nav-link flex items-center space-x-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('settings.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-cog text-sm"></i>
                                </div>
                                <span class="font-medium">Tetapan</span>
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="nav-link flex items-center space-x-3 rounded-lg transition-all duration-200 hover:bg-white/10 hover:scale-105 {{ !$isFromAi && request()->routeIs('profile.*') ? 'nav-link active bg-white/20 shadow-lg' : '' }}">
                                <div class="w-7 h-7 rounded-lg bg-white/10 flex items-center justify-center">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <span class="font-medium">Profil</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
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

    <!-- Laravel Echo and Pusher for realtime updates -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Initialize notification counters
        let notificationCounts = {
            'produk': 0,
            'prospek': 0,
            'customer-buy': 0,
            'ai': 0
        };

        // Function to update badge
        function updateBadge(type, count) {
            const badges = document.querySelectorAll(`#${type}-badge, #${type}-badge-desktop`);
            badges.forEach(badge => {
                if (count > 0) {
                    badge.textContent = count;
                    badge.classList.remove('hidden');
                } else {
                    badge.classList.add('hidden');
                }
            });
        }

        // Function to update AI badge
        function updateAiBadge(count) {
            updateBadge('ai', count);
        }

        // Function to show notification
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className =
                `fixed top-4 right-4 z-50 bg-${type === 'success' ? 'green' : 'blue'}-500 text-white px-6 py-3 rounded-lg shadow-lg transform transition-all duration-300 translate-x-full`;
            notification.innerHTML = `
                <div class="flex items-center space-x-2">
                    <i class="fas fa-${type === 'success' ? 'check' : 'info'}-circle"></i>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 5 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 5000);
        }

        // Initialize Pusher (using log driver for development)
        // In production, you would configure Pusher properly
        @if (config('broadcasting.default') === 'pusher')
            const pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
                cluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
                encrypted: true
            });
        @else
            // For development with log driver, we'll simulate realtime updates
            console.log('Broadcasting is set to log driver. In production, configure Pusher for realtime updates.');
        @endif

        // Listen for new data events
        @auth
        @if (config('broadcasting.default') === 'pusher')
            const channel = pusher.subscribe('private-user.{{ auth()->id() }}');

            channel.bind('new-data', function(data) {
                console.log('New data received:', data);

                // Update notification count
                if (notificationCounts.hasOwnProperty(data.type)) {
                    notificationCounts[data.type]++;
                    updateBadge(data.type, notificationCounts[data.type]);
                }

                // Show notification
                showNotification(data.data.message, 'success');

                // Update dashboard stats if on dashboard page
                if (window.location.pathname === '/dashboard') {
                    // Trigger Livewire refresh
                    if (window.Livewire) {
                        window.Livewire.dispatch('refreshStats');
                    }
                }
            });
        @else
            // Simulate realtime updates for development
            function simulateRealtimeUpdate(type, message) {
                notificationCounts[type]++;
                updateBadge(type, notificationCounts[type]);
                showNotification(message, 'success');
            }

            // One-time simulation for testing - removed continuous alerts
            // setTimeout(() => {
            //     console.log('Simulating realtime update...');
            //     simulateRealtimeUpdate('produk', 'Produk baru telah ditambah (simulasi)');
            // }, 5000);
        @endif
        @endauth

        // Reset badge when visiting the respective page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPath = window.location.pathname;

            if (currentPath.includes('/produk')) {
                notificationCounts['produk'] = 0;
                updateBadge('produk', 0);
            } else if (currentPath.includes('/customer-buy')) {
                notificationCounts['customer-buy'] = 0;
                updateBadge('customer-buy', 0);
            } else if (currentPath.includes('/prospek')) {
                notificationCounts['prospek'] = 0;
                updateBadge('prospek', 0);
            } else if (currentPath.includes('/ai')) {
                notificationCounts['ai'] = 0;
                updateBadge('ai', 0);
            }
        });

        // Store notification counts in localStorage to persist across page reloads
        function saveNotificationCounts() {
            localStorage.setItem('notificationCounts', JSON.stringify(notificationCounts));
        }

        function loadNotificationCounts() {
            const saved = localStorage.getItem('notificationCounts');
            if (saved) {
                notificationCounts = JSON.parse(saved);
                Object.keys(notificationCounts).forEach(type => {
                    updateBadge(type, notificationCounts[type]);
                });
            }
        }

        // Load counts on page load
        loadNotificationCounts();

        // Save counts when they change
        const originalUpdateBadge = updateBadge;
        updateBadge = function(type, count) {
            originalUpdateBadge(type, count);
            notificationCounts[type] = count;
            saveNotificationCounts();
        };
    </script>
</body>

</html>
