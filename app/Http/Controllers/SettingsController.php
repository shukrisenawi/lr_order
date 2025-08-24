<?php

namespace App\Http\Controllers;

use App\Models\ApiToken;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Show settings page
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Show API tokens management page
     */
    public function apiTokens()
    {
        $tokens = ApiToken::where('user_id', auth()->id())
                         ->orderBy('created_at', 'desc')
                         ->get();

        return view('settings.api-tokens', compact('tokens'));
    }

    /**
     * Create new API token
     */
    public function createApiToken(Request $request)
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

        return redirect()->route('settings.api-tokens')
                        ->with('success', 'API token created successfully')
                        ->with('new_token', $token->token);
    }

    /**
     * Delete API token
     */
    public function deleteApiToken($tokenId)
    {
        $token = ApiToken::where('user_id', auth()->id())
                        ->where('id', $tokenId)
                        ->first();

        if (!$token) {
            return redirect()->route('settings.api-tokens')
                           ->with('error', 'Token not found');
        }

        $token->delete();

        return redirect()->route('settings.api-tokens')
                        ->with('success', 'API token deleted successfully');
    }

    /**
     * Show API documentation
     */
    public function apiDocumentation()
    {
        return view('settings.api-documentation');
    }
}
