<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WaybillController extends Controller
{
    public function index()
    {
        $apiAccount = "640826271705595946";
        $privateKey = "8e88c8477d4e4939859c560192fcafbc";
        $url = "https://demoopenapi.jtexpress.my/webopenplatformapi/api/order/addOrder";

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
            'data_sign' => base64_encode(md5($data_json . $privateKey))
        );

        // Hantar ke J&T
        $response = Http::asForm()->post($url, $data_request);

        // $data = response()->json([
        //     'request' => [
        //         'apiAccount' => $apiAccount,
        //         'digest'     => $digest,
        //         'timestamp'  => $timestamp,
        //         'bizContent' => $bizContent
        //     ],
        //     'response' => $response->json()
        // ]);
        dd($response);
    }
}
