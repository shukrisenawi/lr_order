<?php

namespace App\Http\Controllers;

use App\Models\CustomerBuy;
use App\Models\CustomerAlamat;
use App\Models\Produk;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerBuyController extends Controller
{

    public function __construct()
    {
        $this->middleware(function () {
            if (empty(session('selected_bisnes_id')))
                return redirect()->route('bisnes.index');
        });
        parent::__construct();
    }
    public function index()
    {
        $customerBuys = CustomerBuy::with(['customerAlamat.customer', 'produk'])
            ->whereHas('customerAlamat.customer.bisnes', function ($query) {
                $query->where('user_id', auth()->id());
            })->paginate(10);

        $totalAmount = CustomerBuy::with(['customerAlamat.customer'])
            ->whereHas('customerAlamat.customer.bisnes', function ($query) {
                $query->where('user_id', auth()->id());
            })->sum(DB::raw('kuantiti * harga'));

        return view('customer-buy.index', compact('customerBuys', 'totalAmount'));
    }

    public function create()
    {
        $customerAlamat = CustomerAlamat::with('customer')->whereHas('customer.bisnes', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        $produk = Produk::all();

        return view('customer-buy.create', compact('customerAlamat', 'produk'));
    }

    public function show(CustomerBuy $customerBuy)
    {
        return view('customer-buy.show', compact('customerBuy'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_alamat_id' => 'required|exists:customer_alamat,id',
            'produk_id' => 'required|exists:produk,id',
            'kuantiti' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'notes' => 'nullable|string|max:500',
        ]);

        $total = $request->kuantiti * $request->harga;

        $customerBuy = CustomerBuy::create([
            'customer_alamat_id' => $request->customer_alamat_id,
            'produk_id' => $request->produk_id,
            'kuantiti' => $request->kuantiti,
            'harga' => $request->harga,
            'status' => 'pending',
            'created_at' => $request->purchase_date,
        ]);

        // Get business ID for broadcasting
        $customerAlamat = CustomerAlamat::with('customer.bisnes')->find($request->customer_alamat_id);
        $bisnesId = $customerAlamat->customer->bisnes->id ?? null;

        // Broadcast new data event
        broadcast(new NewDataEvent('customer-buy', [
            'id' => $customerBuy->id,
            'message' => 'Pembelian baru telah direkodkan',
            'total' => $total,
            'produk' => $customerBuy->produk->nama ?? 'Unknown'
        ], auth()->id(), $bisnesId));

        return redirect()->route('customer-buy.index')->with('success', 'Pembelian berjaya direkodkan.');
    }

    public function edit(CustomerBuy $customerBuy)
    {
        $this->authorize('update', $customerBuy);

        $customerAlamat = CustomerAlamat::whereHas('customer', function ($query) {
            $query->whereHas('bisnes', function ($q) {
                $q->where('user_id', auth()->id());
            });
        })->get();

        $produk = Produk::all();

        return view('customer-buy.edit', compact('customerBuy', 'customerAlamat', 'produk'));
    }

    public function update(Request $request, CustomerBuy $customerBuy)
    {
        $this->authorize('update', $customerBuy);

        $request->validate([
            'customer_alamat_id' => 'required|exists:customer_alamat,id',
            'produk_id' => 'required|exists:produk,id',
            'kuantiti' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        $customerBuy->update($request->all());

        return redirect()->route('customer-buy.index')->with('success', 'Order updated successfully.');
    }

    public function destroy(CustomerBuy $customerBuy)
    {
        $this->authorize('delete', $customerBuy);
        $customerBuy->delete();

        return redirect()->route('customer-buy.index')->with('success', 'Order deleted successfully.');
    }
}
