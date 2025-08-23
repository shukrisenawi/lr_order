<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SumoPod</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .header {
            background: white;
            padding: 1rem 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
        }

        .logo-icon {
            width: 32px;
            height: 32px;
            background: #4285f4;
            border-radius: 8px;
            margin-right: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
        }

        .nav-links a:hover {
            color: #333;
        }

        .auth-buttons {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .btn-login {
            background: none;
            border: none;
            color: #666;
            font-weight: 500;
            cursor: pointer;
            padding: 0.5rem 1rem;
        }

        .btn-get-started {
            background: #4285f4;
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
        }

        .main-content {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .login-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 3rem;
            width: 100%;
            max-width: 400px;
        }

        .login-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            color: #333;
            font-weight: 500;
        }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e1e5e9;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            outline: none;
            border-color: #4285f4;
        }

        .form-input.error {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .login-button {
            width: 100%;
            background: #4285f4;
            color: white;
            border: none;
            padding: 0.875rem;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .login-button:hover {
            background: #3367d6;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            color: #666;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e1e5e9;
            z-index: 1;
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            position: relative;
            z-index: 2;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="logo">
            <div class="logo-icon">S</div>
            SumoPod
        </div>
        <nav class="nav-links">
            <a href="#">Home</a>
            <a href="#">Templates</a>
            <a href="#">Pricing</a>
            <a href="#">Features</a>
        </nav>
        <div class="auth-buttons">
            <button class="btn-login">🔓 Login</button>
            <button class="btn-get-started">Get Started</button>
        </div>
    </header>

    <main class="main-content">
        <div class="login-container">
            <h1 class="login-title">Welcome back</h1>
            <p class="login-subtitle">Sign in to your account to continue</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="form-group">
                    <label for="username" class="form-label">Username</label>
                    <input 
                        type="text" 
                        id="username" 
                        name="username" 
                        class="form-input @error('username') error @enderror"
                        value="{{ old('username') }}"
                        placeholder="Enter your username"
                        required
                    >
                    @error('username')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input @error('password') error @enderror"
                        placeholder="Enter your password"
                        required
                    >
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="login-button">Sign In</button>
            </form>

            <div class="divider">
                <span>Or continue with email</span>
            </div>

            <p style="text-align: center; color: #666; margin-top: 1.5rem;">
                Don't have an account? <a href="#" style="color: #4285f4; text-decoration: none;">Sign up</a>
            </p>
        </div>
    </main>
</body>
</html>
