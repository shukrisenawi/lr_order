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
        // dd(session('selected_bisnes_id'));
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->paginate(10);
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

        // Check if files are uploaded
        if (!$request->hasFile('gambar')) {
            return back()->withErrors(['gambar' => 'Sila pilih sekurang-kurangnya satu gambar untuk dimuat naik.'])->withInput();
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'gambar' => 'required|array|min:1',
            'gambar.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'nama.required' => 'Nama gambar diperlukan.',
            'gambar.required' => 'Sila pilih sekurang-kurangnya satu gambar.',
            'gambar.array' => 'Format gambar tidak sah.',
            'gambar.min' => 'Sila pilih sekurang-kurangnya satu gambar.',
            'gambar.*.required' => 'Setiap fail gambar diperlukan.',
            'gambar.*.image' => 'Fail yang dipilih mestilah gambar.',
            'gambar.*.mimes' => 'Gambar mestilah dalam format: jpeg, png, jpg, gif.',
            'gambar.*.max' => 'Saiz gambar tidak boleh melebihi 2MB.',
        ]);

        $uploadedCount = 0;
        $files = $request->file('gambar');
        $errors = [];

        // Ensure storage directory exists
        if (!Storage::disk('public')->exists('gambar')) {
            Storage::disk('public')->makeDirectory('gambar');
        }

        foreach ($files as $index => $file) {
            if ($file && $file->isValid()) {
                $path = $file->store('gambar', 'public');
                Log::info('File stored', ['path' => $path, 'index' => $index]);

                $nama = count($files) > 1 ? $request->nama . ' - ' . ($index + 1) : $request->nama;

                // Get the selected business ID from session or use the first business
                $bisnesId = session('selected_bisnes_id');
                if (!$bisnesId) {
                    $firstBisnes = auth()->user()->bisnes()->first();
                    $bisnesId = $firstBisnes ? $firstBisnes->id : null;
                }

                // If still no business ID, create a default one or handle the error
                if (!$bisnesId) {
                    throw new \Exception('Tiada bisnes dijumpai. Sila cipta bisnes terlebih dahulu.');
                }

                $gambar = Gambar::create([
                    'bisnes_id' => $bisnesId,
                    'nama' => $nama,
                    'path' => $path,
                ]);

                $uploadedCount++;
            } else {
                $errors[] = "Fail " . ($index + 1) . " tidak sah atau rosak.";
            }
        }

        if ($uploadedCount > 0) {
            $message = $uploadedCount . ' gambar berjaya dimuat naik.';
            if (!empty($errors)) {
                $message .= ' Namun, terdapat beberapa ralat: ' . implode(', ', $errors);
            }
            return redirect()->route('gambar.index')->with('success', $message);
        } else {
            return back()->withErrors(['error' => 'Tiada gambar berjaya dimuat naik. ' . implode(', ', $errors)])->withInput();
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
