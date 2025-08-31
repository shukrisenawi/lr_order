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
        $data = [
            "customerCode" => "JTMY017482",
            "actionType" => "add",
            "password" => "EF215AD17C6ECC95635603976017D96F",
            "txlogisticId" => "NM20240619001",
            "expressType" => "EZ",
            "serviceType" => "1",
            "sender" => [
                "name" => "MOHAMAD SHUKRI BIN SENAWI",
                "postCode" => "08200",
                "phone" => "60195168839",
                "address" => "NO 17222, KAMPUNG KUALA TELOI, 08200 SIK, KEDAH",
                "countryCode" => "MYS",
                "prov" => "KEDAH",
                "city" => "SIK",
                "area" => "KAMPUNG KUALA TELOI"
            ],
            "receiver" => [
                "name" => "BUQORI BIN SENAWI",
                "postCode" => "08200",
                "phone" => "60166831403",
                "address" => "167 KG BATU 5, 08200 SIK, KEDAH",
                "countryCode" => "MYS",
                "prov" => "KEDAH",
                "city" => "SIK",
                "area" => "KAMPUNG BATU 5"
            ],
            "payType" => "PP_PM",
            "goodsType" => "PARCEL",
            "weight" => 10,
            "items" => [
                [
                    "itemName" => "basketball",
                    "englishName" => "basketball",
                    "itemDesc" => "This is a basketball",
                    "number" => 2,
                    "itemValue" => "50",
                    "weight" => "10",
                    "itemCurrency" => "USD"
                ],
                [
                    "itemName" => "phone",
                    "englishName" => "phone",
                    "itemDesc" => "This is a phone",
                    "number" => 1,
                    "itemValue" => "4000",
                    "weight" => "100",
                    "itemCurrency" => "USD"
                ]
            ],
            "packageInfo" => [
                "packageQuantity" => 10,
                "goodsType" => "ITN2",
                "weight" => 10,
                "length" => 10,
                "width" => 10,
                "packageValue" => "880"
            ],
            "sendStartTime" => "2024-06-19 13:45:00",
            "sendEndTime" => "2024-06-25 16:23:00",
            "remark" => "",
            "returnInfo" => [
                "name" => "J&T return",
                "postCode" => "31000",
                "phone" => "60987654",
                "address" => "4678, Laluan Sentang 35"
            ],
            "offerFeeInfo" => [
                "offerValue" => "12"
            ],
            "customsInfo" => [
                "customsCode" => "2000001",
                "nationalInspectionNo" => "456DEF",
                "originPlace" => "China",
                "brandName" => "Brand X",
                "oldItem" => 0,
                "number" => "10",
                "weight" => "25.5",
                "unitWeight" => "2.5",
                "totalValue" => "100",
                "unitPrice" => "10",
                "currency" => "USD"
            ],
            "codInfo" => [
                "codValue" => 100
            ],
            "multipleVotes" => [
                [
                    "actualWeight" => "21",
                    "length" => "12",
                    "width" => "12",
                    "height" => "12"
                ],
                [
                    "actualWeight" => "21",
                    "length" => "12",
                    "width" => "12",
                    "height" => "12"
                ]
            ]
        ];

        $bizContent = json_encode($data);
        $digest = base64_encode(md5($bizContent . env('API_JNT_PRIVATE_KEY'), true));
        $headers = [
            "apiAccount" => env('API_JNT_KEY'),
            "digest"     => $digest,
            "timestamp" => time(),
            "Content-Type" => "application/x-www-form-urlencoded; charset=UTF-8",
        ];


        $response = Http::withoutVerifying()->withHeaders($headers)->asForm()->post(env('API_JNT_URL'), ['bizContent' => $bizContent]);

        dd($response->body());
        // $request->merge(['bisnes_id' => session('selected_bisnes_id')]);
        // $request->validate([
        //     'invoice_id' => 'nullable|exists:invoice,id',
        //     'bisnes_id' => 'required|exists:bisnes,id',
        //     'kurier' => 'nullable|string|max:255',
        //     'nama_penerima' => 'required|string|max:255',
        //     'alamat' => 'required|string',
        //     'poskod' => 'required|string|max:10',
        //     'no_tel' => 'required|string|max:20',
        //     'kandungan_parcel' => 'nullable|string',
        //     'jenis_parcel' => 'nullable|string',
        //     'berat' => 'nullable|string',
        //     'panjang' => 'nullable|string',
        //     'lebar' => 'nullable|string',
        //     'tinggi' => 'nullable|string',
        // ]);

        // $tracking = Tracking::create($request->all());

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
