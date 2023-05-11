<?php

namespace App\Http\Controllers;


use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $labels=['jan','feb','april','may','jun','july'];
        $data=[65, 59, 80, 81, 56, 55, 40];

        return view('dashboard', compact('labels','data'));
    }
}
