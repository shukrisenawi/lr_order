<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Produk;
use App\Models\Bisnes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with(['bisnes', 'items'])
            ->whereHas('bisnes', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('invoice.index', compact('invoices'));
    }

    public function create()
    {
        $bisnes = Bisnes::where('user_id', Auth::id())->get();
        $produk = Produk::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        return view('invoice.create', compact('bisnes', 'produk'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bisnes_id' => 'required|exists:bisnes,id',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_tel' => 'required|string|max:20',
            'kurier' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'nullable|exists:produk,id',
            'items.*.produk_custom' => 'nullable|string|max:255',
            'items.*.kuantiti' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        // Verify bisnes belongs to authenticated user
        $bisnes = Bisnes::where('id', $request->bisnes_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $invoice = Invoice::create([
            'bisnes_id' => $request->bisnes_id,
            'nama_penerima' => $request->nama_penerima,
            'alamat' => $request->alamat,
            'no_tel' => $request->no_tel,
            'kurier' => $request->kurier,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'jumlah' => 0, // Will be calculated after items are added
        ]);

        // Add invoice items
        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'produk_id' => $item['produk_id'] ?? null,
                'produk_custom' => $item['produk_custom'] ?? null,
                'kuantiti' => $item['kuantiti'],
                'harga' => $item['harga'],
            ]);
        }

        // Update total
        $invoice->updateTotal();

        return redirect()->route('invoice.show', $invoice)
            ->with('success', 'Invoice created successfully!');
    }

    public function show(Invoice $invoice)
    {
        // Verify invoice belongs to authenticated user
        $invoice->load(['bisnes', 'items.produk']);

        if ($invoice->bisnes->user_id !== Auth::id()) {
            abort(403);
        }

        return view('invoice.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        // Verify invoice belongs to authenticated user
        if ($invoice->bisnes->user_id !== Auth::id()) {
            abort(403);
        }

        $bisnes = Bisnes::where('user_id', Auth::id())->get();
        $produk = Produk::whereHas('bisnes', function ($query) {
            $query->where('user_id', Auth::id());
        })->get();

        $invoice->load(['items']);

        return view('invoice.edit', compact('invoice', 'bisnes', 'produk'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        // Verify invoice belongs to authenticated user
        if ($invoice->bisnes->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'bisnes_id' => 'required|exists:bisnes,id',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_tel' => 'required|string|max:20',
            'kurier' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'status' => 'required|in:pending,paid,cancelled',
            'items' => 'required|array|min:1',
            'items.*.produk_id' => 'nullable|exists:produk,id',
            'items.*.produk_custom' => 'nullable|string|max:255',
            'items.*.kuantiti' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric|min:0',
        ]);

        // Verify bisnes belongs to authenticated user
        $bisnes = Bisnes::where('id', $request->bisnes_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $invoice->update([
            'bisnes_id' => $request->bisnes_id,
            'nama_penerima' => $request->nama_penerima,
            'alamat' => $request->alamat,
            'no_tel' => $request->no_tel,
            'kurier' => $request->kurier,
            'catatan' => $request->catatan,
            'status' => $request->status,
        ]);

        // Delete existing items and add new ones
        $invoice->items()->delete();

        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'produk_id' => $item['produk_id'] ?? null,
                'produk_custom' => $item['produk_custom'] ?? null,
                'kuantiti' => $item['kuantiti'],
                'harga' => $item['harga'],
            ]);
        }

        // Update total
        $invoice->updateTotal();

        return redirect()->route('invoice.show', $invoice)
            ->with('success', 'Invoice updated successfully!');
    }

    public function destroy(Invoice $invoice)
    {
        // Verify invoice belongs to authenticated user
        if ($invoice->bisnes->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->delete();

        return redirect()->route('invoice.index')
            ->with('success', 'Invoice deleted successfully!');
    }

    public function generatePdf(Invoice $invoice)
    {
        // Verify invoice belongs to authenticated user
        if ($invoice->bisnes->user_id !== Auth::id()) {
            abort(403);
        }

        $invoice->load(['bisnes', 'items.produk']);

        $pdf = Pdf::loadView('invoice.pdf', compact('invoice'));

        return $pdf->download('invoice-' . $invoice->invoice_no . '.pdf');
    }
}
