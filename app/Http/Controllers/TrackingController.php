<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use App\Models\Gambar;
use App\Events\NewDataEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;


class TrackingController extends Controller
{

    public function index()
    {
        if (empty(session('selected_bisnes_id'))) {
            return redirect()->route('bisnes.index');
        }

        $tracking = Tracking::where('bisnes_id', session('selected_bisnes_id'))->paginate(10);
        return view('tracking.index', compact('tracking'));
    }

    public function create()
    {
        if (empty(session('selected_bisnes_id'))) {
            return redirect()->route('bisnes.index');
        }

        $invoices = \App\Models\Invoice::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('tracking.create', compact('invoices'));
    }

    public function show(Tracking $tracking)
    {
        return view('tracking.show', compact('tracking'));
    }

    public function store(Request $request)
    {
        $request->merge(['bisnes_id' => session('selected_bisnes_id')]);
        $request->validate([
            'invoice_id' => 'nullable|exists:invoice,id',
            'bisnes_id' => 'required|exists:bisnes,id',
            'kurier' => 'nullable|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
            'kandungan_parcel' => 'nullable|string',
            'jenis_parcel' => 'nullable|string',
            'berat' => 'nullable|string',
            'panjang' => 'nullable|string',
            'lebar' => 'nullable|string',
            'tinggi' => 'nullable|string',
        ]);

        $tracking = Tracking::create($request->all());

        return redirect()->route('tracking.index')->with('success', 'Tracking created successfully.');
    }

    public function edit(Tracking $tracking)
    {
        if (empty(session('selected_bisnes_id'))) {
            return redirect()->route('bisnes.index');
        }

        $invoices = \App\Models\Invoice::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('tracking.edit', compact('tracking', 'invoices'));
    }

    public function update(Request $request, Tracking $tracking)
    {
        $request->validate([
            'invoice_id' => 'nullable|exists:invoice,id',
            'kurier' => 'nullable|string|max:255',
            'nama_penerima' => 'required|string|max:255',
            'alamat' => 'required|string',
            'poskod' => 'required|string|max:10',
            'no_tel' => 'required|string|max:20',
            'kandungan_parcel' => 'nullable|string',
            'jenis_parcel' => 'nullable|string',
            'berat' => 'nullable|string',
            'panjang' => 'nullable|string',
            'lebar' => 'nullable|string',
            'tinggi' => 'nullable|string',
        ]);

        $tracking->update($request->all());

        return redirect()->route('tracking.index')->with('success', 'Tracking updated successfully.');
    }

    public function destroy(Tracking $tracking)
    {
        $tracking->delete();
        return redirect()->route('tracking.index')->with('success', 'Tracking deleted successfully.');
    }

    public function createShipment(Request $request, Tracking $tracking)
    {
        // Use JTExpressController to create shipment
        $jtController = new \App\Http\Controllers\JTExpressController();

        // Prepare data from tracking record
        $shipmentData = [
            'customerCode' => 'TEST001', // Should be configurable
            'txlogisticId' => 'TX' . $tracking->id . time(),
            'expressType' => 'EZ', // Standard express
            'sender' => [
                'name' => 'Your Business Name', // Should be from business settings
                'postCode' => '50000', // Should be from business address
                'phone' => '0123456789', // Should be from business contact
                'address' => 'Business Address', // Should be from business address
                'countryCode' => 'MY',
                'prov' => 'Kuala Lumpur',
                'city' => 'Kuala Lumpur',
                'area' => 'KL001'
            ],
            'receiver' => [
                'name' => $tracking->nama_penerima,
                'postCode' => $tracking->poskod,
                'phone' => $tracking->no_tel,
                'address' => $tracking->alamat,
                'countryCode' => 'MY',
                'prov' => 'Kuala Lumpur', // Could be derived from postcode
                'city' => 'Kuala Lumpur', // Could be derived from postcode
                'area' => 'KL001' // Could be derived from postcode
            ],
            'weight' => $tracking->berat ?? 1,
            'items' => [
                [
                    'itemName' => $tracking->kandungan_parcel ?? 'Package',
                    'number' => 1,
                    'itemValue' => 100, // Should be calculated from invoice
                    'weight' => $tracking->berat ?? 1
                ]
            ]
        ];

        // Call JT Express API
        $response = $jtController->sendOrder(new Request($shipmentData));

        if ($response->getData()->success ?? false) {
            // Update tracking with shipment details
            $tracking->update([
                'kurier' => 'J&T',
                // Could add tracking number field to model
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Shipment created successfully',
                'data' => $response->getData()
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to create shipment',
            'error' => $response->getData()->message ?? 'Unknown error'
        ], 400);
    }

    public function trackShipment(Request $request, Tracking $tracking)
    {
        $jtController = new \App\Http\Controllers\JTExpressController();

        // This would need the actual tracking number from J&T
        // For now, return placeholder
        return response()->json([
            'success' => false,
            'message' => 'Tracking functionality requires shipment tracking number'
        ]);
    }
}
