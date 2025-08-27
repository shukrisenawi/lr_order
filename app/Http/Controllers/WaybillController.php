<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WaybillController extends Controller
{
    public function index()
    {
        return view('waybill.index');
    }
}
