@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Tours</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Tours
                        </li>
                    </ol>
                </div>

            </div>

        </div>
    </section>


    <!-- Main Content -->
    <section class="content">

        <div class="container-fluid">

            {{-- Success Message --}}
            @if(session('success'))

                <div class="alert alert-success">
                    {{ session('success') }}
                </div>

            @endif


            {{-- Error Message --}}
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
                        Tours List
                    </h3>

                    <!-- ADD BUTTON -->
                    <button type="button"
                            class="btn btn-primary float-right"
                            data-toggle="modal"
                            data-target="#addTourModal">

                        <i class="fas fa-plus"></i>
                        Add Tour

                    </button>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Tour Name</th>
                                    <th>Image</th>
                                    <th>Features</th>
                                    <th>Description</th>
                                    <th>Amount</th>
                                    <th>Total Seats</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Pickup Locations</th>
                                    <th>Action</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($tours as $tour)

                                    <tr>

                                        <td>
                                            {{ $tour->id }}
                                        </td>

                                        <td>
                                            {{ $tour->tourname }}
                                        </td>

                                        <td>

                                            <img src="{{ asset('uploads/tours/' . $tour->image) }}"
                                                 width="80"
                                                 height="60"
                                                 style="object-fit: cover;">

                                        </td>

                                        <td>
                                            {{ $tour->features }}
                                        </td>

                                        <td>
                                            {{ $tour->description }}
                                        </td>

                                        <td>
                                            {{ $tour->amount }}
                                        </td>

                                        <td>
                                            {{ $tour->total_seats }}
                                        </td>

                                        <td>
                                            {{ $tour->date }}
                                        </td>

                                        <td>
                                            {{ $tour->time }}
                                        </td>

                                        <td>
                                            {{ $tour->pickuplocations }}
                                        </td>

                                        <td>

                                            <!-- EDIT BUTTON -->
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editTourModal{{ $tour->id }}">

                                                <i class="fas fa-edit"></i>
                                                Edit

                                            </button>

                                        </td>

                                    </tr>


                                    <!-- ========================= -->
                                    <!-- EDIT MODAL -->
                                    <!-- ========================= -->

                                    <div class="modal fade"
                                         id="editTourModal{{ $tour->id }}">

                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">


                                                <div class="modal-header">

                                                    <h4 class="modal-title">
                                                        Edit Tour
                                                    </h4>

                                                    <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>


                                                <form method="POST"
                                                      enctype="multipart/form-data"
                                                      action="{{ route('tours.update', $tour->id) }}">

                                                    @csrf
                                                    @method('PUT')


                                                    <div class="modal-body">

                                                        <!-- Tour Name -->

                                                        <div class="form-group">

                                                            <label>
                                                                Tour Name
                                                            </label>

                                                            <input type="text"
                                                                   name="tourname"
                                                                   class="form-control"
                                                                   value="{{ $tour->tourname }}"
                                                                   required>

                                                        </div>


                                                        <!-- Current Image -->

                                                        <div class="form-group">

                                                            <label>
                                                                Current Image
                                                            </label>

                                                            <br>

                                                            <img src="{{ asset('uploads/tours/' . $tour->image) }}"
                                                                 width="120"
                                                                 height="80"
                                                                 style="object-fit: cover;">

                                                        </div>


                                                        <!-- New Image -->

                                                        <div class="form-group">

                                                            <label>
                                                                Replace Image
                                                            </label>

                                                            <input type="file"
                                                                   name="image"
                                                                   class="form-control"
                                                                   accept=".jpg,.jpeg,.png,.webp">

                                                        </div>


                                                        <!-- Features -->

                                                        <div class="form-group">

                                                            <label>
                                                                Features
                                                            </label>

                                                            <textarea name="features"
                                                                      class="form-control"
                                                                      rows="4"
                                                                      required>{{ $tour->features }}</textarea>

                                                        </div>


                                                        <!-- Description -->

                                                        <div class="form-group">

                                                            <label>
                                                                Description
                                                            </label>

                                                            <textarea name="description"
                                                                      class="form-control"
                                                                      rows="5"
                                                                      required>{{ $tour->description }}</textarea>

                                                        </div>


                                                        <!-- Amount -->

                                                        <div class="form-group">

                                                            <label>
                                                                Amount
                                                            </label>

                                                            <input type="text"
                                                                   name="amount"
                                                                   class="form-control"
                                                                   value="{{ $tour->amount }}"
                                                                   required>

                                                        </div>


                                                        <!-- Total Seats -->

                                                        <div class="form-group">

                                                            <label>
                                                                Total Seats
                                                            </label>

                                                            <input type="text"
                                                                   name="total_seats"
                                                                   class="form-control"
                                                                   value="{{ $tour->total_seats }}"
                                                                   required>

                                                        </div>


                                                        <!-- Date -->

                                                        <div class="form-group">

                                                            <label>
                                                                Date
                                                            </label>

                                                            <input type="date"
                                                                   name="date"
                                                                   class="form-control"
                                                                   value="{{ $tour->date }}"
                                                                   required>

                                                        </div>


                                                        <!-- Time -->

                                                        <div class="form-group">

                                                            <label>
                                                                Time
                                                            </label>

                                                            <input type="time"
                                                                   name="time"
                                                                   class="form-control"
                                                                   value="{{ $tour->time }}"
                                                                   required>

                                                        </div>


                                                        <!-- Pickup Locations -->

                                                        <div class="form-group">

                                                            <label>
                                                                Pickup Locations
                                                            </label>

                                                            <input type="text"
                                                                   name="pickuplocations"
                                                                   class="form-control"
                                                                   value="{{ $tour->pickuplocations }}"
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

                                        <td colspan="11"
                                            class="text-center">

                                            No tours found.

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
<!-- ADD TOUR MODAL -->
<!-- ================================================= -->

