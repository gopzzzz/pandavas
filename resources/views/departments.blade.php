@extends('layouts.mainlayout')

@section('content')

<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">
                    <h1>Departments</h1>
                </div>

                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Departments
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
                        Departments List
                    </h3>


                    <!-- ADD BUTTON -->
                    <button type="button"
                            class="btn btn-primary float-right"
                            data-toggle="modal"
                            data-target="#addDepartmentModal">

                        <i class="fas fa-plus"></i>
                        Add Department

                    </button>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th>ID</th>
                                    <th>Department Name</th>
                                    <th>Action</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($departments as $department)

                                    <tr>

                                        <td>
                                            {{ $department->id }}
                                        </td>

                                        <td>
                                            {{ $department->departmentname }}
                                        </td>

                                        <td>

                                            <!-- EDIT BUTTON -->
                                            <button type="button"
                                                    class="btn btn-primary btn-sm"
                                                    data-toggle="modal"
                                                    data-target="#editDepartmentModal{{ $department->id }}">

                                                <i class="fas fa-edit"></i>
                                                Edit

                                            </button>

                                        </td>

                                    </tr>


                                    <!-- EDIT MODAL -->

                                    <div class="modal fade"
                                         id="editDepartmentModal{{ $department->id }}">

                                        <div class="modal-dialog">

                                            <div class="modal-content">


                                                <div class="modal-header">

                                                    <h4 class="modal-title">
                                                        Edit Department
                                                    </h4>

                                                    <button type="button"
                                                            class="close"
                                                            data-dismiss="modal">

                                                        <span>&times;</span>

                                                    </button>

                                                </div>


                                                <form method="POST"
                                                      action="{{ route('departments.update', $department->id) }}">

                                                    @csrf
                                                    @method('PUT')


                                                    <div class="modal-body">

                                                        <div class="form-group">

                                                            <label>
                                                                Department Name
                                                            </label>

                                                            <input type="text"
                                                                   name="departmentname"
                                                                   class="form-control"
                                                                   value="{{ $department->departmentname }}"
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

                                        <td colspan="3"
                                            class="text-center">

                                            No departments found.

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
<!-- ADD DEPARTMENT MODAL -->
<!-- ================================================= -->

<div class="modal fade"
     id="addDepartmentModal">

    <div class="modal-dialog">

        <div class="modal-content">


            <div class="modal-header">

                <h4 class="modal-title">
                    Add Department
                </h4>

                <button type="button"
                        class="close"
                        data-dismiss="modal">

                    <span>&times;</span>

                </button>

            </div>


            <form method="POST"
                  action="{{ route('departments.store') }}">

                @csrf


                <div class="modal-body">

                    <div class="form-group">

                        <label>
                            Department Name
                        </label>

                        <input type="text"
                               name="departmentname"
                               class="form-control"
                               placeholder="Enter department name"
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
                            class="btn btn-success">

                        Save

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection