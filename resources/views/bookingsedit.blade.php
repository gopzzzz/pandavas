@extends('layouts.mainlayout')

@section('content')

<style>
.booking-edit-card {
    background: #fff;
    border: 1px solid #e7eaf0;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,.04);
}

.booking-edit-header {
    padding: 24px 28px;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
}

.booking-edit-header h4 {
    margin: 0;
    font-weight: 700;
    color: #222;
}

.booking-edit-header p {
    margin: 5px 0 0;
    color: #888;
    font-size: 13px;
}

.booking-section {
    padding: 25px 28px;
    border-bottom: 1px solid #eee;
}

.section-title {
    font-size: 16px;
    font-weight: 700;
    color: #333;
    margin-bottom: 20px;
}

.booking-section label {
    display: block;
    margin-bottom: 7px;
    font-size: 13px;
    font-weight: 600;
    color: #444;
}

.booking-section label span {
    color: #dc3545;
}

.booking-section .form-control,
.booking-section .form-select {
    min-height: 45px;
    border-radius: 8px;
    border: 1px solid #dfe3e8;
    font-size: 14px;
}

.booking-section textarea {
    min-height: 90px !important;
}

.passenger-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.passenger-card {
    border: 1px solid #e2e6ea;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 15px;
    background: #fafbfc;
}

.passenger-card-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.passenger-title {
    display: flex;
    align-items: center;
    gap: 10px;
}

.passenger-number {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #eaf2ff;
    color: #0d6efd;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.remove-passenger-btn {
    border: 0;
    background: #fff0f0;
    color: #dc3545;
    width: 35px;
    height: 35px;
    border-radius: 7px;
}

.add-passenger-btn {
    background: #0d6efd;
    color: #fff;
    border: 0;
    border-radius: 8px;
    padding: 9px 15px;
    font-size: 13px;
    font-weight: 600;
}

.current-file {
    margin-top: 6px;
}

.current-file a {
    font-size: 12px;
    color: #0d6efd;
}

