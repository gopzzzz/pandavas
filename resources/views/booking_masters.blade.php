@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Booking Masters</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Booking Masters
                        </li>
                    </ol>
                </div>

            </div>

        </div>
    </section>


    <!-- Main Content -->
    <section class="content">

        <div class="container-fluid">

            {{-- Success --}}
            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Error --}}
            @if(session('error'))

                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>

            @endif


            {{-- Validation Errors --}}
            @if($errors->any())

                <div class="alert alert-danger">

                    <ul class="mb-0">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>

                </div>

            @endif


            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Booking List
                    </h3>

                    <!-- ADD BUTTON -->
                    <button type="button"
                            class="btn btn-primary float-right"
                            data-toggle="modal"
                            data-target="#addBookingModal">

                        <i class="fas fa-plus"></i>
                        Add Booking

                    </button>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Booking Person</th>
                                    <th>Phone</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Total Number</th>
                                    <th>Tour</th>
                                    <th>Total Amount</th>
                                    <th>Booking Date</th>
                                    <th>Pickup Location</th>
                                    <th>Payment Status</th>
                                    <th>Payment Mode</th>
                                    <th>Received Amount</th>
                                    <th>Pending Amount</th>
                                    <th>Customer ID</th>
                                    <th>Action</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($bookings as $booking)

                                    <tr>

                                        <td>{{ $booking->id }}</td>

                                        <td>{{ $booking->booking_personname }}</td>

                                        <td>{{ $booking->phonenumber }}</td>

                                        <td>{{ $booking->mail }}</td>

                                        <td>{{ $booking->address }}</td>

                                        <td>{{ $booking->totalnumber }}</td>

                                        <td>

                                            @php
                                                $tour = $tours->where('id', $booking->tour_id)->first();
                                            @endphp

                                            {{ $tour ? $tour->tourname : $booking->tour_id }}

                                        </td>

                                        <td>{{ $booking->totalamount }}</td>

                                        <td>{{ $booking->bookingdate }}</td>

                                        <td>{{ $booking->pickuplocation }}</td>

                                        <td>{{ $booking->payment_status }}</td>

                                        <td>{{ $booking->payment_mode }}</td>

                                        <td>{{ $booking->received_amount }}</td>

                                        <td>{{ $booking->pending_amount }}</td>

                                        <td>{{ $booking->cus_id }}</td>

                                        <td>

                                            <!-- EDIT BUTTON -->
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editBookingModal{{ $booking->id }}">

                                                <i class="fas fa-edit"></i>
                                                Edit

                                            </button>

                                        </td>

                                    </tr>


                                    <!-- ========================= -->
                                    <!-- EDIT MODAL -->
                                    <!-- ========================= -->

                                    <div class="modal fade"
                                         id="editBookingModal{{ $booking->id }}">

                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">

                                                <div class="modal-header">

                                                    <h4 class="modal-title">
                                                        Edit Booking
                                                    </h4>

                                                    <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>


                                                <form method="POST"
                                                      action="{{ route('booking_masters.update', $booking->id) }}">

                                                    @csrf
                                                    @method('PUT')


                                                    <div class="modal-body">


                                                        <div class="form-group">
                                                            <label>Booking Person Name</label>

                                                            <input type="text"
                                                                   name="booking_personname"
                                                                   class="form-control"
                                                                   value="{{ $booking->booking_personname }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Phone Number</label>

                                                            <input type="text"
                                                                   name="phonenumber"
                                                                   class="form-control"
                                                                   value="{{ $booking->phonenumber }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Email</label>

                                                            <input type="email"
                                                                   name="mail"
                                                                   class="form-control"
                                                                   value="{{ $booking->mail }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Address</label>

                                                            <textarea name="address"
                                                                      class="form-control"
                                                                      rows="3"
                                                                      required>{{ $booking->address }}</textarea>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Total Number</label>

                                                            <input type="text"
                                                                   name="totalnumber"
                                                                   class="form-control"
                                                                   value="{{ $booking->totalnumber }}"
                                                                   required>
                                                        </div>


                                                        <!-- TOUR DROPDOWN -->

                                                        <div class="form-group">

                                                            <label>Tour</label>

                                                            <select name="tour_id"
                                                                    class="form-control"
                                                                    required>

                                                                <option value="">
                                                                    Select Tour
                                                                </option>

                                                                @foreach($tours as $tour)

                                                                    <option value="{{ $tour->id }}"
                                                                        {{ $booking->tour_id == $tour->id ? 'selected' : '' }}>

                                                                        {{ $tour->tourname }}

                                                                    </option>

                                                                @endforeach

                                                            </select>

                                                        </div>


                                                        <div class="form-group">
                                                            <label>Total Amount</label>

                                                            <input type="text"
                                                                   name="totalamount"
                                                                   class="form-control"
                                                                   value="{{ $booking->totalamount }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Booking Date</label>

                                                            <input type="date"
                                                                   name="bookingdate"
                                                                   class="form-control"
                                                                   value="{{ $booking->bookingdate }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Pickup Location</label>

                                                            <input type="text"
                                                                   name="pickuplocation"
                                                                   class="form-control"
                                                                   value="{{ $booking->pickuplocation }}"
                                                                   required>
                                                        </div>


                                                        <!-- PAYMENT STATUS -->

                                                        <div class="form-group">

                                                            <label>Payment Status</label>

                                                            <select name="payment_status"
                                                                    class="form-control"
                                                                    required>

                                                                <option value="">
                                                                    Select Payment Status
                                                                </option>

                                                                <option value="Pending"
                                                                    {{ $booking->payment_status == 'Pending' ? 'selected' : '' }}>
                                                                    Pending
                                                                </option>

                                                                <option value="Partially Paid"
                                                                    {{ $booking->payment_status == 'Partially Paid' ? 'selected' : '' }}>
                                                                    Partially Paid
                                                                </option>

                                                                <option value="Paid"
                                                                    {{ $booking->payment_status == 'Paid' ? 'selected' : '' }}>
                                                                    Paid
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <!-- PAYMENT MODE -->

                                                        <div class="form-group">

                                                            <label>Payment Mode</label>

                                                            <select name="payment_mode"
                                                                    class="form-control"
                                                                    required>

                                                                <option value="">
                                                                    Select Payment Mode
                                                                </option>

                                                                <option value="Cash"
                                                                    {{ $booking->payment_mode == 'Cash' ? 'selected' : '' }}>
                                                                    Cash
                                                                </option>

                                                                <option value="Bank Transfer"
                                                                    {{ $booking->payment_mode == 'Bank Transfer' ? 'selected' : '' }}>
                                                                    Bank Transfer
                                                                </option>

                                                                <option value="UPI"
                                                                    {{ $booking->payment_mode == 'UPI' ? 'selected' : '' }}>
                                                                    UPI
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <div class="form-group">
                                                            <label>Received Amount</label>

                                                            <input type="text"
                                                                   name="received_amount"
                                                                   class="form-control"
                                                                   value="{{ $booking->received_amount }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Pending Amount</label>

                                                            <input type="text"
                                                                   name="pending_amount"
                                                                   class="form-control"
                                                                   value="{{ $booking->pending_amount }}"
                                                                   required>
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Customer ID</label>

                                                            <input type="text"
                                                                   name="cus_id"
                                                                   class="form-control"
                                                                   value="{{ $booking->cus_id }}"
                                                                   required>
                                                        </div>


                                                    </div>


                                                    <div class="modal-footer">

                                                        <button type="button"
                                                                class="btn btn-secondary"
                                                                data-dismiss="modal">

                                                            Close

                                                        </button>

                                                        <button type="submit"
                                                                class="btn btn-primary">

                                                            Update

                                                        </button>

                                                    </div>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                @empty

                                    <tr>

                                        <td colspan="16"
                                            class="text-center">

                                            No bookings found.

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


