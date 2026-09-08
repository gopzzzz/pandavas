<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\BookingMaster;
use App\Models\BookingTrans;
use App\Models\Tour;


class BookingController extends Controller
{
     
    public function index()
    {
        $tours = DB::table('tours')
            ->orderBy('id', 'asc')
            ->get();

        return view('bookings', compact('tours'));
    }


    // ADD
  public function store(Request $request)
{
    $request->validate([
        'booking_personname' => 'required|string|max:255',
        'phonenumber'        => 'required|string|max:20',
        'mail'               => 'nullable|email|max:255',
        'address'            => 'nullable|string',
        'totalnumber'        => 'required|integer|min:1',
        'tour_id'            => 'required|exists:tours,id',
        'totalamount'        => 'required|numeric|min:0',
        'bookingdate'        => 'required|date',
        'pickuplocation'     => 'nullable|string|max:255',
        'payment_status'     => 'required|in:0,1,2',
        'payment_mode'       => 'required|in:1,2,3',
        'received_amount'    => 'nullable|numeric|min:0',
        'pending_amount'     => 'nullable|numeric|min:0',
        'cus_id'             => 'nullable',

        'passengers'                       => 'required|array|min:1',
        'passengers.*.customername'        => 'required|string|max:255',
        'passengers.*.age'                 => 'required|integer|min:1',
        'passengers.*.phonenumber'         => 'nullable|string|max:20',
        'passengers.*.adharcardnumber'     => 'nullable|string|max:20',
        'passengers.*.adharcardpf'         => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'passengers.*.seatnumber'          => 'nullable|string|max:20',
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Create Booking Master
        |--------------------------------------------------------------------------
        */

        $booking = new BookingMaster();

        $booking->booking_personname = $request->booking_personname;
        $booking->phonenumber        = $request->phonenumber;
        $booking->mail               = $request->mail;
        $booking->address            = $request->address;
        $booking->totalnumber        = $request->totalnumber;
        $booking->tour_id            = $request->tour_id;
        $booking->totalamount       = $request->totalamount;
        $booking->bookingdate        = $request->bookingdate;
        $booking->pickuplocation     = $request->pickuplocation;
        $booking->payment_status     = $request->payment_status;
        $booking->payment_mode       = $request->payment_mode;
        $booking->received_amount    = $request->received_amount ?? 0;
        $booking->pending_amount     = $request->pending_amount ?? 0;
        $booking->cus_id             = $request->cus_id;

        $booking->save();


        /*
        |--------------------------------------------------------------------------
        | Store Passenger / Booking Transactions
        |--------------------------------------------------------------------------
        */

        foreach ($request->passengers as $index => $passenger) {

            $bookingTrans = new BookingTrans();

            $bookingTrans->bookid            = $booking->id;
            $bookingTrans->customername      = $passenger['customername'];
            $bookingTrans->age               = $passenger['age'];
            $bookingTrans->phonenumber       = $passenger['phonenumber'] ?? null;
            $bookingTrans->adharcardnumber   = $passenger['adharcardnumber'] ?? null;
            $bookingTrans->seatnumber        = $passenger['seatnumber'] ?? null;


            /*
            |--------------------------------------------------------------------------
            | Aadhaar File Upload
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile("passengers.$index.adharcardpf")) {

                $file = $request->file("passengers.$index.adharcardpf");

                $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();

                $file->move(
                    public_path('uploads/adharcard'),
                    $filename
                );

                $bookingTrans->adharcardpf = $filename;
            }

            $bookingTrans->save();
        }


        /*
        |--------------------------------------------------------------------------
        | Commit
        |--------------------------------------------------------------------------
        */

        DB::commit();

        return redirect()
            ->route('bookings.index')
            ->with('success', 'Booking created successfully.');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with('error', 'Booking failed: ' . $e->getMessage());
    }
}

public function list()
{
    $bookings = BookingMaster::with([
        'tour',
        'transactions'
    ])->latest()->get();

    return view('bookinglist', compact('bookings'));
}

public function show($id)
{
    $booking = BookingMaster::with([
        'tour',
        'transactions'
    ])->findOrFail($id);

    return view('show', compact('booking'));
}

public function edit($id)
{
    $booking = BookingMaster::with([
        'tour',
        'transactions'
    ])->findOrFail($id);

    $tours = Tour::orderBy('tourname')->get();

    return view('bookingsedit', compact(
        'booking',
        'tours'
    ));
}

  public function update(Request $request, $id)
{
    $request->validate([
        'booking_personname' => 'required|string|max:255',
        'phonenumber'        => 'required|string|max:20',
        'mail'               => 'nullable|email|max:255',
        'address'            => 'nullable|string',
        'totalnumber'        => 'required|integer|min:1',
        'tour_id'            => 'required|exists:tours,id',
        'totalamount'        => 'required|numeric|min:0',
        'bookingdate'        => 'required|date',
        'pickuplocation'     => 'nullable|string|max:255',
        'payment_status'     => 'required|in:0,1,2',
        'payment_mode'       => 'required|in:1,2,3',
        'received_amount'    => 'nullable|numeric|min:0',
        'pending_amount'     => 'nullable|numeric|min:0',
        'cus_id'             => 'nullable',

        'passengers' => 'required|array|min:1',

        'passengers.*.customername' =>
            'required|string|max:255',

        'passengers.*.age' =>
            'required|integer|min:1',

        'passengers.*.phonenumber' =>
            'nullable|string|max:20',

        'passengers.*.adharcardnumber' =>
            'nullable|string|max:20',

        'passengers.*.seatnumber' =>
            'nullable|string|max:20',

        'passengers.*.adharcardpf' =>
            'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    DB::beginTransaction();

    try {

        /*
        |--------------------------------------------------------------------------
        | Booking Master
        |--------------------------------------------------------------------------
        */

        $booking = BookingMaster::findOrFail($id);

        $booking->booking_personname = $request->booking_personname;
        $booking->phonenumber        = $request->phonenumber;
        $booking->mail               = $request->mail;
        $booking->address            = $request->address;
        $booking->totalnumber        = $request->totalnumber;
        $booking->tour_id            = $request->tour_id;
        $booking->totalamount        = $request->totalamount;
        $booking->bookingdate        = $request->bookingdate;
        $booking->pickuplocation     = $request->pickuplocation;
        $booking->payment_status     = $request->payment_status;
        $booking->payment_mode       = $request->payment_mode;
        $booking->received_amount    = $request->received_amount ?? 0;
        $booking->pending_amount     = $request->pending_amount ?? 0;
        $booking->cus_id             = $request->cus_id;

        $booking->save();


        /*
        |--------------------------------------------------------------------------
        | Existing Passenger IDs
        |--------------------------------------------------------------------------
        */

        $existingPassengerIds = $booking->transactions()
            ->pluck('id')
            ->toArray();

        $submittedPassengerIds = [];


        /*
        |--------------------------------------------------------------------------
        | Update / Create Passengers
        |--------------------------------------------------------------------------
        */

        foreach ($request->passengers as $index => $passenger) {

            /*
             * Existing passenger
             */
            if (!empty($passenger['id'])) {

                $bookingTrans = BookingTrans::where('id', $passenger['id'])
                    ->where('bookid', $booking->id)
                    ->firstOrFail();

                $submittedPassengerIds[] = $bookingTrans->id;

            } else {

                /*
                 * New passenger
                 */
                $bookingTrans = new BookingTrans();

                $bookingTrans->bookid = $booking->id;
            }


            $bookingTrans->customername =
                $passenger['customername'];

            $bookingTrans->age =
                $passenger['age'];

            $bookingTrans->phonenumber =
                $passenger['phonenumber'] ?? null;

            $bookingTrans->adharcardnumber =
                $passenger['adharcardnumber'] ?? null;

            $bookingTrans->seatnumber =
                $passenger['seatnumber'] ?? null;


            /*
            |--------------------------------------------------------------------------
            | Aadhaar File
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile(
                "passengers.$index.adharcardpf"
            )) {

                $file = $request->file(
                    "passengers.$index.adharcardpf"
                );

                $filename = time()
                    . '_' . $index
                    . '_' . $file->getClientOriginalName();

                $file->move(
                    public_path('uploads/adharcard'),
                    $filename
                );

                /*
                 * Delete old file
                 */
                if (
                    !empty($bookingTrans->adharcardpf) &&
                    file_exists(
                        public_path(
                            'uploads/adharcard/' .
                            $bookingTrans->adharcardpf
                        )
                    )
                ) {
                    unlink(
                        public_path(
                            'uploads/adharcard/' .
                            $bookingTrans->adharcardpf
                        )
                    );
                }

                $bookingTrans->adharcardpf = $filename;
            }

            $bookingTrans->save();

            if (!in_array(
                $bookingTrans->id,
                $submittedPassengerIds
            )) {
                $submittedPassengerIds[] =
                    $bookingTrans->id;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Removed Passengers
        |--------------------------------------------------------------------------
        */

        $passengersToDelete = array_diff(
            $existingPassengerIds,
            $submittedPassengerIds
        );

        foreach ($passengersToDelete as $passengerId) {

            $passenger = BookingTrans::find($passengerId);

            if ($passenger) {

                if (
                    !empty($passenger->adharcardpf) &&
                    file_exists(
                        public_path(
                            'uploads/adharcard/' .
                            $passenger->adharcardpf
                        )
                    )
                ) {
                    unlink(
                        public_path(
                            'uploads/adharcard/' .
                            $passenger->adharcardpf
                        )
                    );
                }

                $passenger->delete();
            }
        }


        DB::commit();

        return redirect()
            ->route('bookings.list')
            ->with(
                'success',
                'Booking updated successfully.'
            );

    } catch (\Exception $e) {

        DB::rollBack();

        return back()
            ->withInput()
            ->with(
                'error',
                'Booking update failed: ' .
                $e->getMessage()
            );
    }
}
}
