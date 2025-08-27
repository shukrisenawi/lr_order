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

        // timestamp (ms)
        $timestamp = round(microtime(true) * 1000);

        // BizContent JSON (example order)
        $bizContent = [
            "customerCode" => "ITTEST0001",
            "actionType"   => "add",
            "password"     => "AA7EDDC3B82704CA3717E88E67A3CAF1",
            "txlogisticId" => "ORDER" . time(),
            "expressType"  => "EZ",
            "serviceType"  => "1",
            "payType"      => "PP_PM",
            "sender" => [
                "name"        => "Ali",
                "postCode"    => "56000",
                "phone"       => "60123456789",
                "address"     => "Jalan Ampang",
                "countryCode" => "MYS"
            ],
            "receiver" => [
                "name"        => "Abu",
                "postCode"    => "43000",
                "phone"       => "60198765432",
                "address"     => "Bandar Baru Bangi",
                "countryCode" => "MYS"
            ],
            "items" => [
                [
                    "itemName"     => "Sticker",
                    "number"       => "2",
                    "weight"       => "0.5",
                    "itemValue"    => "10",
                    "itemCurrency" => "MYR"
                ]
            ],
            "packageInfo" => [
                "packageQuantity" => "1",
                "weight"          => "0.5",
                "packageValue"    => "10",
                "goodsType"       => "ITN8"
            ]
        ];

        $bizContentJson = json_encode($bizContent, JSON_UNESCAPED_UNICODE);

        // Digest = base64(md5(bizContent + privateKey))
        $md5Bytes = md5($bizContentJson . $privateKey, true); // true → raw bytes
        $digest   = base64_encode($md5Bytes);

        // Hantar ke J&T
        $response = Http::asForm()->post($url, [
            'apiAccount' => $apiAccount,
            'digest'     => $digest,
            'timestamp'  => $timestamp,
            'bizContent' => $bizContentJson,
        ]);

        $data = response()->json([
            'request' => [
                'apiAccount' => $apiAccount,
                'digest'     => $digest,
                'timestamp'  => $timestamp,
                'bizContent' => $bizContent
            ],
            'response' => $response->json()
        ]);
        dd($data);
    }
}
