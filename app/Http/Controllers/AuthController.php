<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Helpers\BisnesHelper;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Check if user exists with the username
        $user = User::where('name', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended('/dashboard');
        }

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
