<?php

namespace App\Http\Controllers;

use App\Models\Iklan;
use App\Models\Gambar;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class IklanController extends Controller
{

    public function index()
    {
        $iklan = Iklan::where('bisnes_id', session('selected_bisnes_id'))->sortBy('hari', 'ASC')->paginate(10);
        return view('iklan.index', compact('iklan'));
    }

    public function create()
    {
        $latestDay = Iklan::where('bisnes_id', session('selected_bisnes_id'))->max('hari');
        return view('iklan.create', compact('latestDay'));
    }

    public function show(Iklan $iklan)
    {
        return view('iklan.show', compact('iklan'));
    }

    public function store(Request $request)
    {

        $request->merge(['bisnes_id' => session('selected_bisnes_id'), 'on' => $request->has('on') ? 1 : 0]);

        $request->validate([
            'nama_iklan' => 'required|string|max:255',
            'bisnes_id' => 'required|exists:bisnes,id',
            'keterangan' => 'required|string',
            'hari' => 'required|integer|min:0',
            'on' => 'nullable|boolean',
        ]);

        $iklan = Iklan::create($request->all());

        return redirect()->route('iklan.index')->with('success', 'Iklan created successfully.');
    }

    public function edit(Iklan $iklan)
    {
        return view('iklan.edit', compact('iklan'));
    }

    public function update(Request $request, Iklan $iklan)
    {
        $request->merge(['bisnes_id' => session('selected_bisnes_id'), 'on' => $request->has('on') ? 1 : 0]);
        $request->validate([
            'nama_iklan' => 'required|string|max:255',
            'bisnes_id' => 'required|exists:bisnes,id',
            'keterangan' => 'required|string',
            'hari' => 'required|integer|min:0',
            'on' => 'nullable|boolean',
        ]);

        $iklan->update($request->all());

        return redirect()->route('iklan.index')->with('success', 'Iklan updated successfully.');
    }

    public function destroy(Iklan $iklan)
    {
        $iklan->delete();
        return redirect()->route('iklan.index')->with('success', 'Iklan deleted successfully.');
    }
}
