<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WaybillController extends Controller
{
    public function index()
    {
        $apiAccount = "640826271705595946"; // testing
        $privateKey = "8e88c8477d4e4939859c560192fcafbc";
        $url = "https://demoopenapi.jtexpress.my/webopenplatformapi/api/order/addOrder";

        // timestamp
        $timestamp = round(microtime(true) * 1000);

        // bizContent (boleh isi ikut request / hardcode untuk test)
        $bizContent = [
            "customerCode" => "J0086474299",
            "actionType"   => "add",
            "password"     => "9C75439FB1FD01EB01861670DD1B949C",
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

        // generate digest ikut formula (ikut doc / signature tool)
        $strToSign = $apiAccount . $bizContentJson . $timestamp . $privateKey;
        // $digest = strtoupper(md5($strToSign));
        $bizContentJson = json_encode($bizContent, JSON_UNESCAPED_UNICODE);

        // SHA256 HMAC + base64
        $digest = base64_encode(
            hash_hmac('sha256', $bizContentJson . $timestamp, $privateKey, true)
        );
        // hantar request ke J&T
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
                'bizContent' => $bizContent,
            ],
            'response' => $response->json()
        ]);
        echo "trestj";
        exit;
        dd($response);
    }
}
