<?php

namespace App\Http\Controllers;

use App\Models\ProspekBuy;
use App\Models\ProspekAlamat;
use App\Models\Produk;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProspekBuyController extends Controller
{
    public function index()
    {
        $prospekBuys = ProspekBuy::with(['prospekAlamat.prospek', 'produk'])
            ->whereHas('prospekAlamat.prospek.bisnes', function ($query) {
                $query->where('user_id', auth()->id());
            })->paginate(10);

        $totalAmount = ProspekBuy::with(['prospekAlamat.prospek'])
            ->whereHas('prospekAlamat.prospek.bisnes', function ($query) {
                $query->where('user_id', auth()->id());
            })->sum(DB::raw('kuantiti * harga'));

        return view('prospek-buy.index', compact('prospekBuys', 'totalAmount'));
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
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $total = $request->kuantiti * $request->harga;

        $prospekBuy = ProspekBuy::create([
            'prospek_alamat_id' => $request->prospek_alamat_id,
            'produk_id' => $request->produk_id,
            'kuantiti' => $request->kuantiti,
            'harga' => $request->harga,
            'status' => 'pending',
            'created_at' => $request->purchase_date,
        ]);

        // Get business ID for broadcasting
        $prospekAlamat = ProspekAlamat::with('prospek.bisnes')->find($request->prospek_alamat_id);
        $bisnesId = $prospekAlamat->prospek->bisnes->id ?? null;

        // Broadcast new data event
        broadcast(new NewDataEvent('prospek-buy', [
            'id' => $prospekBuy->id,
            'message' => 'Pembelian baru telah direkodkan',
            'total' => $total,
            'produk' => $prospekBuy->produk->nama ?? 'Unknown'
        ], auth()->id(), $bisnesId));

        return redirect()->route('prospek-buy.index')->with('success', 'Pembelian berjaya direkodkan.');
    }

    public function edit(ProspekBuy $prospekBuy)
    {
        $this->authorize('update', $prospekBuy);

        $prospekAlamat = ProspekAlamat::whereHas('prospek', function ($query) {
            $query->whereHas('bisnes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->get();

        $produk = Produk::all();

        return view('prospek-buy.edit', compact('prospekBuy', 'prospekAlamat', 'produk'));
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
