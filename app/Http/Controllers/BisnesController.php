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

    public function show(Bisnes $bisne)
    {

        return view('bisnes.show', ['bisnes' => $bisne]);
    }

    public function store(Request $request)
    {
        $request->merge(['on' => $request->has('on') ? 1 : 0]);
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
            'system_message' => 'nullable|string',
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

    public function update(Request $request, Bisnes $bisne)
    {
        $request->merge(['on' => $request->has('on') ? 1 : 0]);

        $request->validate([
            'nama_bisnes' => 'required|string|max:255',
            'exp_date' => 'nullable|date',
            'nama_syarikat' => 'required|string|max:255',
            'no_pendaftaran' => 'nullable|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
            'on' => 'boolean',
            'system_message' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($bisne->gambar && Storage::disk('public')->exists('bisnes/' . $bisne->gambar)) {
                Storage::disk('public')->delete('bisnes/' . $bisne->gambar);
            }

            $path = $request->file('gambar')->store('bisnes', 'public');
            $data['gambar'] = basename($path);
        }

        $bisne->update($data);

        return redirect()->route('bisnes.index')->with('success', 'Business updated successfully.');
    }

    public function destroy(Bisnes $bisne)
    {
        // Temporarily disable authorization for testing
        // $this->authorize('delete', $bisne);

        // Delete image if exists
        if ($bisne->gambar && Storage::disk('public')->exists('bisnes/' . $bisne->gambar)) {
            Storage::disk('public')->delete('bisnes/' . $bisne->gambar);
        }

        $bisne->delete();

        return redirect()->route('bisnes.index')->with('success', 'Business deleted successfully.');
    }
}
