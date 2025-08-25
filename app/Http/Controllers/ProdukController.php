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
        try {
            Log::info('Produk store method called', ['request_data' => $request->all()]);

            $request->validate([
                'nama' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'stok' => 'required|integer|min:0',
                'gambar_id' => 'nullable|exists:gambar,id',
            ]);

            Log::info('Validation passed');

            $produk = Produk::create($request->all());

            Log::info('Produk created', ['produk_id' => $produk->id]);

            // Broadcast new data event
            broadcast(new NewDataEvent('produk', [
                'id' => $produk->id,
                'message' => 'Produk baru telah ditambah',
                'nama' => $produk->nama,
                'harga' => $produk->harga,
                'stok' => $produk->stok
            ], auth()->id()));

            return redirect()->route('produk.index')->with('success', 'Produk created successfully.');
        } catch (\Exception $e) {
            Log::error('Error in produk store', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return back()->withErrors(['error' => 'Error creating product: ' . $e->getMessage()])->withInput();
        }
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
