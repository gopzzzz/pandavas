@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Staff Registrations</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Staff Registrations
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
                        Staff Registration List
                    </h3>


                    <!-- ADD BUTTON -->
                    <button type="button"
                            class="btn btn-primary float-right"
                            data-toggle="modal"
                            data-target="#addStaffModal">

                        <i class="fas fa-plus"></i>
                        Add Staff

                    </button>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Staff Name</th>
                                    <th>Department</th>
                                    <th>Email</th>
                                    <th>DOB</th>
                                    <th>Address</th>
                                    <th>Marriage Status</th>
                                    <th>Adhar Card</th>
                                    <th>Action</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($staffregistrations as $staff)

                                    <tr>

                                        <td>
                                            {{ $staff->id }}
                                        </td>

                                        <td>
                                            {{ $staff->staff_name }}
                                        </td>

                                        <td>

                                            @php
                                                $department = $departments
                                                    ->where('id', $staff->department_id)
                                                    ->first();
                                            @endphp

                                            {{ $department ? $department->departmentname : $staff->department_id }}

                                        </td>

                                        <td>
                                            {{ $staff->email }}
                                        </td>

                                        <td>
                                            {{ $staff->dob }}
                                        </td>

                                        <td>
                                            {{ $staff->address }}
                                        </td>

                                        <td>
                                            {{ $staff->marriage_status }}
                                        </td>

                                        <td>

                                            <a href="{{ asset('uploads/adharcard/' . $staff->adharcard) }}"
                                               target="_blank"
                                               class="btn btn-info btn-sm">

                                                <i class="fas fa-file"></i>
                                                View

                                            </a>

                                        </td>

                                        <td>

                                            <!-- EDIT BUTTON -->
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editStaffModal{{ $staff->id }}">

                                                <i class="fas fa-edit"></i>
                                                Edit

                                            </button>

                                        </td>

                                    </tr>


                                    <!-- ========================= -->
                                    <!-- EDIT MODAL -->
                                    <!-- ========================= -->

                                    <div class="modal fade"
                                         id="editStaffModal{{ $staff->id }}">

                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">


                                                <div class="modal-header">

                                                    <h4 class="modal-title">
                                                        Edit Staff Registration
                                                    </h4>

                                                    <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>


                                                <form method="POST"
                                                      enctype="multipart/form-data"
                                                      action="{{ route('staff_registrations.update', $staff->id) }}">

                                                    @csrf
                                                    @method('PUT')


                                                    <div class="modal-body">


                                                        <!-- Staff Name -->

                                                        <div class="form-group">

                                                            <label>
                                                                Staff Name
                                                            </label>

                                                            <input type="text"
                                                                   name="staff_name"
                                                                   class="form-control"
                                                                   value="{{ $staff->staff_name }}"
                                                                   required>

                                                        </div>


                                                        <!-- Department -->

                                                        <div class="form-group">

                                                            <label>
                                                                Department
                                                            </label>

                                                            <select name="department_id"
                                                                    class="form-control"
                                                                    required>

                                                                <option value="">
                                                                    Select Department
                                                                </option>

                                                                @foreach($departments as $department)

                                                                    <option value="{{ $department->id }}"
                                                                        {{ $staff->department_id == $department->id ? 'selected' : '' }}>

                                                                        {{ $department->departmentname }}

                                                                    </option>

                                                                @endforeach

                                                            </select>

                                                        </div>


                                                        <!-- Email -->

                                                        <div class="form-group">

                                                            <label>
                                                                Email
                                                            </label>

                                                            <input type="email"
                                                                   name="email"
                                                                   class="form-control"
                                                                   value="{{ $staff->email }}"
                                                                   required>

                                                        </div>


                                                        <!-- DOB -->

                                                        <div class="form-group">

                                                            <label>
                                                                Date of Birth
                                                            </label>

                                                            <input type="date"
                                                                   name="dob"
                                                                   class="form-control"
                                                                   value="{{ $staff->dob }}"
                                                                   required>

                                                        </div>


                                                        <!-- Address -->

                                                        <div class="form-group">

                                                            <label>
                                                                Address
                                                            </label>

                                                            <textarea name="address"
                                                                      class="form-control"
                                                                      rows="3"
                                                                      required>{{ $staff->address }}</textarea>

                                                        </div>


                                                        <!-- Marriage Status -->

                                                        <div class="form-group">

                                                            <label>
                                                                Marriage Status
                                                            </label>

                                                            <select name="marriage_status"
                                                                    class="form-control"
                                                                    required>

                                                                <option value="">
                                                                    Select Marriage Status
                                                                </option>

                                                                <option value="Single"
                                                                    {{ $staff->marriage_status == 'Single' ? 'selected' : '' }}>
                                                                    Single
                                                                </option>

                                                                <option value="Married"
                                                                    {{ $staff->marriage_status == 'Married' ? 'selected' : '' }}>
                                                                    Married
                                                                </option>

                                                                <option value="Divorced"
                                                                    {{ $staff->marriage_status == 'Divorced' ? 'selected' : '' }}>
                                                                    Divorced
                                                                </option>

                                                                <option value="Widowed"
                                                                    {{ $staff->marriage_status == 'Widowed' ? 'selected' : '' }}>
                                                                    Widowed
                                                                </option>

                                                            </select>

                                                        </div>


                                                        <!-- Existing Aadhaar -->

                                                        <div class="form-group">

                                                            <label>
                                                                Current Adhar Card
                                                            </label>

                                                            <br>

                                                            <a href="{{ asset('uploads/adharcard/' . $staff->adharcard) }}"
                                                               target="_blank"
                                                               class="btn btn-info btn-sm">

                                                                <i class="fas fa-file"></i>
                                                                View Current File

                                                            </a>

                                                        </div>


                                                        <!-- New Aadhaar -->

                                                        <div class="form-group">

                                                            <label>
                                                                Replace Adhar Card
                                                            </label>

                                                            <input type="file"
                                                                   name="adharcard"
                                                                   class="form-control"
                                                                   accept=".jpg,.jpeg,.png,.pdf">

                                                            <small class="text-muted">
                                                                JPG, JPEG, PNG or PDF. Maximum 10MB.
                                                            </small>

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

                                        <td colspan="9"
                                            class="text-center">

                                            No staff registrations found.

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
<!-- ADD STAFF MODAL -->
<!-- ================================================= -->

