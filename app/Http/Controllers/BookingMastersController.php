<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingMastersController extends Controller
{
    // LIST
    public function index()
    {
        $bookings = DB::table('booking_masters')
            ->orderBy('id', 'asc')
            ->get();

        $tours = DB::table('tours')
            ->orderBy('tourname', 'asc')
            ->get();

        return view('booking_masters', compact('bookings', 'tours'));
    }


    // ADD
    public function store(Request $request)
    {
        $request->validate([
            'booking_personname' => 'required|string|max:150',
            'phonenumber' => 'required|string|max:20',
            'mail' => 'required|email|max:150',
            'address' => 'required|string',
            'totalnumber' => 'required|integer|min:1',
            'tour_id' => 'required|integer',
            'totalamount' => 'required|numeric|min:0',
            'bookingdate' => 'required|date',
            'pickuplocation' => 'required|string|max:255',
            'payment_status' => 'required|in:Pending,Partially Paid,Paid',
            'payment_mode' => 'required|in:Cash,Bank Transfer,UPI',
            'received_amount' => 'required|numeric|min:0',
            'pending_amount' => 'required|numeric|min:0',
            'cus_id' => 'required|string|max:50',
        ]);

        DB::table('booking_masters')->insert([
            'booking_personname' => $request->booking_personname,
            'phonenumber' => $request->phonenumber,
            'mail' => $request->mail,
            'address' => $request->address,
            'totalnumber' => $request->totalnumber,
            'tour_id' => $request->tour_id,
            'totalamount' => $request->totalamount,
            'bookingdate' => $request->bookingdate,
            'pickuplocation' => $request->pickuplocation,
            'payment_status' => $request->payment_status,
            'payment_mode' => $request->payment_mode,
            'received_amount' => $request->received_amount,
            'pending_amount' => $request->pending_amount,
            'cus_id' => $request->cus_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('booking_masters.index')
            ->with('success', 'Booking added successfully.');
    }


    // EDIT / UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'booking_personname' => 'required|string|max:150',
            'phonenumber' => 'required|string|max:20',
            'mail' => 'required|email|max:150',
            'address' => 'required|string',
            'totalnumber' => 'required|integer|min:1',
            'tour_id' => 'required|integer',
            'totalamount' => 'required|numeric|min:0',
            'bookingdate' => 'required|date',
            'pickuplocation' => 'required|string|max:255',
            'payment_status' => 'required|in:Pending,Partially Paid,Paid',
            'payment_mode' => 'required|in:Cash,Bank Transfer,UPI',
            'received_amount' => 'required|numeric|min:0',
            'pending_amount' => 'required|numeric|min:0',
            'cus_id' => 'required|string|max:50',
        ]);

        DB::table('booking_masters')
            ->where('id', $id)
            ->update([
                'booking_personname' => $request->booking_personname,
                'phonenumber' => $request->phonenumber,
                'mail' => $request->mail,
                'address' => $request->address,
                'totalnumber' => $request->totalnumber,
                'tour_id' => $request->tour_id,
                'totalamount' => $request->totalamount,
                'bookingdate' => $request->bookingdate,
                'pickuplocation' => $request->pickuplocation,
                'payment_status' => $request->payment_status,
                'payment_mode' => $request->payment_mode,
                'received_amount' => $request->received_amount,
                'pending_amount' => $request->pending_amount,
                'cus_id' => $request->cus_id,
                'updated_at' => now(),
            ]);

        return redirect()->route('booking_masters.index')
            ->with('success', 'Booking updated successfully.');
    }
}