<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GambarController extends Controller
{
    public function index()
    {
        $gambar = Gambar::paginate(10);
        return view('gambar.index', compact('gambar'));
    }

    public function create()
    {
        return view('gambar.create');
    }

    public function show(Gambar $gambar)
    {
        return view('gambar.show', compact('gambar'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $request->file('gambar')->store('gambar', 'public');

        Gambar::create([
            'nama' => $request->nama,
            'gambar' => $path,
        ]);

        return redirect()->route('gambar.index')->with('success', 'Gambar uploaded successfully.');
    }

    public function edit(Gambar $gambar)
    {
        return view('gambar.edit', compact('gambar'));
    }

    public function update(Request $request, Gambar $gambar)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = ['nama' => $request->nama];

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($gambar->gambar) {
                Storage::disk('public')->delete($gambar->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('gambar', 'public');
        }

        $gambar->update($data);

        return redirect()->route('gambar.index')->with('success', 'Gambar updated successfully.');
    }

    public function destroy(Gambar $gambar)
    {
        if ($gambar->gambar) {
            Storage::disk('public')->delete($gambar->gambar);
        }
        $gambar->delete();

        return redirect()->route('gambar.index')->with('success', 'Gambar deleted successfully.');
    }
}
