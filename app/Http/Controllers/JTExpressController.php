<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JTExpressController extends Controller
{
    public function index()
    {
        return view('settings.jt-express');
    }

    public function sendOrder(Request $request)
    {
        // Placeholder implementation
        return response()->json(['message' => 'Order sent successfully']);
    }
}