<!-- ================================================= -->
<!-- ADD BOOKING MODAL -->
<!-- ================================================= -->

<div class="modal fade"
     id="addBookingModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title">
                    Add Booking
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <form method="POST"
                  action="{{ route('booking_masters.store') }}">

                @csrf


                <div class="modal-body">


                    <div class="form-group">
                        <label>Booking Person Name</label>

                        <input type="text"
                               name="booking_personname"
                               class="form-control"
                               placeholder="Enter booking person name"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Phone Number</label>

                        <input type="text"
                               name="phonenumber"
                               class="form-control"
                               placeholder="Enter phone number"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Email</label>

                        <input type="email"
                               name="mail"
                               class="form-control"
                               placeholder="Enter email"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Address</label>

                        <textarea name="address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Enter address"
                                  required></textarea>
                    </div>


                    <div class="form-group">
                        <label>Total Number</label>

                        <input type="text"
                               name="totalnumber"
                               class="form-control"
                               placeholder="Enter total number"
                               required>
                    </div>


                    <!-- TOUR DROPDOWN -->

                    <div class="form-group">

                        <label>Tour</label>

                        <select name="tour_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Tour
                            </option>

                            @foreach($tours as $tour)

                                <option value="{{ $tour->id }}">
                                    {{ $tour->tourname }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="form-group">
                        <label>Total Amount</label>

                        <input type="text"
                               name="totalamount"
                               class="form-control"
                               placeholder="Enter total amount"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Booking Date</label>

                        <input type="date"
                               name="bookingdate"
                               class="form-control"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Pickup Location</label>

                        <input type="text"
                               name="pickuplocation"
                               class="form-control"
                               placeholder="Enter pickup location"
                               required>
                    </div>


                    <!-- PAYMENT STATUS -->

                    <div class="form-group">

                        <label>Payment Status</label>

                        <select name="payment_status"
                                class="form-control"
                                required>

                            <option value="">
                                Select Payment Status
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Partially Paid">
                                Partially Paid
                            </option>

                            <option value="Paid">
                                Paid
                            </option>

                        </select>

                    </div>


                    <!-- PAYMENT MODE -->

                    <div class="form-group">

                        <label>Payment Mode</label>

                        <select name="payment_mode"
                                class="form-control"
                                required>

                            <option value="">
                                Select Payment Mode
                            </option>

                            <option value="Cash">
                                Cash
                            </option>

                            <option value="Bank Transfer">
                                Bank Transfer
                            </option>

                            <option value="UPI">
                                UPI
                            </option>

                        </select>

                    </div>


                    <div class="form-group">
                        <label>Received Amount</label>

                        <input type="text"
                               name="received_amount"
                               class="form-control"
                               placeholder="Enter received amount"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Pending Amount</label>

                        <input type="text"
                               name="pending_amount"
                               class="form-control"
                               placeholder="Enter pending amount"
                               required>
                    </div>


                    <div class="form-group">
                        <label>Customer ID</label>

                        <input type="text"
                               name="cus_id"
                               class="form-control"
                               placeholder="Enter customer ID"
                               required>
                    </div>


                </div>


                <div class="modal-footer">

                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">

                        Close

                    </button>


                    <button type="submit"
                            class="btn btn-primary">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection