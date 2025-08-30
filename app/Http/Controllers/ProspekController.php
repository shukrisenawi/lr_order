<?php

namespace App\Http\Controllers;

use App\Models\Prospek;
use App\Models\Bisnes;
use App\Helpers\BisnesHelper;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;

class ProspekController extends Controller
{

    public function index()
    {
        $prospek = Prospek::with('bisnes')
            ->where('bisnes_id', session('selected_bisnes_id'))
            ->paginate(10);

        return view('prospek.index', compact('prospek'));
    }

    public function show(Prospek $prospek)
    {
        return view('prospek.show', compact('prospek'));
    }

    public function create()
    {
        return view('prospek.create');
    }

    public function store(Request $request)
    {
        $request->merge(['bisnes_id' => session('selected_bisnes_id'), 'on' => $request->has('on') ? 1 : 0, 'status' => 'prospek']);
        $request->validate([
            'no_tel' => 'required|string|max:20',
            'session_id' => 'nullable|string|max:255',
            'gelaran' => 'nullable|string|max:50',
            'bisnes_id' => 'required|exists:bisnes,id',
            'on' => 'nullable|boolean',
        ]);

        $prospek = Prospek::create($request->all());

        // Broadcast new data event
        // broadcast(new NewDataEvent('prospek', [
        //     'id' => $prospek->id,
        //     'message' => 'Prospek baru telah didaftarkan',
        //     'gelaran' => $prospek->gelaran,
        //     'no_tel' => $prospek->no_tel
        // ], auth()->id(), $request->bisnes_id));

        return redirect()->route('prospek.index')->with('success', 'Prospek created successfully.');
    }

    public function edit(Prospek $prospek)
    {
        return view('prospek.edit', compact('prospek'));
    }

    public function update(Request $request, Prospek $prospek)
    {
        $request->merge(['bisnes_id' => session('selected_bisnes_id'), 'on' => $request->has('on') ? 1 : 0]);

        $request->validate([
            'no_tel' => 'required|string|max:20',
            'session_id' => 'nullable|string|max:255',
            'gelaran' => 'nullable|string|max:50',
            'bisnes_id' => 'required|exists:bisnes,id',
            'on' => 'nullable|boolean',
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
