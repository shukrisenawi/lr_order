<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Gambar;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class ProdukController extends Controller
{

    public function index()
    {

        $produk = Produk::where('bisnes_id', session('selected_bisnes_id'))->with('gambar')->paginate(10);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('produk.create', compact('gambar'));
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
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

        $produk = Produk::create($request->all());


        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    public function edit(Produk $produk)
    {
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('produk.edit', compact('produk', 'gambar'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_id' => 'nullable|exists:gambar,id',
            'info' => 'required|string',
        ]);

        $produk->update($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk updated successfully.');
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk deleted successfully.');
    }
}
