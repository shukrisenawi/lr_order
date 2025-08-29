<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use App\Models\Gambar;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class TrackingController extends Controller
{

    public function index()
    {

        $tracking = Tracking::where('bisnes_id', session('selected_bisnes_id'))->with('gambar')->paginate(10);
        return view('tracking.index', compact('tracking'));
    }

    public function create()
    {
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('tracking.create', compact('gambar'));
    }

    public function show(Tracking $tracking)
    {
        return view('tracking.show', compact('tracking'));
    }

    public function store(Request $request)
    {
        $request->merge(['bisnes_id' => session('selected_bisnes_id')]);
        // dd(session('selected_bisnes_id'));
        $request->validate([
            'nama' => 'required|string|max:255',
            'bisnes_id' => 'required|exists:bisnes,id',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_id' => 'nullable|exists:gambar,id',
            'info' => 'required|string',
        ]);

        $tracking = Tracking::create($request->all());


        return redirect()->route('tracking.index')->with('success', 'Tracking created successfully.');
    }

    public function edit(Tracking $tracking)
    {
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('tracking.edit', compact('tracking', 'gambar'));
    }

    public function update(Request $request, Tracking $tracking)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_id' => 'nullable|exists:gambar,id',
            'info' => 'required|string',
        ]);

        $tracking->update($request->all());

        return redirect()->route('tracking.index')->with('success', 'Tracking updated successfully.');
    }

    public function destroy(Tracking $tracking)
    {
        $tracking->delete();
        return redirect()->route('tracking.index')->with('success', 'Tracking deleted successfully.');
    }
}
