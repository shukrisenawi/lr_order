<?php

namespace App\Http\Controllers;

use App\Models\Bisnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BisnesController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $bisnes = Bisnes::where('user_id', Auth::id())->paginate(10);
        return view('bisnes.index', compact('bisnes'));
    }

    public function create()
    {
        return view('bisnes.create');
    }

    public function show(Bisnes $bisnes)
    {

        return view('bisnes.show', ['bisnes' => $bisnes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bisnes' => 'required|string|max:255',
            'exp_date' => 'nullable|date',
            'nama_syarikat' => 'required|string|max:255',
            'no_pendaftaran' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
            'on' => 'nullable|boolean',
            'system_message' => 'required|string',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'nama_bisnes' => $request->nama_bisnes,
            'exp_date' => $request->exp_date,
            'nama_syarikat' => $request->nama_syarikat,
            'no_pendaftaran' => $request->no_pendaftaran,
            'alamat' => $request->alamat,
            'poskod' => $request->poskod,
            'no_tel' => $request->no_tel,
            'on' => $request->on,
            'system_message' => $request->system_message,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('bisnes', 'public');
            $data['gambar'] = basename($path);
        }

        Bisnes::create($data);

        return redirect()->route('bisnes.index')->with('success', 'Business created successfully.');
    }

    public function edit(Bisnes $bisne)
    {
        return view('bisnes.edit', ['bisnes' => $bisne]);
    }

    public function update(Request $request, Bisnes $bisnes)
    {
        // dd($request->all());
        try {
            $request->merge(['on' => $request->has('on') ? true : false]);

            $request->validate([
                'nama_bisnes' => 'required|string|max:255',
                'exp_date' => 'nullable|date',
                'nama_syarikat' => 'required|string|max:255',
                'no_pendaftaran' => 'nullable|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'alamat' => 'required|string',
                'poskod' => 'required|string|max:10',
                'no_tel' => 'required|string|max:20',
                'on' => 'nullable|boolean',
                'system_message' => 'required|string',
            ]);

            $data = $request->all();

            if ($request->hasFile('gambar')) {
                // Delete old image if exists*----------------------------
                if ($bisnes->gambar && Storage::disk('public')->exists('bisnes/' . $bisnes->gambar)) {
                    Storage::disk('public')->delete('bisnes/' . $bisnes->gambar);
                }

                $path = $request->file('gambar')->store('bisnes', 'public');
                $data['gambar'] = basename($path);
            }

            $bisnes->update($data);

            return redirect()->route('bisnes.index')->with('success', 'Business updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal update task: ' . $e->getMessage());
        }
    }

    public function destroy(Bisnes $bisne)
    {
        // Temporarily disable authorization for testing
        // $this->authorize('delete', $bisne);

        // Delete image if exists
        if ($bisne->gambar && file_exists(public_path('images/bisnes/' . $bisne->gambar))) {
            unlink(public_path('images/bisnes/' . $bisne->gambar));
        }

        $bisne->delete();

        return redirect()->route('bisnes.index')->with('success', 'Business deleted successfully.');
    }
}
