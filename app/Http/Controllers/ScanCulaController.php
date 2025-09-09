<?php

namespace App\Http\Controllers;

use App\Models\ScanCula;
use Illuminate\Http\Request;

class ScanCulaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $scanCulas = ScanCula::query()
            ->when($search, function ($query, $search) {
                $query->where('no_kp', 'like', '%' . $search . '%')
                      ->orWhere('nama_pemilih', 'like', '%' . $search . '%')
                      ->orWhere('alamat', 'like', '%' . $search . '%')
                      ->orWhere('cula', 'like', '%' . $search . '%');
            })
            ->paginate(10)->withQueryString();

        return view('scan-cula.index', compact('scanCulas', 'search'));
    }

    public function create()
    {
        return view('scan-cula.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_kp' => 'required',
            'nama_pemilih' => 'required',
            'alamat' => 'required',
            'cula' => 'required',
        ]);

        ScanCula::create($request->all());

        return redirect()->route('scan-cula.index')
                        ->with('success','Data berhasil dibuat.');
    }

    public function show(ScanCula $scanCula)
    {
        return view('scan-cula.show',compact('scanCula'));
    }

    public function edit(ScanCula $scanCula)
    {
        return view('scan-cula.edit',compact('scanCula'));
    }

    public function update(Request $request, ScanCula $scanCula)
    {
        $request->validate([
            'no_kp' => 'required',
            'nama_pemilih' => 'required',
            'alamat' => 'required',
            'cula' => 'required',
        ]);

        $scanCula->update($request->all());

        return redirect()->route('scan-cula.index')
                        ->with('success','Data berhasil diperbarui.');
    }

    public function destroy(ScanCula $scanCula)
    {
        $scanCula->delete();

        return redirect()->route('scan-cula.index')
                        ->with('success','Data berhasil dihapus.');
    }
}