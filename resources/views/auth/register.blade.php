<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - SumoPod</title>
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

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }

            100% {
                transform: translateY(0px) rotate(0deg);
            }
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

<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <!-- Background Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div
            class="floating-animation absolute top-20 left-20 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70">
        </div>
        <div class="floating-animation absolute top-40 right-20 w-72 h-72 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70"
            style="animation-delay: 2s;"></div>
        <div class="floating-animation absolute bottom-20 left-40 w-72 h-72 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70"
            style="animation-delay: 4s;"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-md">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-2xl backdrop-blur-sm mb-4">
                <i class="fas fa-rocket text-3xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">SumoPod</h1>
            <p class="text-white/80 text-lg">Create your account</p>
        </div>

        <!-- Register Form Container -->
        <div class="glass-effect rounded-2xl p-8 shadow-2xl pulse-glow">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-white mb-2">Sign Up</h2>
                <p class="text-white/70">Join our community today</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name Field -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white/90 mb-2">
                        <i class="fas fa-user mr-2"></i>Full Name
                    </label>
                    <div class="relative">
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                            placeholder="Enter your full name" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-user text-white/50"></i>
                        </div>
                    </div>
                    @error('name')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username Field -->
                <div>
                    <label for="username" class="block text-sm font-medium text-white/90 mb-2">
                        <i class="fas fa-at mr-2"></i>Username
                    </label>
                    <div class="relative">
                        <input type="text" id="username" name="username" value="{{ old('username') }}"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                            placeholder="Choose a username" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-at text-white/50"></i>
                        </div>
                    </div>
                    @error('username')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white/90 mb-2">
                        <i class="fas fa-envelope mr-2"></i>Email Address
                    </label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                            placeholder="Enter your email" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-envelope text-white/50"></i>
                        </div>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white/90 mb-2">
                        <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                            placeholder="Create a password" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-white/50 cursor-pointer hover:text-white" id="togglePassword"></i>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-300">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-white/90 mb-2">
                        <i class="fas fa-lock mr-2"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder-white/50 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all duration-200"
                            placeholder="Confirm your password" required>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <i class="fas fa-eye text-white/50 cursor-pointer hover:text-white"
                                id="toggleConfirmPassword"></i>
                        </div>
                    </div>
                </div>

                <!-- Terms Checkbox -->
                <div class="flex items-start">
                    <input type="checkbox" name="terms" id="terms"
                        class="w-4 h-4 mt-1 bg-white/20 border-white/30 rounded text-purple-400 focus:ring-purple-400"
                        required>
                    <label for="terms" class="ml-2 text-sm text-white/80">
                        I agree to the <a href="#" class="text-white hover:text-white/80 transition-colors">Terms
                            of Service</a> and <a href="#"
                            class="text-white hover:text-white/80 transition-colors">Privacy Policy</a>
                    </label>
                </div>
                @error('terms')
                    <p class="text-sm text-red-300">{{ $message }}</p>
                @enderror

                <!-- Register Button -->
                <button type="submit"
                    class="w-full bg-white/20 hover:bg-white/30 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-white/50">
                    <i class="fas fa-user-plus mr-2"></i>Create Account
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-white/20"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-transparent text-white/60">Or sign up with</span>
                </div>
            </div>

            <!-- Social Login -->
            <div class="grid grid-cols-2 gap-4">
                <button
                    class="flex items-center justify-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-white transition-all duration-200">
                    <i class="fab fa-google mr-2"></i>Google
                </button>
                <button
                    class="flex items-center justify-center px-4 py-2 bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl text-white transition-all duration-200">
                    <i class="fab fa-github mr-2"></i>GitHub
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-white/70">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-white font-semibold hover:text-white/80 transition-colors">Sign in</a>
                </p>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-white/60 text-sm">
                <i class="fas fa-shield-alt mr-1"></i>Your data is encrypted and secure
            </p>
        </div>
    </div>

    <!-- JavaScript for password toggles -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const password = document.querySelector('#password');
        const confirmPassword = document.querySelector('#password_confirmation');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        toggleConfirmPassword.addEventListener('click', function(e) {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>

</html>
