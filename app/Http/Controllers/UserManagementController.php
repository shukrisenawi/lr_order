<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bisnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = User::with('bisnes')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $bisnes = Bisnes::all();
        return view('admin.users.create', compact('bisnes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'bisnes_ids' => 'array',
            'bisnes_ids.*' => 'exists:bisnes,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        if ($request->has('bisnes_ids')) {
            $user->bisnes()->attach($request->bisnes_ids);
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function show(User $user)
    {
        $user->load('bisnes');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $bisnes = Bisnes::all();
        $user->load('bisnes');
        return view('admin.users.edit', compact('user', 'bisnes'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'bisnes_ids' => 'array',
            'bisnes_ids.*' => 'exists:bisnes,id',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        $user->bisnes()->sync($request->bisnes_ids ?? []);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->bisnes()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}
