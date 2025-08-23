<?php

namespace App\Http\Controllers;

use App\Models\ProspekBuy;
use App\Models\ProspekAlamat;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProspekBuyController extends Controller
{
    public function index()
    {
        $prospekBuy = ProspekBuy::with(['prospekAlamat.prospek.bisnes', 'produk'])
            ->whereHas('prospekAlamat.prospek.bisnes', function ($query) {
                $query->where('user_id', auth()->id());
            })->paginate(10);

        return view('prospek-buy.index', compact('prospekBuy'));
    }

    public function create()
    {
        $prospekAlamat = ProspekAlamat::with('prospek')->whereHas('prospek.bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $produk = Produk::all();

        return view('prospek-buy.create', compact('prospekAlamat', 'produk'));
    }

    public function show(ProspekBuy $prospekBuy)
    {
        return view('prospek-buy.show', compact('prospekBuy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prospek_alamat_id' => 'required|exists:prospek_alamat,id',
            'produk_id' => 'required|exists:produk,id',
            'kuantiti' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        ProspekBuy::create($request->all());

        return redirect()->route('prospek-buy.index')->with('success', 'Order created successfully.');
    }

    public function edit(ProspekBuy $prospekBuy)
    {
        $this->authorize('update', $prospekBuy);

        $alamat = ProspekAlamat::whereHas('prospek', function ($query) {
            $query->whereHas('bisnes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->get();

        $produk = Produk::all();

        return view('prospek-buy.edit', compact('prospekBuy', 'alamat', 'produk'));
    }

    public function update(Request $request, ProspekBuy $prospekBuy)
    {
        $this->authorize('update', $prospekBuy);

        $request->validate([
            'prospek_alamat_id' => 'required|exists:prospek_alamat,id',
            'produk_id' => 'required|exists:produk,id',
            'kuantiti' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        $prospekBuy->update($request->all());

        return redirect()->route('prospek-buy.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(ProspekBuy $prospekBuy)
    {
        $this->authorize('delete', $prospekBuy);
        $prospekBuy->delete();

        return redirect()->route('prospek-buy.index')->with('success', 'Order deleted successfully.');
    }
}
