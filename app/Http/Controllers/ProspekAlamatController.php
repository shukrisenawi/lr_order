<?php

namespace App\Http\Controllers;

use App\Models\ProspekAlamat;
use App\Models\Prospek;
use Illuminate\Http\Request;

class ProspekAlamatController extends Controller
{
    public function index()
    {
        $prospekAlamat = ProspekAlamat::with('prospek')->whereHas('prospek', function ($query) {
            $query->whereHas('bisnes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->paginate(10);

        return view('prospek-alamat.index', compact('prospekAlamat'));
    }

    public function create()
    {
        $prospek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('prospek-alamat.create', compact('prospek'));
    }

    public function show(ProspekAlamat $prospekAlamat)
    {
        return view('prospek-alamat.show', compact('prospekAlamat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prospek_id' => 'required|exists:prospek,id',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
            'active' => 'boolean',
        ]);

        ProspekAlamat::create($request->all());

        return redirect()->route('prospek-alamat.index')->with('success', 'Alamat created successfully.');
    }

    public function edit(ProspekAlamat $prospekAlamat)
    {
        $this->authorize('update', $prospekAlamat);
        $prospek = Prospek::whereHas('bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        return view('prospek-alamat.edit', compact('prospekAlamat', 'prospek'));
    }

    public function update(Request $request, ProspekAlamat $prospekAlamat)
    {
        $this->authorize('update', $prospekAlamat);

        $request->validate([
            'prospek_id' => 'required|exists:prospek,id',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
            'active' => 'boolean',
        ]);

        $prospekAlamat->update($request->all());

        return redirect()->route('prospek-alamat.index')->with('success', 'Alamat updated successfully.');
    }

    public function destroy(ProspekAlamat $prospekAlamat)
    {
        $this->authorize('delete', $prospekAlamat);
        $prospekAlamat->delete();

        return redirect()->route('prospek-alamat.index')->with('success', 'Alamat deleted successfully.');
    }
}
