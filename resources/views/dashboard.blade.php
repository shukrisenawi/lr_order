<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Business Management System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .sidebar-glass {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .hover-scale {
            transition: transform 0.2s ease-in-out;
        }

        .hover-scale:hover {
            transform: scale(1.05);
        }

        .pulse-glow {
            animation: pulse-glow 2s ease-in-out infinite alternate;
        }

        @keyframes pulse-glow {
            from {
                box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
            }

            to {
                box-shadow: 0 0 30px rgba(102, 126, 234, 0.8);
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    <nav class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-rocket text-white text-sm"></i>
                            </div>
                            <span class="ml-2 text-white font-bold text-xl">SumoPod</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Notifications -->
                    <button class="relative p-2 text-white/80 hover:text-white transition-colors">
                        <i class="fas fa-bell text-lg"></i>
                        <span
                            class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full text-xs flex items-center justify-center">3</span>
                    </button>

                    <!-- User Menu -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 text-white">
                            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center">
                                <i class="fas fa-user text-sm"></i>
                            </div>
                            <span class="hidden md:block">{{ Auth::user()->name ?? 'User' }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
            <div class="p-4">
                <nav class="space-y-2">
                    <!-- Dashboard -->
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center space-x-3 px-4 py-3 bg-purple-100 text-purple-700 rounded-lg">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Business Management Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Business
                            Management</h3>
                        <div class="mt-2 space-y-1">
                            <a href="{{ route('bisnes.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-building"></i>
                                <span>Bisnes</span>
                            </a>
                            <a href="{{ route('produk.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-box"></i>
                                <span>Produk</span>
                            </a>
                            <a href="{{ route('gambar.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
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
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-users"></i>
                                <span>Prospek</span>
                            </a>
                            <a href="{{ route('prospek-alamat.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Alamat Prospek</span>
                            </a>
                            <a href="{{ route('prospek-buy.index') }}"
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Pembelian</span>
                            </a>
                        </div>
                    </div>

                    <!-- Account Section -->
                    <div class="pt-4">
                        <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Account</h3>
                        <div class="mt-2 space-y-1">
                            <a href="#"
                                class="flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                                <i class="fas fa-cog"></i>
                                <span>Settings</span>
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center space-x-3 px-4 py-3 text-gray-700 hover:bg-red-50 hover:text-red-700 rounded-lg transition-colors">
                                    <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Welcome Section -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Welcome back, {{ Auth::user()->name ?? 'User' }}! 👋
                </h1>
                <p class="text-gray-600">Here's what's happening with your projects today.</p>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-folder text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Projects</p>
                            <p class="text-2xl font-bold text-gray-900">12</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-check-circle text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Completed</p>
                            <p class="text-2xl font-bold text-gray-900">8</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">In Progress</p>
                            <p class="text-2xl font-bold text-gray-900">3</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm p-6 hover-scale">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-users text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Team Members</p>
                            <p class="text-2xl font-bold text-gray-900">24</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Projects -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Recent Projects -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Recent Projects</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-code text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">E-commerce Platform</p>
                                        <p class="text-sm text-gray-500">Updated 2 hours ago</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-mobile-alt text-purple-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Mobile App Design</p>
                                        <p class="text-sm text-gray-500">Updated 1 day ago</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full">In
                                    Progress</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-chart-line text-green-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">Analytics Dashboard</p>
                                        <p class="text-sm text-gray-500">Updated 3 days ago</p>
                                    </div>
                                </div>
                                <span
                                    class="px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full">Active</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <button
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-plus text-2xl text-gray-600 mb-2"></i>
                                <span class="text-sm text-gray-700">New Project</span>
                            </button>
                            <button
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-user-plus text-2xl text-gray-600 mb-2"></i>
                                <span class="text-sm text-gray-700">Invite Team</span>
                            </button>
                            <button
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-upload text-2xl text-gray-600 mb-2"></i>
                                <span class="text-sm text-gray-700">Upload Files</span>
                            </button>
                            <button
                                class="flex flex-col items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <i class="fas fa-chart-bar text-2xl text-gray-600 mb-2"></i>
                                <span class="text-sm text-gray-700">View Reports</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Feed -->
            <div class="bg-white rounded-xl shadow-sm">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center mt-1">
                                <i class="fas fa-plus text-blue-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-900"><strong>You</strong> created a new project
                                    <strong>E-commerce Platform</strong>
                                </p>
                                <p class="text-xs text-gray-500">2 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mt-1">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-900"><strong>Sarah Chen</strong> completed task
                                    <strong>Design Homepage</strong>
                                </p>
                                <p class="text-xs text-gray-500">4 hours ago</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center mt-1">
                                <i class="fas fa-user-plus text-purple-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-900"><strong>Mike Johnson</strong> joined the team</p>
                                <p class="text-xs text-gray-500">1 day ago</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center mt-1">
                                <i class="fas fa-comment text-yellow-600 text-sm"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-gray-900"><strong>Emma Wilson</strong> commented on
                                    <strong>Mobile App Design</strong>
                                </p>
                                <p class="text-xs text-gray-500">2 days ago</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script>
        // Add logout functionality
        document.addEventListener('DOMContentLoaded', function() {
            const userMenu = document.querySelector('button[aria-haspopup="true"]');
            if (userMenu) {
                userMenu.addEventListener('click', function() {
                    document.getElementById('logout-form').submit();
                });
            }
        });
    </script>
</body>

</html>
