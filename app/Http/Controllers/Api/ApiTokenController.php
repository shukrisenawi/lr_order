<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ApiTokenController extends Controller
{
    /**
     * Get all API tokens for the authenticated user
     */
    public function index(): JsonResponse
    {
        $tokens = ApiToken::where('user_id', auth()->id())
                         ->select('id', 'name', 'is_active', 'last_used_at', 'expires_at', 'created_at')
                         ->orderBy('created_at', 'desc')
                         ->get();

        return response()->json([
            'success' => true,
            'data' => $tokens
        ]);
    }

    /**
     * Create a new API token
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'expires_at' => 'nullable|date|after:now'
        ]);

        $token = ApiToken::createForUser(
            auth()->id(),
            $request->name,
            $request->expires_at
        );

        return response()->json([
            'success' => true,
            'message' => 'API token created successfully',
            'data' => [
                'id' => $token->id,
                'name' => $token->name,
                'token' => $token->token, // Only show full token on creation
                'expires_at' => $token->expires_at,
                'created_at' => $token->created_at
            ]
        ], 201);
    }

    /**
     * Delete an API token
     */
    public function destroy($tokenId): JsonResponse
    {
        $token = ApiToken::where('user_id', auth()->id())
                        ->where('id', $tokenId)
                        ->first();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Token not found'
            ], 404);
        }

        $token->delete();

        return response()->json([
            'success' => true,
            'message' => 'API token deleted successfully'
        ]);
    }
}
