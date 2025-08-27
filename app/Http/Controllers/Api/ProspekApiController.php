<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerAlamat;
use App\Models\CustomerBuy;
use App\Models\Prospek;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class ProspekApiController extends Controller
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

            // Get all purchases for this prospect
            $purchases = CustomerBuy::where('customer_id', $prospect->id)
                ->orderBy('created_at', 'desc')
                ->get();

            // Format the response
            $prospectData = [
                'prospect_info' => [
                    'id' => $prospect->id,
                    'gelaran' => $prospect->gelaran,
                    'no_tel' => $prospect->no_tel,
                    'email' => $prospect->email,
                    'created_at' => $prospect->created_at,
                    'total_addresses' => $prospect->alamat->count(),
                    'total_purchases' => $purchases->count()
                ],
                'business' => [
                    'id' => $prospect->bisnes->id,
                    'nama_bisnes' => $prospect->bisnes->nama_bines,
                    'nama_syarikat' => $prospect->bisnes->nama_syarikat,
                    'jenis_bisnes' => $prospect->bisnes->jenis_bisnes,
                    'alamat' => $prospect->bisnes->alamat,
                    'poskod' => $prospect->bisnes->poskod,
                    'no_tel' => $prospect->bisnes->no_tel
                ],
                'addresses' => $prospect->alamat->map(function ($address) {
                    return [
                        'id' => $address->id,
                        'alamat' => $address->alamat,
                        'bandar' => $address->bandar,
                        'poskod' => $address->poskod,
                        'negeri' => $address->negeri
                    ];
                }),
                'purchases' => $purchases->map(function ($purchase) {
                    return [
                        'id' => $purchase->id,
                        'purchase_date' => $purchase->created_at,
                        'amount' => $purchase->amount ?? null,
                        'status' => $purchase->status ?? null,
                        'notes' => $purchase->notes ?? null
                    ];
                })
            ];

            return response()->json([
                'success' => true,
                'message' => 'Prospect details retrieved successfully',
                'data' => $prospectData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve prospect details',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get prospect's addresses by phone number
     */
    public function addresses($no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            $addresses = CustomerAlamat::where('customer_id', $prospect->id)
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
                'message' => 'Prospect addresses retrieved successfully',
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
     * Get prospect's purchases by phone number
     */
    public function purchases($no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            $purchases = CustomerBuy::where('customer_id', $prospect->id)
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
                'message' => 'Prospect purchases retrieved successfully',
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

    /**
     * Search prospects by phone number (partial match)
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $no_tel = $request->get('no_tel');

            if (!$no_tel) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phone number parameter is required'
                ], 400);
            }

            $prospects = Customer::where('no_tel', 'LIKE', '%' . $no_tel . '%')
                ->with(['bisnes:id,nama_bines,nama_syarikat'])
                ->select('id', 'gelaran', 'no_tel', 'email', 'bisnes_id', 'created_at')
                ->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Prospects search results',
                'data' => $prospects
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to search prospects',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create a new prospect
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'gelaran' => 'required|string|max:255',
                'no_tel' => 'required|string|max:20|unique:customer,no_tel',
                'email' => 'nullable|email|max:255',
                'bisnes_id' => 'required|integer|exists:bisnes,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $prospect = Customer::create($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Prospect created successfully',
                'data' => $prospect
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update an existing prospect
     */
    public function update(Request $request, $no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'gelaran' => 'sometimes|string|max:255',
                'email' => 'nullable|email|max:255',
                'bisnes_id' => 'sometimes|integer|exists:bisnes,id',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $prospect->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Prospect updated successfully',
                'data' => $prospect
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete a prospect
     */
    public function destroy($no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            // Check if prospect has any purchases or addresses
            $hasPurchases = CustomerBuy::where('customer_id', $prospect->id)->exists();
            $hasAddresses = CustomerAlamat::where('customer_id', $prospect->id)->exists();

            if ($hasPurchases || $hasAddresses) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete prospect with existing purchases or addresses'
                ], 422);
            }

            $prospect->delete();

            return response()->json([
                'success' => true,
                'message' => 'Prospect deleted successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete prospect',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get prospect summary with counts
     */
    public function summary($no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            $addressCount = CustomerAlamat::where('customer_id', $prospect->id)->count();
            $purchaseCount = CustomerBuy::where('customer_id', $prospect->id)->count();
            $totalAmount = CustomerBuy::where('customer_id', $prospect->id)->sum('jumlah');

            return response()->json([
                'success' => true,
                'message' => 'Prospect summary retrieved successfully',
                'data' => [
                    'prospect' => $prospect,
                    'address_count' => $addressCount,
                    'purchase_count' => $purchaseCount,
                    'total_amount' => $totalAmount
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve prospect summary',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add new address to prospect
     */
    public function addAddress(Request $request, $no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'alamat' => 'required|string|max:255',
                'poskod' => 'required|string|max:10',
                'bandar' => 'required|string|max:100',
                'negeri' => 'required|string|max:100',
                'negara' => 'required|string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $address = CustomerAlamat::create([
                'customer_id' => $prospect->id,
                'alamat' => $request->alamat,
                'poskod' => $request->poskod,
                'bandar' => $request->bandar,
                'negeri' => $request->negeri,
                'negara' => $request->negara,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Address added successfully',
                'data' => $address
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add address',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Add new purchase to prospect
     */
    public function addPurchase(Request $request, $no_tel): JsonResponse
    {
        try {
            $prospect = Customer::where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            $validator = Validator::make($request->all(), [
                'produk_id' => 'required|integer|exists:produk,id',
                'customer_alamat_id' => 'required|integer|exists:customer_alamat,id',
                'jumlah' => 'required|numeric|min:0',
                'kuantiti' => 'required|integer|min:1',
                'status' => 'required|string|max:50',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $purchase = CustomerBuy::create([
                'customer_id' => $prospect->id,
                'produk_id' => $request->produk_id,
                'customer_alamat_id' => $request->customer_alamat_id,
                'jumlah' => $request->jumlah,
                'kuantiti' => $request->kuantiti,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Purchase added successfully',
                'data' => $purchase->load(['produk', 'customerAlamat'])
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add purchase',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
