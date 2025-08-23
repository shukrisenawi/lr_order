<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Gambar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::with('gambar')->paginate(10);
        return view('produk.index', compact('produk'));
    }

    public function create()
    {
        $gambar = Gambar::all();
        return view('produk.create', compact('gambar'));
    }

    public function show(Produk $produk)
    {
        return view('produk.show', compact('produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_id' => 'nullable|exists:gambar,id',
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
    }

    public function edit(Produk $produk)
    {
        $gambar = Gambar::all();
        return view('produk.edit', compact('produk', 'gambar'));
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_id' => 'nullable|exists:gambar,id',
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
