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
            --sidebar-gradient: linear-gradient(135deg, #4361ee 0%, #3a0ca3 100%);
            --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f8f9fa;
        }

        .gradient-header {
            background: var(--primary-gradient);
        }

        .sidebar-gradient {
            background: var(--sidebar-gradient);
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

        .nav-section-title {
            color: rgba(255, 255, 255, 0.7);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            border-left: 3px solid white;
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
            mobileMenu.classList.toggle('hidden');
            overlay.classList.toggle('hidden');
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

    <!-- Header -->
    <header class="gradient-header shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button id="mobile-menu-button" type="button"
                        class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none"
                        onclick="toggleMobileMenu()">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h1 class="ml-2 md:ml-0 text-xl font-bold text-white">Sistem SH BEST CREATIVE DESIGN</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Business Selector -->
                    <div class="relative hidden md:block">
                        @php
                            $userBisnes = Bisnes::where('user_id', Auth::id())->get();
                            $selectedBisnes = session('selected_bisnes_id')
                                ? Bisnes::find(session('selected_bisnes_id'))
                                : 0;

                        @endphp

                        @if ($userBisnes->count() > 0)
                            <div class="relative inline-block text-left">
                                <button type="button"
                                    class="inline-flex items-center px-4 py-2 border border-white/20 shadow-sm text-sm leading-4 font-medium rounded-lg text-white bg-white/10 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200"
                                    id="bisnes-menu-button" aria-expanded="true" aria-haspopup="true"
                                    onclick="toggleBisnesDropdown()">
                                    <i class="fas fa-building mr-2"></i>
                                    {{ $selectedBisnes ? $selectedBisnes->nama_bisnes : 'Pilih Senarai' }}
                                    <i class="fas fa-chevron-down ml-2"></i>
                                </button>

                                <div class="origin-top-right absolute right-0 mt-2 w-64 rounded-xl shadow-2xl bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50"
                                    id="bisnes-dropdown" role="menu" aria-orientation="vertical"
                                    aria-labelledby="bisnes-menu-button">
                                    <div class="py-2" role="none">
                                        @foreach ($userBisnes as $bisnes)
                                            <a href="{{ route('switch-bisnes', $bisnes->id) }}"
                                                class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 {{ $selectedBisnes && $selectedBisnes->id == $bisnes->id ? 'bg-gray-50 font-medium' : '' }} transition-colors"
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

                                        <div class="border-t border-gray-100 my-1"></div>
                                        <a href="{{ route('bisnes.index') }}"
                                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 transition-colors"
                                            role="menuitem">
                                            <i class="fas fa-building mr-3 text-gray-400"></i>
                                            Senarai Bisnes
                                            @if (!$selectedBisnes)
                                                <i class="fas fa-check ml-auto text-green-500"></i>
                                            @endif
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('bisnes.create') }}"
                                class="hidden md:inline-flex items-center px-4 py-2 border border-transparent text-sm leading-4 font-medium rounded-lg text-white bg-white/20 hover:bg-white/30 focus:outline-none focus:ring-2 focus:ring-white/30 transition-all duration-200 pulse-glow">
                                <i class="fas fa-plus mr-2"></i>
                                Tambah Bisnes
                            </a>
                        @endif
                    </div>

                    <div class="flex items-center space-x-3">
                        <span class="hidden md:inline text-white font-medium">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-white hover:text-white/80 transition-colors">
                                <i class="fas fa-sign-out-alt text-xl"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="flex">
        <!-- Mobile Sidebar -->
        <div id="mobile-menu" class="md:hidden fixed inset-0 z-50 hidden">
            <div class="sidebar-gradient h-full w-64 p-4 overflow-y-auto">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-white text-lg font-bold">Menu</h2>
                    <button onclick="toggleMobileMenu()" class="text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'nav-link active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Data Table -->
                    <a href="{{ route('data-table') }}"
                        class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('data-table') ? 'nav-link active' : '' }}">
                        <i class="fas fa-table"></i>
                        <span>Jadual Data</span>
                    </a>

                    <!-- Business Management Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold nav-section-title uppercase tracking-wider">Business
                            Management</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('bisnes.index') }}"
                                class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('bisnes.*') ? 'nav-link active' : '' }}">
                                <i class="fas fa-building"></i>
                                <span>Bisnes</span>
                            </a>
                            <a href="{{ route('gambar.index') }}"
                                class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('gambar.*') ? 'nav-link active' : '' }}">
                                <i class="fas fa-images"></i>
                                <span>Gambar</span>
                            </a>
                            <a href="{{ route('produk.index') }}"
                                class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('produk.*') ? 'nav-link active' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-box"></i>
                                    <span>Produk</span>
                                </div>
                                <span id="produk-badge"
                                    class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                            </a>
                        </div>
                    </div>

                    <!-- Customer Management Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold nav-section-title uppercase tracking-wider">Customer
                            Management</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('prospek.index') }}"
                                class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('prospek.*') ? 'nav-link active' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-users"></i>
                                    <span>Prospek</span>
                                </div>
                                <span id="customer-badge"
                                    class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                            </a>
                            <a href="{{ route('customer-alamat.index') }}"
                                class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('customer-alamat.*') ? 'nav-link active' : '' }}">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Alamat Prospek</span>
                            </a>
                            <a href="{{ route('customer-buy.index') }}"
                                class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('customer-buy.*') ? 'nav-link active' : '' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-shopping-cart"></i>
                                    <span>Pembelian</span>
                                </div>
                                <span id="customer-buy-badge"
                                    class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                            </a>
                        </div>
                    </div>

                    <!-- Account Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold nav-section-title uppercase tracking-wider">Account</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('settings.index') }}"
                                class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('settings.*') ? 'nav-link active' : '' }}">
                                <i class="fas fa-cog"></i>
                                <span>Tetapan</span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Desktop Sidebar -->
        <aside class="hidden md:block w-64 sidebar-gradient h-screen sticky top-0">
            <div class="p-4 overflow-y-auto h-full">
                <nav class="space-y-1">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('dashboard') ? 'nav-link active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Data Table -->
                    <a href="{{ route('data-table') }}"
                        class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('data-table') ? 'nav-link active' : '' }}">
                        <i class="fas fa-table"></i>
                        <span>Jadual Data</span>
                    </a>

                    <!-- Business Management Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold nav-section-title uppercase tracking-wider">Business
                            Management</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('bisnes.index') }}"
                                class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('bisnes.*') ? 'nav-link active' : '' }}">
                                <i class="fas fa-building"></i>
                                <span>Bisnes</span>
                            </a>
                            @if (session('selected_bisnes_id'))
                                <a href="{{ route('gambar.index') }}"
                                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('gambar.*') ? 'nav-link active' : '' }}">
                                    <i class="fas fa-images"></i>
                                    <span>Gambar</span>
                                </a>
                                <a href="{{ route('produk.index') }}"
                                    class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('produk.*') ? 'nav-link active' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-box"></i>
                                        <span>Produk</span>
                                    </div>
                                    <span id="produk-badge-desktop"
                                        class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                                </a>
                            @endif
                        </div>
                    </div>
                    @if (session('selected_bisnes_id'))
                        <!-- Customer Management Section -->
                        <div class="pt-4">
                            <h3 class="px-4 text-xs font-semibold nav-section-title uppercase tracking-wider">Customer
                                Management</h3>
                            <div class="mt-2 space-y-1">
                                <a href="{{ route('prospek.index') }}"
                                    class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('prospek.*') ? 'nav-link active' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-users"></i>
                                        <span>Prospek</span>
                                    </div>
                                    <span id="customer-badge-desktop"
                                        class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                                </a>
                                <a href="{{ route('customer.index') }}"
                                    class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('customer.*') ? 'nav-link active' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-user-secret"></i>
                                        <span>Pelanggan</span>
                                    </div>
                                    <span id="customer-buy-badge-desktop"
                                        class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                                </a>
                                <a href="{{ route('customer-alamat.index') }}"
                                    class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('customer-alamat.*') ? 'nav-link active' : '' }}">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>Alamat Pelanggan</span>
                                </a>
                                <a href="{{ route('customer-buy.index') }}"
                                    class="nav-link flex items-center justify-between px-4 py-3 rounded-lg transition-all {{ request()->routeIs('customer-buy.*') ? 'nav-link active' : '' }}">
                                    <div class="flex items-center space-x-3">
                                        <i class="fas fa-shopping-cart"></i>
                                        <span>Invoice</span>
                                    </div>
                                    <span id="customer-buy-badge-desktop"
                                        class="hidden bg-red-500 text-white text-xs rounded-full px-2 py-1 animate-pulse">0</span>
                                </a>
                            </div>
                        </div>
                    @endif
                    <!-- Account Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold nav-section-title uppercase tracking-wider">Account</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('settings.index') }}"
                                class="nav-link flex items-center space-x-3 px-4 py-3 rounded-lg transition-all {{ request()->routeIs('settings.*') ? 'nav-link active' : '' }}">
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

    <!-- Laravel Echo and Pusher for realtime updates -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script>
        // Initialize notification counters
        let notificationCounts = {
            'produk': 0,
            'prospek': 0,
            'customer-buy': 0
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