.booking-footer {
    padding: 20px 28px;
    background: #f8f9fa;
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.booking-save-btn {
    background: #0d6efd;
    color: #fff;
    border: 0;
    border-radius: 8px;
    padding: 10px 20px;
    font-weight: 600;
}

.booking-cancel-btn {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 10px 20px;
}

@media(max-width:767px) {
    .booking-section {
        padding: 20px 16px;
    }

    .booking-edit-header {
        padding: 20px 16px;
    }

    .booking-footer {
        padding: 16px;
    }

    .passenger-section-header {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }
}
</style>


<div class="content-wrapper">

    <section class="content">

        <div class="container-fluid py-4">

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <div class="booking-edit-card">

                <div class="booking-edit-header">
                    <h4>Edit Booking #{{ $booking->id }}</h4>
                    <p>Update customer, tour, passenger and payment details</p>
                </div>


                <form action="{{ route('bookings.update', $booking->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')


                    <!-- CUSTOMER -->
                    <div class="booking-section">

                        <h6 class="section-title">
                            Customer Details
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label>Booking Person Name <span>*</span></label>

                                <input type="text"
                                       name="booking_personname"
                                       class="form-control"
                                       value="{{ old('booking_personname', $booking->booking_personname) }}"
                                       required>
                            </div>

                            <div class="col-md-4">
                                <label>Phone Number <span>*</span></label>

                                <input type="text"
                                       name="phonenumber"
                                       class="form-control"
                                       value="{{ old('phonenumber', $booking->phonenumber) }}"
                                       required>
                            </div>

                            <div class="col-md-4">
                                <label>Email</label>

                                <input type="email"
                                       name="mail"
                                       class="form-control"
                                       value="{{ old('mail', $booking->mail) }}">
                            </div>

                            <div class="col-md-12">
                                <label>Address</label>

                                <textarea name="address"
                                          class="form-control">{{ old('address', $booking->address) }}</textarea>
                            </div>

                        </div>

                    </div>


                    <!-- TOUR -->
                    <div class="booking-section">

                        <h6 class="section-title">
                            Tour Details
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-4">

                                <label>Tour <span>*</span></label>

                                <select name="tour_id"
                                        class="form-select"
                                        required>

                                    <option value="">
                                        Select Tour
                                    </option>

                                    @foreach($tours as $tour)

                                        <option value="{{ $tour->id }}"
                                            {{ old('tour_id', $booking->tour_id) == $tour->id ? 'selected' : '' }}>

                                            {{ $tour->tourname }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            <div class="col-md-4">

                                <label>Total Number <span>*</span></label>

                                <input type="number"
                                       name="totalnumber"
                                       class="form-control"
                                       min="1"
                                       value="{{ old('totalnumber', $booking->totalnumber) }}"
                                       required>

                            </div>


                            <div class="col-md-4">

                                <label>Booking Date <span>*</span></label>

                                <input type="date"
                                       name="bookingdate"
                                       class="form-control"
                                       value="{{ old('bookingdate', $booking->bookingdate) }}"
                                       required>

                            </div>


                            <div class="col-md-6">

                                <label>Pickup Location</label>

                                <input type="text"
                                       name="pickuplocation"
                                       class="form-control"
                                       value="{{ old('pickuplocation', $booking->pickuplocation) }}">

                            </div>


                            <div class="col-md-6">

                                <label>Customer ID</label>

                                <input type="text"
                                       name="cus_id"
                                       class="form-control"
                                       value="{{ old('cus_id', $booking->cus_id) }}">

                            </div>

                        </div>

                    </div>


                    <!-- PASSENGERS -->
                    <div class="booking-section">

                        <div class="passenger-section-header">

                            <div>
                                <h6 class="section-title mb-1">
                                    Passenger Details
                                </h6>

                                <small class="text-muted">
                                    Add, edit or remove passengers.
                                </small>
                            </div>

                            <button type="button"
                                    class="add-passenger-btn"
                                    id="addPassenger">

                                <i class="fa fa-plus"></i>
                                Add Passenger

                            </button>

                        </div>


                        <div id="passengerContainer">

                            @php
                                $passengers = old(
                                    'passengers',
                                    $booking->transactions->map(function ($passenger) {
                                        return [
                                            'id' => $passenger->id,
                                            'customername' => $passenger->customername,
                                            'age' => $passenger->age,
                                            'phonenumber' => $passenger->phonenumber,
                                            'adharcardnumber' => $passenger->adharcardnumber,
                                            'adharcardpf' => $passenger->adharcardpf,
                                            'seatnumber' => $passenger->seatnumber,
                                        ];
                                    })->toArray()
                                );
                            @endphp


                            @foreach($passengers as $index => $passenger)

                                <div class="passenger-card">

                                    <input type="hidden"
                                           name="passengers[{{ $index }}][id]"
                                           value="{{ $passenger['id'] ?? '' }}">


                                    <div class="passenger-card-header">

                                        <div class="passenger-title">

                                            <span class="passenger-number">
                                                {{ $index + 1 }}
                                            </span>

                                            <strong>
                                                Passenger {{ $index + 1 }}
                                            </strong>

                                        </div>


                                        @if($index > 0)

                                            <button type="button"
                                                    class="remove-passenger-btn">

                                                <i class="fa fa-trash"></i>

                                            </button>

                                        @endif

                                    </div>


                                    <div class="row g-3">

                                        <div class="col-md-4">

                                            <label>
                                                Customer Name <span>*</span>
                                            </label>

                                            <input type="text"
                                                   name="passengers[{{ $index }}][customername]"
                                                   class="form-control"
                                                   value="{{ $passenger['customername'] ?? '' }}"
                                                   required>

                                        </div>


                                        <div class="col-md-4">

                                            <label>
                                                Age <span>*</span>
                                            </label>

                                            <input type="number"
                                                   name="passengers[{{ $index }}][age]"
                                                   class="form-control"
                                                   value="{{ $passenger['age'] ?? '' }}"
                                                   min="1"
                                                   required>

                                        </div>


                                        <div class="col-md-4">

                                            <label>
                                                Phone Number
                                            </label>

                                            <input type="text"
                                                   name="passengers[{{ $index }}][phonenumber]"
                                                   class="form-control"
                                                   value="{{ $passenger['phonenumber'] ?? '' }}">

                                        </div>


                                        <div class="col-md-4">

                                            <label>
                                                Aadhaar Card Number
                                            </label>

                                            <input type="text"
                                                   name="passengers[{{ $index }}][adharcardnumber]"
                                                   class="form-control"
                                                   value="{{ $passenger['adharcardnumber'] ?? '' }}">

                                        </div>


                                        <div class="col-md-4">

                                            <label>
                                                Aadhaar Card
                                            </label>

                                            <input type="file"
                                                   name="passengers[{{ $index }}][adharcardpf]"
                                                   class="form-control">


                                            @if(!empty($passenger['adharcardpf']))

                                                <div class="current-file">

                                                    <a href="{{ asset('uploads/adharcard/' . $passenger['adharcardpf']) }}"
                                                       target="_blank">

                                                        <i class="fa fa-file"></i>
                                                        Current Aadhaar

                                                    </a>

                                                </div>

                                            @endif

                                        </div>


                                        <div class="col-md-4">

                                            <label>
                                                Seat Number
                                            </label>

                                            <input type="text"
                                                   name="passengers[{{ $index }}][seatnumber]"
                                                   class="form-control"
                                                   value="{{ $passenger['seatnumber'] ?? '' }}">

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    </div>


                    <!-- PAYMENT -->
                    <div class="booking-section">

                        <h6 class="section-title">
                            Payment Details
                        </h6>

                        <div class="row g-3">

                            <div class="col-md-4">

                                <label>Total Amount <span>*</span></label>

                                <div class="input-group">

                                    <span class="input-group-text">₹</span>

                                    <input type="number"
                                           name="totalamount"
                                           class="form-control"
                                           step="0.01"
                                           value="{{ old('totalamount', $booking->totalamount) }}"
                                           required>

                                </div>

                            </div>


                            <div class="col-md-4">

                                <label>Payment Status <span>*</span></label>

                                <select name="payment_status"
                                        class="form-select"
                                        required>

                                    <option value="0"
                                        {{ old('payment_status', $booking->payment_status) == 0 ? 'selected' : '' }}>
                                        Pending
                                    </option>

                                    <option value="1"
                                        {{ old('payment_status', $booking->payment_status) == 1 ? 'selected' : '' }}>
                                        Partially Paid
                                    </option>

                                    <option value="2"
                                        {{ old('payment_status', $booking->payment_status) == 2 ? 'selected' : '' }}>
                                        Paid
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-4">

                                <label>Payment Mode <span>*</span></label>

                                <select name="payment_mode"
                                        class="form-select"
                                        required>

                                    <option value="1"
                                        {{ old('payment_mode', $booking->payment_mode) == 1 ? 'selected' : '' }}>
                                        Cash
                                    </option>

                                    <option value="2"
                                        {{ old('payment_mode', $booking->payment_mode) == 2 ? 'selected' : '' }}>
                                        Bank Transfer
                                    </option>

                                    <option value="3"
                                        {{ old('payment_mode', $booking->payment_mode) == 3 ? 'selected' : '' }}>
                                        UPI
                                    </option>

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label>Received Amount</label>

                                <input type="number"
                                       name="received_amount"
                                       class="form-control"
                                       step="0.01"
                                       value="{{ old('received_amount', $booking->received_amount) }}">

                            </div>


                            <div class="col-md-6">

                                <label>Pending Amount</label>

                                <input type="number"
                                       name="pending_amount"
                                       class="form-control"
                                       step="0.01"
                                       value="{{ old('pending_amount', $booking->pending_amount) }}">

                            </div>

                        </div>

                    </div>


                    <div class="booking-footer">

                        <a href="{{ route('bookings.show', $booking->id) }}"
                           class="btn booking-cancel-btn">
                            Cancel
                        </a>

                        <button type="submit"
                                class="booking-save-btn">

                            <i class="fa fa-save me-1"></i>
                            Update Booking

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </section>

</div>


<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<script>
$(document).ready(function () {

    let passengerIndex =
        {{ count($passengers) }};


    $('#addPassenger').click(function () {

        let number = passengerIndex + 1;

        let html = `
            <div class="passenger-card">

                <input type="hidden"
                       name="passengers[${passengerIndex}][id]"
                       value="">

                <div class="passenger-card-header">

                    <div class="passenger-title">

                        <span class="passenger-number">
                            ${number}
                        </span>

                        <strong>
                            Passenger ${number}
                        </strong>

                    </div>

                    <button type="button"
                            class="remove-passenger-btn">

                        <i class="fa fa-trash"></i>

                    </button>

                </div>


                <div class="row g-3">

                    <div class="col-md-4">
                        <label>
                            Customer Name <span>*</span>
                        </label>

                        <input type="text"
                               name="passengers[${passengerIndex}][customername]"
                               class="form-control"
                               required>
                    </div>


                    <div class="col-md-4">
                        <label>
                            Age <span>*</span>
                        </label>

                        <input type="number"
                               name="passengers[${passengerIndex}][age]"
                               class="form-control"
                               min="1"
                               required>
                    </div>


                    <div class="col-md-4">
                        <label>Phone Number</label>

                        <input type="text"
                               name="passengers[${passengerIndex}][phonenumber]"
                               class="form-control">
                    </div>


                    <div class="col-md-4">
                        <label>Aadhaar Card Number</label>

                        <input type="text"
                               name="passengers[${passengerIndex}][adharcardnumber]"
                               class="form-control">
                    </div>


                    <div class="col-md-4">
                        <label>Aadhaar Card</label>

                        <input type="file"
                               name="passengers[${passengerIndex}][adharcardpf]"
                               class="form-control">
                    </div>


                    <div class="col-md-4">
                        <label>Seat Number</label>

                        <input type="text"
                               name="passengers[${passengerIndex}][seatnumber]"
                               class="form-control">
                    </div>

                </div>

            </div>
        `;

        $('#passengerContainer').append(html);

        passengerIndex++;

    });


    $(document).on(
        'click',
        '.remove-passenger-btn',
        function () {

            $(this)
                .closest('.passenger-card')
                .remove();

            renumberPassengers();

        }
    );


    function renumberPassengers()
    {
        $('#passengerContainer .passenger-card')
            .each(function(index) {

                $(this)
                    .find('.passenger-number')
                    .text(index + 1);

                $(this)
                    .find('.passenger-card-header strong')
                    .text('Passenger ' + (index + 1));

            });
    }

});
</script>

@endsection