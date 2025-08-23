<?php

namespace App\Http\Controllers;

use App\Models\Bisnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BisnesController extends Controller
{
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
        $this->authorize('view', $bisnes);
        return view('bisnes.show', compact('bisnes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_bines' => 'required|string|max:255',
            'exp_date' => 'required|date',
            'nama_syarikat' => 'required|string|max:255',
            'no_pendaftaran' => 'required|string|max:255',
            'jenis_bisnes' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'nama_bines' => $request->nama_bines,
            'exp_date' => $request->exp_date,
            'nama_syarikat' => $request->nama_syarikat,
            'no_pendaftaran' => $request->no_pendaftaran,
            'jenis_bisnes' => $request->jenis_bisnes,
            'alamat' => $request->alamat,
            'poskod' => $request->poskod,
            'no_tel' => $request->no_tel,
        ];

        if ($request->hasFile('gambar')) {
            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/bisnes'), $imageName);
            $data['gambar'] = $imageName;
        }

        Bisnes::create($data);

        return redirect()->route('bisnes.index')->with('success', 'Business created successfully.');
    }

    public function edit(Bisnes $bisnes)
    {
        $this->authorize('update', $bisnes);
        return view('bisnes.edit', compact('bisnes'));
    }

    public function update(Request $request, Bisnes $bisnes)
    {
        $this->authorize('update', $bisnes);

        $request->validate([
            'nama_bines' => 'required|string|max:255',
            'exp_date' => 'required|date',
            'nama_syarikat' => 'required|string|max:255',
            'no_pendaftaran' => 'required|string|max:255',
            'jenis_bisnes' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($bisnes->gambar && file_exists(public_path('images/bisnes/' . $bisnes->gambar))) {
                unlink(public_path('images/bisnes/' . $bisnes->gambar));
            }

            $imageName = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/bisnes'), $imageName);
            $data['gambar'] = $imageName;
        }

        $bisnes->update($data);

        return redirect()->route('bisnes.index')->with('success', 'Business updated successfully.');
    }

    public function destroy(Bisnes $bisnes)
    {
        $this->authorize('delete', $bisnes);

        // Delete image if exists
        if ($bisnes->gambar && file_exists(public_path('images/bisnes/' . $bisnes->gambar))) {
            unlink(public_path('images/bisnes/' . $bisnes->gambar));
        }

        $bisnes->delete();

        return redirect()->route('bisnes.index')->with('success', 'Business deleted successfully.');
    }
}
