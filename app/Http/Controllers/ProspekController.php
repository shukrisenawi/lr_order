<?php

namespace App\Http\Controllers;

use App\Models\Prospek;
use App\Models\Bisnes;
use Illuminate\Http\Request;

class ProspekController extends Controller
{
    public function index()
    {
        $prospek = Prospek::with('bisnes')->whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->paginate(10);

        return view('prospek.index', compact('prospek'));
    }

    public function show(Prospek $prospek)
    {
        $this->authorize('view', $prospek);
        return view('prospek.show', compact('prospek'));
    }

    public function create()
    {
        $bisnes = Bisnes::where('user_id', auth()->id())->get();
        return view('prospek.create', compact('bisnes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_tel' => 'required|string|max:20',
            'gelaran' => 'required|string|max:50',
            'bisnes_id' => 'required|exists:bisnes,id',
        ]);

        Prospek::create($request->all());

        return redirect()->route('prospek.index')->with('success', 'Prospek created successfully.');
    }

    public function edit(Prospek $prospek)
    {
        $this->authorize('update', $prospek);
        $bisnes = Bisnes::where('user_id', auth()->id())->get();
        return view('prospek.edit', compact('prospek', 'bisnes'));
    }

    public function update(Request $request, Prospek $prospek)
    {
        $this->authorize('update', $prospek);

        $request->validate([
            'no_tel' => 'required|string|max:20',
            'gelaran' => 'required|string|max:50',
            'bisnes_id' => 'required|exists:bisnes,id',
        ]);

        $prospek->update($request->all());

        return redirect()->route('prospek.index')->with('success', 'Prospek updated successfully.');
    }

    public function destroy(Prospek $prospek)
    {
        $this->authorize('delete', $prospek);
        $prospek->delete();

        return redirect()->route('prospek.index')->with('success', 'Prospek deleted successfully.');
    }
}
