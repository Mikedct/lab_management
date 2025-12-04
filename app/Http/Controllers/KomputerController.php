<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class KomputerController extends Controller
{
    public function index()
    {
        $komputers = DB::table('komputer')->get();
        return view('dashboard.komputer', compact('komputers'));
    }
}
