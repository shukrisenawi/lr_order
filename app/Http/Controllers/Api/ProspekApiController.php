<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prospek;
use App\Models\ProspekAlamat;
use App\Models\ProspekBuy;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProspekApiController extends Controller
{
    /**
     * Get all prospects list
     */
    public function index(): JsonResponse
    {
        try {
            $prospects = Prospek::select('id', 'gelaran', 'no_tel', 'email', 'bisnes_id', 'created_at')
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
            $prospect = Prospek::with([
                'bisnes' => function($query) {
                    $query->select('id', 'nama_bines', 'nama_syarikat', 'jenis_bisnes', 'alamat', 'poskod', 'no_tel');
                },
                'alamat' => function($query) {
                    $query->select('id', 'prospek_id', 'alamat', 'bandar', 'poskod', 'negeri');
                }
            ])->where('no_tel', $no_tel)->first();

            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }

            // Get all purchases for this prospect
            $purchases = ProspekBuy::where('prospek_id', $prospect->id)
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
                'addresses' => $prospect->alamat->map(function($address) {
                    return [
                        'id' => $address->id,
                        'alamat' => $address->alamat,
                        'bandar' => $address->bandar,
                        'poskod' => $address->poskod,
                        'negeri' => $address->negeri
                    ];
                }),
                'purchases' => $purchases->map(function($purchase) {
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
            $prospect = Prospek::where('no_tel', $no_tel)->first();
            
            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }
            
            $addresses = ProspekAlamat::where('prospek_id', $prospect->id)
                                    ->with([
                                        'prospek:id,gelaran,no_tel,bisnes_id',
                                        'prospek.bisnes:id,nama_bines'
                                    ])
                                    ->get();

            $formattedAddresses = $addresses->map(function($address) {
                return [
                    'id' => $address->id,
                    'prospect_name' => $address->prospek->gelaran ?? null,
                    'prospect_phone' => $address->prospek->no_tel ?? null,
                    'business' => $address->prospek->bisnes->nama_bines ?? null,
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
            $prospect = Prospek::where('no_tel', $no_tel)->first();
            
            if (!$prospect) {
                return response()->json([
                    'success' => false,
                    'message' => 'Prospect not found'
                ], 404);
            }
            
            $purchases = ProspekBuy::where('prospek_id', $prospect->id)
                                  ->with([
                                      'prospek:id,gelaran,no_tel,email,bisnes_id',
                                      'prospek.bisnes:id,nama_bines'
                                  ])
                                  ->orderBy('created_at', 'desc')
                                  ->get();

            $formattedPurchases = $purchases->map(function($purchase) {
                return [
                    'id' => $purchase->id,
                    'prospect_info' => [
                        'name' => $purchase->prospek->gelaran ?? null,
                        'phone' => $purchase->prospek->no_tel ?? null,
                        'email' => $purchase->prospek->email ?? null
                    ],
                    'business' => $purchase->prospek->bisnes->nama_bines ?? null,
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

            $prospects = Prospek::where('no_tel', 'LIKE', '%' . $no_tel . '%')
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
}