<div class="modal fade"
     id="addTourModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title">
                    Add Tour
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('tours.store') }}">

                @csrf


                <div class="modal-body">


                    <!-- Tour Name -->

                    <div class="form-group">

                        <label>
                            Tour Name
                        </label>

                        <input type="text"
                               name="tourname"
                               class="form-control"
                               placeholder="Enter tour name"
                               required>

                    </div>


                    <!-- Image -->

                    <div class="form-group">

                        <label>
                            Image
                        </label>

                        <input type="file"
                               name="image"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.webp"
                               required>

                        <small class="text-muted">
                            JPG, JPEG, PNG or WEBP. Maximum 10MB.
                        </small>

                    </div>


                    <!-- Features -->

                    <div class="form-group">

                        <label>
                            Features
                        </label>

                        <textarea name="features"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Enter tour features"
                                  required></textarea>

                    </div>


                    <!-- Description -->

                    <div class="form-group">

                        <label>
                            Description
                        </label>

                        <textarea name="description"
                                  class="form-control"
                                  rows="5"
                                  placeholder="Enter tour description"
                                  required></textarea>

                    </div>


                    <!-- Amount -->

                    <div class="form-group">

                        <label>
                            Amount
                        </label>

                        <input type="text"
                               name="amount"
                               class="form-control"
                               placeholder="Enter amount"
                               required>

                    </div>


                    <!-- Total Seats -->

                    <div class="form-group">

                        <label>
                            Total Seats
                        </label>

                        <input type="text"
                               name="total_seats"
                               class="form-control"
                               placeholder="Enter total seats"
                               required>

                    </div>


                    <!-- Date -->

                    <div class="form-group">

                        <label>
                            Date
                        </label>

                        <input type="date"
                               name="date"
                               class="form-control"
                               required>

                    </div>


                    <!-- Time -->

                    <div class="form-group">

                        <label>
                            Time
                        </label>

                        <input type="time"
                               name="time"
                               class="form-control"
                               required>

                    </div>


                    <!-- Pickup Locations -->

                    <div class="form-group">

                        <label>
                            Pickup Locations
                        </label>

                        <input type="text"
                               name="pickuplocations"
                               class="form-control"
                               placeholder="Enter pickup locations"
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