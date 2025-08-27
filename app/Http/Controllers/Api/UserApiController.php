<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Customer;
use App\Models\CustomerAlamat;
use App\Models\CustomerBuy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserApiController extends Controller
{
    /**
     * Get all prospects list
     */
    public function index(): JsonResponse
    {
        try {
            $prospects = Customer::select('id', 'gelaran', 'no_tel', 'email', 'bisnes_id', 'created_at')
                ->with(['bisnes:id,nama_bines,nama_syarikat'])
                ->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Prospects retrieved successfully',
                'data' => $prospects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve prospects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get specific prospect details by phone number with all related information
     */
    public function show($no_tel): JsonResponse
    {
        try {
            $prospect = Customer::with([
                'bisnes' => function ($query) {
                    $query->select('id', 'nama_bines', 'nama_syarikat', 'jenis_bisnes', 'alamat', 'poskod', 'no_tel');
                },
                'alamat' => function ($query) {
                    $query->select('id', 'customer_id', 'alamat', 'bandar', 'poskod', 'negeri');
                }
            ])->where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            // Get all prospects for this user's businesses
            $businessIds = $user->bisnes->pluck('id');

            $prospects = Customer::whereIn('bisnes_id', $businessIds)
                ->with([
                    'bisnes:id,nama_bines',
                    'alamat' => function ($query) {
                        $query->select('id', 'customer_id', 'alamat', 'bandar', 'poskod', 'negeri');
                    }
                ])
                ->get();

            // Get all purchases for this user's prospects
            $prospectIds = $prospects->pluck('id');

            $purchases = CustomerBuy::whereIn('customer_id', $prospectIds)
                ->with([
                    'customer:id,gelaran,no_tel,bisnes_id',
                    'customer.bisnes:id,nama_bines'
                ])
                ->get();

            // Format the response
            $userData = [
                'user_info' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'created_at' => $user->created_at,
                    'total_businesses' => $user->bisnes->count(),
                    'total_prospects' => $prospects->count(),
                    'total_purchases' => $purchases->count()
                ],
                'businesses' => $user->bisnes->map(function ($business) {
                    return [
                        'id' => $business->id,
                        'nama_bisnes' => $business->nama_bines,
                        'nama_syarikat' => $business->nama_syarikat,
                        'jenis_bisnes' => $business->jenis_bisnes,
                        'alamat' => $business->alamat,
                        'poskod' => $business->poskod,
                        'no_tel' => $business->no_tel,
                        'exp_date' => $business->exp_date
                    ];
                }),
                'prospects' => $prospects->map(function ($prospect) {
                    return [
                        'id' => $prospect->id,
                        'gelaran' => $prospect->gelaran,
                        'no_tel' => $prospect->no_tel,
                        'email' => $prospect->email,
                        'business' => $prospect->bisnes->nama_bines ?? null,
                        'addresses' => $prospect->alamat->map(function ($address) {
                            return [
                                'alamat' => $address->alamat,
                                'bandar' => $address->bandar,
                                'poskod' => $address->poskod,
                                'negeri' => $address->negeri
                            ];
                        })
                    ];
                }),
                'purchases' => $purchases->map(function ($purchase) {
                    return [
                        'id' => $purchase->id,
                        'prospect_name' => $purchase->customer->gelaran ?? null,
                        'prospect_phone' => $purchase->customer->no_tel ?? null,
                        'business' => $purchase->customer->bisnes->nama_bines ?? null,
                        'purchase_date' => $purchase->created_at,
                        'amount' => $purchase->amount ?? null,
                        'status' => $purchase->status ?? null
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'message' => 'User details retrieved successfully',
                'data' => $userData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve user details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's addresses (all prospect addresses)
     */
    public function addresses($id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $businessIds = $user->bisnes->pluck('id');
            $prospectIds = Customer::whereIn('bisnes_id', $businessIds)->pluck('id');

            $addresses = CustomerAlamat::whereIn('customer_id', $prospectIds)
                ->with([
                    'customer:id,gelaran,no_tel,bisnes_id',
                    'customer.bisnes:id,nama_bines'
                ])
                ->get();

            $formattedAddresses = $addresses->map(function ($address) {
                return [
                    'id' => $address->id,
                    'prospect_name' => $address->customer->gelaran ?? null,
                    'prospect_phone' => $address->customer->no_tel ?? null,
                    'business' => $address->customer->bisnes->nama_bines ?? null,
                    'alamat' => $address->alamat,
                    'bandar' => $address->bandar,
                    'poskod' => $address->poskod,
                    'negeri' => $address->negeri
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'User addresses retrieved successfully',
                'data' => $formattedAddresses
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve addresses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get user's purchases
     */
    public function purchases($id): JsonResponse
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            $businessIds = $user->bisnes->pluck('id');
            $prospectIds = Customer::whereIn('bisnes_id', $businessIds)->pluck('id');

            $purchases = CustomerBuy::whereIn('customer_id', $prospectIds)
                ->with([
                    'customer:id,gelaran,no_tel,email,bisnes_id',
                    'customer.bisnes:id,nama_bines'
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            $formattedPurchases = $purchases->map(function ($purchase) {
                return [
                    'id' => $purchase->id,
                    'prospect_info' => [
                        'name' => $purchase->customer->gelaran ?? null,
                        'phone' => $purchase->customer->no_tel ?? null,
                        'email' => $purchase->customer->email ?? null
                    ],
                    'business' => $purchase->customer->bisnes->nama_bines ?? null,
                    'purchase_date' => $purchase->created_at,
                    'amount' => $purchase->amount ?? null,
                    'status' => $purchase->status ?? null,
                    'notes' => $purchase->notes ?? null
                ];
            });

            return response()->json([
                'success' => true,
                'message' => 'User purchases retrieved successfully',
                'data' => $formattedPurchases
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve purchases',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
