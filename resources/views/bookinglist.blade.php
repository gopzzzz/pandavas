@extends('layouts.mainlayout')

@section('content')

<style>
.booking-page {
    padding: 25px;
}

.booking-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 22px;
}

.booking-header h4 {
    margin: 0;
    font-size: 23px;
    font-weight: 700;
    color: #222;
}

.booking-header p {
    margin: 5px 0 0;
    color: #888;
    font-size: 13px;
}

.add-booking-btn {
    background: #0d6efd;
    color: #fff;
    border-radius: 8px;
    padding: 10px 17px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
}

.add-booking-btn:hover {
    background: #0b5ed7;
    color: #fff;
}

.booking-list-card {
    background: #fff;
    border: 1px solid #e8ebef;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,.04);
}

.booking-table-wrapper {
    overflow-x: auto;
}

.booking-table {
    width: 100%;
    min-width: 1100px;
    border-collapse: collapse;
}

.booking-table th {
    background: #f8f9fa;
    color: #777;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    padding: 15px 18px;
    border-bottom: 1px solid #e9ecef;
    white-space: nowrap;
}

.booking-table td {
    padding: 16px 18px;
    border-bottom: 1px solid #f0f1f3;
    vertical-align: middle;
    font-size: 13px;
    color: #444;
}

.booking-table tr:last-child td {
    border-bottom: 0;
}

.booking-id {
    background: #eef4ff;
    color: #0d6efd;
    padding: 6px 9px;
    border-radius: 6px;
    font-weight: 700;
    font-size: 12px;
}

.customer-name {
    font-weight: 700;
    color: #222;
}

.customer-phone {
    display: block;
    margin-top: 3px;
    color: #888;
    font-size: 12px;
}

.tour-name {
    font-weight: 600;
    color: #333;
}

.booking-date {
    white-space: nowrap;
    color: #666;
}

.person-count {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #f1f5f9;
    padding: 6px 10px;
    border-radius: 7px;
    font-weight: 600;
}

.booking-amount {
    font-weight: 700;
    color: #222;
}

.payment-badge {
    display: inline-block;
    padding: 6px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.payment-pending {
    background: #fff3cd;
    color: #856404;
}

.payment-partial {
    background: #cff4fc;
    color: #055160;
}

.payment-paid {
    background: #d1e7dd;
    color: #0f5132;
}

.action-btn {
    width: 34px;
    height: 34px;
    border-radius: 7px;
    border: 1px solid #e1e5e9;
    background: #fff;
    color: #555;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    margin-right: 4px;
}

.action-btn:hover {
    background: #f1f3f5;
    color: #0d6efd;
}

.delete-btn:hover {
    color: #dc3545;
}

.empty-booking {
    text-align: center;
    padding: 60px 20px;
    color: #888;
}

.empty-booking i {
    font-size: 42px;
    margin-bottom: 12px;
    color: #ccc;
}

@media(max-width:767px) {
    .booking-page {
        padding: 15px;
    }

    .booking-header {
        align-items: flex-start;
        gap: 15px;
        flex-direction: column;
    }
}
</style>


<div class="content-wrapper">

    <section class="content-header">
        <div class="container-fluid">
            <div class="booking-page">

                <div class="booking-header">

                    <div>
                        <h4>Bookings</h4>
                        <p>Manage all tour bookings and passenger details</p>
                    </div>

                    <a href="{{ route('bookings.index') }}"
                       class="add-booking-btn">
                        <i class="fa fa-plus me-1"></i>
                        New Booking
                    </a>

                </div>


                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                <div class="booking-list-card">

                    <div class="booking-table-wrapper">

                        <table class="booking-table">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Customer</th>
                                    <th>Tour</th>
                                    <th>Booking Date</th>
                                    <th>Persons</th>
                                    <th>Total Amount</th>
                                    <th>Received</th>
                                    <th>Pending</th>
                                    <th>Payment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($bookings as $booking)

                                    <tr>

                                        <td>
                                            <span class="booking-id">
                                                #{{ $booking->id }}
                                            </span>
                                        </td>

                                        <td>
                                            <div class="customer-name">
                                                {{ $booking->booking_personname }}
                                            </div>

                                            <span class="customer-phone">
                                                {{ $booking->phonenumber }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="tour-name">
                                                {{ $booking->tour->tourname ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="booking-date">
                                                {{ \Carbon\Carbon::parse($booking->bookingdate)->format('d M Y') }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="person-count">
                                                <i class="fa fa-users"></i>
                                                {{ $booking->totalnumber }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="booking-amount">
                                                ₹ {{ number_format($booking->totalamount, 2) }}
                                            </span>
                                        </td>

                                        <td>
                                            ₹ {{ number_format($booking->received_amount, 2) }}
                                        </td>

                                        <td>
                                            ₹ {{ number_format($booking->pending_amount, 2) }}
                                        </td>

                                        <td>

                                            @if($booking->payment_status == 0)

                                                <span class="payment-badge payment-pending">
                                                    Pending
                                                </span>

                                            @elseif($booking->payment_status == 1)

                                                <span class="payment-badge payment-partial">
                                                    Partially Paid
                                                </span>

                                            @else

                                                <span class="payment-badge payment-paid">
                                                    Paid
                                                </span>

                                            @endif

                                        </td>

                                        <td>

                                            <a href="{{ route('bookings.show', $booking->id) }}"
                                               class="action-btn"
                                               title="View">
                                                <i class="fa fa-eye"></i>
                                            </a>

                                           <a href="{{ route('bookings.edit', $booking->id) }}"
   class="action-btn"
   title="Edit">
    <i class="fa fa-edit"></i>
</a>
                                            


                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="10">

                                            <div class="empty-booking">
                                                <i class="fa fa-calendar"></i>
                                                <h5>No Bookings Found</h5>
                                                <p>Create your first tour booking.</p>
                                            </div>

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>
        </div>
    </section>

</div>
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>

@endsection