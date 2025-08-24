<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use App\Helpers\BisnesHelper;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-new');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        // Rate limiting - max 5 attempts per minute
        $key = 'login-attempts-' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'username' => 'Too many login attempts. Please try again in ' . $seconds . ' seconds.',
            ])->withInput($request->only('username'));
        }

        // Allow login with username or email
        $user = User::where('name', $request->username)
                   ->orWhere('email', $request->username)
                   ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Clear rate limiter on successful login
            RateLimiter::clear($key);
            
            // Regenerate session for security
            $request->session()->regenerate();
            
            // Login with remember me functionality
            Auth::login($user, $request->boolean('remember'));
            
            return redirect()->intended('/dashboard');
        }

        // Increment failed attempts
        RateLimiter::hit($key, 60);

        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('username'));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    public function dashboard()
    {
        $selectedBisnes = BisnesHelper::getSelectedBisnes();

        if (!$selectedBisnes) {
            // If no business selected, show overall stats for user
            $totalBisnes = \App\Models\Bisnes::where('user_id', auth()->id())->count();
            $totalProduk = 0;
            $totalProspek = 0;
            $totalPembelian = 0;
        } else {
            // Show stats for selected business
            $totalBisnes = \App\Models\Bisnes::where('user_id', auth()->id())->count();
            $totalProduk = \App\Models\Produk::where('bisnes_id', $selectedBisnes->id)->count();
            $totalProspek = \App\Models\Prospek::where('bisnes_id', $selectedBisnes->id)->count();
            $totalPembelian = \App\Models\ProspekBuy::whereHas('prospek', function ($query) use ($selectedBisnes) {
                $query->where('bisnes_id', $selectedBisnes->id);
            })->count();
        }

        return view('dashboard-new', compact(
            'totalBisnes',
            'totalProduk',
            'totalProspek',
            'totalPembelian',
            'selectedBisnes'
        ));
    }
}
