<?php

namespace App\Http\Controllers;

use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
        try {
            Log::info('Gambar store method called', ['request_data' => $request->all()]);

            $request->validate([
                'nama' => 'required|string|max:255',
                'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            Log::info('Validation passed');

            $path = $request->file('gambar')->store('gambar', 'public');
            Log::info('File stored', ['path' => $path]);

            $gambar = Gambar::create([
                'nama' => $request->nama,
                'path' => $path,
            ]);

            Log::info('Gambar created', ['gambar_id' => $gambar->id]);

            return redirect()->route('gambar.index')->with('success', 'Gambar uploaded successfully.');
        } catch (\Exception $e) {
            Log::error('Error in gambar store', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Error uploading image: ' . $e->getMessage()])->withInput();
        }
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
            if ($gambar->path) {
                Storage::disk('public')->delete($gambar->path);
            }
            $data['path'] = $request->file('gambar')->store('gambar', 'public');
        }

        $gambar->update($data);

        return redirect()->route('gambar.index')->with('success', 'Gambar updated successfully.');
    }

    public function destroy(Gambar $gambar)
    {
        if ($gambar->path) {
            Storage::disk('public')->delete($gambar->path);
        }
        $gambar->delete();

        return redirect()->route('gambar.index')->with('success', 'Gambar deleted successfully.');
    }
}
