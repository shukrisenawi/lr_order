<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();


        // You can add additional data here for the dashboard
        $stats = [
            'totalProduk' => 12,
            'totalProspek' => 8,
            'total' => 3,
            'teamMembers' => 24,
        ];

        return view('dashboard', compact('user', 'stats'));
    }
}