<div class="modal fade"
     id="addStaffModal">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title">
                    Add Staff Registration
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <form method="POST"
                  enctype="multipart/form-data"
                  action="{{ route('staff_registrations.store') }}">

                @csrf


                <div class="modal-body">


                    <!-- Staff Name -->

                    <div class="form-group">

                        <label>
                            Staff Name
                        </label>

                        <input type="text"
                               name="staff_name"
                               class="form-control"
                               placeholder="Enter staff name"
                               required>

                    </div>


                    <!-- Department -->

                    <div class="form-group">

                        <label>
                            Department
                        </label>

                        <select name="department_id"
                                class="form-control"
                                required>

                            <option value="">
                                Select Department
                            </option>

                            @foreach($departments as $department)

                                <option value="{{ $department->id }}">
                                    {{ $department->departmentname }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <!-- Email -->

                    <div class="form-group">

                        <label>
                            Email
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="Enter email"
                               required>

                    </div>


                    <!-- DOB -->

                    <div class="form-group">

                        <label>
                            Date of Birth
                        </label>

                        <input type="date"
                               name="dob"
                               class="form-control"
                               required>

                    </div>


                    <!-- Address -->

                    <div class="form-group">

                        <label>
                            Address
                        </label>

                        <textarea name="address"
                                  class="form-control"
                                  rows="3"
                                  placeholder="Enter address"
                                  required></textarea>

                    </div>


                    <!-- Marriage Status -->

                    <div class="form-group">

                        <label>
                            Marriage Status
                        </label>

                        <select name="marriage_status"
                                class="form-control"
                                required>

                            <option value="">
                                Select Marriage Status
                            </option>

                            <option value="Single">
                                Single
                            </option>

                            <option value="Married">
                                Married
                            </option>

                            <option value="Divorced">
                                Divorced
                            </option>

                            <option value="Widowed">
                                Widowed
                            </option>

                        </select>

                    </div>


                    <!-- Aadhaar Card -->

                    <div class="form-group">

                        <label>
                            Adhar Card
                        </label>

                        <input type="file"
                               name="adharcard"
                               class="form-control"
                               accept=".jpg,.jpeg,.png,.pdf"
                               required>

                        <small class="text-muted">
                            JPG, JPEG, PNG or PDF. Maximum 10MB.
                        </small>

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