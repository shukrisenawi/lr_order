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

        $tracking = Tracking::where('bisnes_id', session('selected_bisnes_id'))->with('gambar')->paginate(10);
        return view('tracking.index', compact('tracking'));
    }

    public function create()
    {
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('tracking.create', compact('gambar'));
    }

    public function show(Tracking $tracking)
    {
        return view('tracking.show', compact('tracking'));
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

        $tracking = Tracking::create($request->all());


        return redirect()->route('tracking.index')->with('success', 'Tracking created successfully.');
    }

    public function edit(Tracking $tracking)
    {
        $gambar = Gambar::where('bisnes_id', session('selected_bisnes_id'))->get();
        return view('tracking.edit', compact('tracking', 'gambar'));
    }

    public function update(Request $request, Tracking $tracking)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'gambar_id' => 'nullable|exists:gambar,id',
            'info' => 'required|string',
        ]);

        $tracking->update($request->all());

        return redirect()->route('tracking.index')->with('success', 'Tracking updated successfully.');
    }

    public function destroy(Tracking $tracking)
    {
        $tracking->delete();
        return redirect()->route('tracking.index')->with('success', 'Tracking deleted successfully.');
    }

    public function createTracking()
    {
        $key = env("API_JNT_KEY"); //API_JNT_PRIVATE_KEY
        $data = array(
            'username' => 'username',
            'api_key' => 'api_key',
            'orderid' => 'ORDERID-0001',
            'shipper_name' => 'PENGIRIM',
            'shipper_contact' => 'PENGIRIM',
            'shipper_phone' => '+628123456789',
            'shipper_addr' => 'JL. Pengirim no.88, RT/RW:001/010, Pluit',
            'origin_code' => 'JKT',
            'receiver_name' => 'PENERIMA',
            'receiver_phone' => '+62812348888',
            'receiver_addr' => 'JL. Penerima no.1, RT/RW:04/07, Sidoarjo',
            'receiver_zip' => '40123',
            'destination_code' => 'JKT',
            'receiver_area' => 'JKT001',
            'qty' => '1',
            'weight' => '1',
            'goodsdesc' => 'TESTING!!',
            'servicetype' => '1',
            'insurance' => '122',
            'orderdate' => '2021-08-01 22:02:00',
            'item_name' => 'topi',
            'cod' => '120000',
            'sendstarttime' => '2021-08-01 08:00:00',
            'sendendtime' => '2021-08-01 22:00:00',
            'expresstype' => '1',
            'goodsvalue' => '1000',
        );
        $data_json = json_encode(array('detail' => array($data)));
        $data_request = array(
            'data_param' => $data_json,
            'data_sign' => base64_encode(md5($data_json . $key))
        );

        $response = Http::asForm()->post(env("API_JNT_URL"),  $data_request);
        return $response;
    }
}
