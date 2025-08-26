<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class JTExpressController extends Controller
{
    private $apiUrl;
    private $apiAccount;
    private $privateKey;

    public function __construct()
    {
        // Use testing environment by default
        $this->apiUrl = 'https://demoopenapi.jtexpress.my/webopenplatformapi/api/order/addOrder';
        $this->apiAccount = '640826271705595946';
        $this->privateKey = '8e88c8477d4e4939859c560192fcafbc';
    }

    /**
     * Show J&T Express API settings page
     */
    public function index()
    {
        return view('settings.jt-express');
    }

    /**
     * Send order to J&T Express API
     */
    public function sendOrder(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'customerCode' => 'required|string',
            'txlogisticId' => 'required|string',
            'expressType' => 'required|string',
            'sender.name' => 'required|string',
            'sender.postCode' => 'required|string',
            'sender.phone' => 'required|string',
            'sender.address' => 'required|string',
            'sender.countryCode' => 'required|string',
            'sender.prov' => 'required|string',
            'sender.city' => 'required|string',
            'sender.area' => 'required|string',
            'receiver.name' => 'required|string',
            'receiver.postCode' => 'required|string',
            'receiver.phone' => 'required|string',
            'receiver.address' => 'required|string',
            'receiver.countryCode' => 'required|string',
            'receiver.prov' => 'required|string',
            'receiver.city' => 'required|string',
            'receiver.area' => 'required|string',
            'weight' => 'required|numeric',
            'items.*.itemName' => 'required|string',
            'items.*.number' => 'required|integer',
            'items.*.itemValue' => 'required|numeric',
            'items.*.weight' => 'required|numeric',
        ]);

        try {
            // Prepare the request data
            $requestData = $validatedData;
            $requestData['actionType'] = 'add';
            $requestData['serviceType'] = '1';
            $requestData['payType'] = 'PP_PM';
            $requestData['goodsType'] = 'PARCEL';

            // Add password (MD5 hash of apiAccount + privateKey)
            $requestData['password'] = md5($this->apiAccount . $this->privateKey);

            // Send request to J&T Express API
            $response = Http::asForm()->post($this->apiUrl, $requestData);

            // Log the request and response for debugging
            Log::info('J&T Express API Request', [
                'url' => $this->apiUrl,
                'data' => $requestData
            ]);
            Log::info('J&T Express API Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            // Check if request was successful
            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['code'] == 1) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Order sent successfully to J&T Express',
                        'data' => $responseData['data']
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'API Error: ' . ($responseData['msg'] ?? 'Unknown error')
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to connect to J&T Express API',
                    'error' => $response->body()
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('J&T Express API Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while sending order to J&T Express',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order tracking information from J&T Express API
     */
    public function trackOrder(Request $request)
    {
        $validatedData = $request->validate([
            'billCode' => 'required|string'
        ]);

        try {
            // For tracking, we would use a different endpoint
            // This is a placeholder implementation
            $trackingUrl = 'https://demoopenapi.jtexpress.my/webopenplatformapi/api/order/tracking';

            $requestData = [
                'apiAccount' => $this->apiAccount,
                'billCode' => $validatedData['billCode']
            ];

            $response = Http::asForm()->post($trackingUrl, $requestData);

            if ($response->successful()) {
                $responseData = $response->json();

                if ($responseData['code'] == 1) {
                    return response()->json([
                        'success' => true,
                        'data' => $responseData['data']
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'API Error: ' . ($responseData['msg'] ?? 'Unknown error')
                    ], 400);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to connect to J&T Express API'
                ], 500);
            }
        } catch (\Exception $e) {
            Log::error('J&T Express Tracking API Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while tracking order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
