<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use App\Models\User;
use App\Helpers\BisnesHelper;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login-new');
    }

    public function login(LoginRequest $request)
    {
        // Rate limiting - max 5 attempts per minute
        $key = 'login-attempts-' . $request->ip();
        
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'username' => 'Terlalu banyak percubaan log masuk. Sila cuba lagi dalam ' . $seconds . ' saat.',
            ])->withInput($request->only('username'));
        }

        // Allow login with username or email
        $user = User::where('name', $request->username)
                   ->orWhere('email', $request->username)
                   ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            // Check if email is verified
            if (!$user->hasVerifiedEmail()) {
                return back()->withErrors([
                    'username' => 'Sila sahkan emel anda sebelum log masuk.',
                ])->withInput($request->only('username'));
            }

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
            'username' => 'Maklumat log masuk tidak sepadan dengan rekod kami.',
        ])->withInput($request->only('username'));
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => null, // Will be set after verification
        ]);

        // Send email verification
        $user->sendEmailVerificationNotification();

        // Auto login after registration (but restrict access until email verified)
        Auth::login($user);

        return redirect()->route('verification.notice')
                        ->with('success', 'Pendaftaran berjaya! Sila semak emel anda untuk pengesahan.');
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
