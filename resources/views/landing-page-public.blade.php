<!DOCTYPE html>
<html lang="ms">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $landingPage->meta_title ?? $landingPage->title }} - {{ config('app.name', 'Laravel') }}</title>

    @if($landingPage->meta_description)
        <meta name="description" content="{{ $landingPage->meta_description }}">
    @endif

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Content styles */
        .landing-content {
            line-height: 1.7;
        }

        .landing-content h1,
        .landing-content h2,
        .landing-content h3,
        .landing-content h4,
        .landing-content h5,
        .landing-content h6 {
            color: #1f2937;
            font-weight: 600;
            margin-top: 1.5em;
            margin-bottom: 0.5em;
        }

        .landing-content h1 { font-size: 2.25rem; }
        .landing-content h2 { font-size: 1.875rem; }
        .landing-content h3 { font-size: 1.5rem; }
        .landing-content h4 { font-size: 1.25rem; }
        .landing-content h5 { font-size: 1.125rem; }
        .landing-content h6 { font-size: 1rem; }

        .landing-content p {
            margin-bottom: 1em;
            color: #374151;
        }

        .landing-content ul,
        .landing-content ol {
            margin-bottom: 1em;
            padding-left: 1.5em;
        }

        .landing-content li {
            margin-bottom: 0.25em;
            color: #374151;
        }

        .landing-content a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .landing-content a:hover {
            color: #1d4ed8;
        }

        .landing-content blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1em;
            margin: 1.5em 0;
            font-style: italic;
            color: #6b7280;
        }

        .landing-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1em 0;
        }

        .landing-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1em 0;
        }

        .landing-content th,
        .landing-content td {
            border: 1px solid #d1d5db;
            padding: 0.5em;
            text-align: left;
        }

        .landing-content th {
            background-color: #f9fafb;
            font-weight: 600;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="text-xl font-bold text-gray-900">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-gray-900 transition-colors">Home</a>
                    <a href="#contact" class="text-gray-600 hover:text-gray-900 transition-colors">Contact</a>
                </nav>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="min-h-screen">
        <!-- Hero Section (if this is a hero template) -->
        @if($landingPage->template === 'corporate' || $landingPage->template === 'default')
            <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-20">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        {{ $landingPage->title }}
                    </h1>
                    @if($landingPage->meta_description)
                        <p class="text-xl md:text-2xl mb-8 opacity-90">
                            {{ $landingPage->meta_description }}
                        </p>
                    @endif
                </div>
            </section>
        @else
            <!-- Simple header for minimal template -->
            <section class="bg-white py-12 border-b">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        {{ $landingPage->title }}
                    </h1>
                    @if($landingPage->meta_description)
                        <p class="text-lg text-gray-600">
                            {{ $landingPage->meta_description }}
                        </p>
                    @endif
                </div>
            </section>
        @endif

        <!-- Content Section -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-lg shadow-sm p-8 md:p-12">
                    <div class="landing-content prose prose-lg max-w-none">
                        {!! $landingPage->content !!}
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="bg-gray-100 py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Hubungi Kami</h2>
                <p class="text-gray-600 mb-8">
                    Ada soalan? Jangan ragu untuk menghubungi kami.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
                    <a href="mailto:info@example.com"
                       class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-envelope mr-2"></i>
                        Email Kami
                    </a>
                    <a href="tel:+60123456789"
                       class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition-colors">
                        <i class="fas fa-phone mr-2"></i>
                        Hubungi Kami
                    </a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">{{ config('app.name', 'Laravel') }}</h3>
                    <p class="text-gray-400">
                        Menyediakan perkhidmatan terbaik untuk komuniti kami.
                    </p>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Pautan Cepat</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ url('/') }}" class="text-gray-400 hover:text-white transition-colors">Laman Utama</a></li>
                        <li><a href="#contact" class="text-gray-400 hover:text-white transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Maklumat Hubungan</h3>
                    <div class="space-y-2 text-gray-400">
                        <p><i class="fas fa-envelope mr-2"></i> info@example.com</p>
                        <p><i class="fas fa-phone mr-2"></i> +60 123 456 789</p>
                        <p><i class="fas fa-map-marker-alt mr-2"></i> Malaysia</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Back to Top Button -->
    <button id="backToTop"
            class="fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-colors opacity-0 invisible">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script>
        // Back to top functionality
        const backToTopButton = document.getElementById('backToTop');

        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });
    </script>
</body>
</html>