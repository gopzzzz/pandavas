<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class RevenueReportsController extends Controller
{
    public function index()
    {
        $revenueReports = DB::table('bookingmasters')
            ->select(
                'id',
                'booking_personname',
                'tour_id',
                'payment_status',
                'payment_mode',
                'received_amount',
                'pending_amount',
                'booking_status'
            )
            ->orderBy('id', 'desc')
            ->get();

        return view('revenue_reports', compact('revenueReports'));
    }
}