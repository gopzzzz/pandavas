<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = DB::table('customers')
            ->orderBy('id', 'asc')
            ->get();

        return view('customers', compact('customers'));
    }
}