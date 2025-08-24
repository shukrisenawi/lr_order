<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ApiToken;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-Key');
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'API Key is required',
                'error' => 'Missing X-API-Key header'
            ], 401);
        }
        
        $token = ApiToken::where('token', $apiKey)
                        ->where('is_active', true)
                        ->first();
        
        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid API Key',
                'error' => 'API Key not found or inactive'
            ], 401);
        }
        
        // Update last used timestamp
        $token->update(['last_used_at' => now()]);
        
        // Add token info to request for logging
        $request->merge(['api_token' => $token]);
        
        return $next($request);
    }
}
