@extends('layouts.mainlayout')

@section('content')

<style>

/* =========================================
   CUSTOMER TABLE - SAME AS BLOG
========================================= */

.customer-table-wrapper {
    width: 100%;
    background: #fff;
    border: 1px solid #e7ebf1;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(25, 35, 55, .04);
}

.customer-table {
    width: 100%;
    margin: 0;
    border: 0 !important;
}

.customer-table thead {
    background: #f7f8fb;
}

.customer-table thead th {
    padding: 14px 16px;
    border: 0 !important;
    border-bottom: 1px solid #e8ebf0 !important;

    color: #697281;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .35px;
    white-space: nowrap;
}

.customer-table tbody td {
    padding: 13px 16px;
    border: 0 !important;
    border-bottom: 1px solid #f0f2f5 !important;

    vertical-align: middle;
    color: #394150;
    font-size: 12px;
}

.customer-table tbody tr:last-child td {
    border-bottom: 0 !important;
}

.customer-table tbody tr {
    transition: background .2s ease;
}

.customer-table tbody tr:hover {
    background: #fafbff;
}


/* =========================================
   CUSTOMER ID
========================================= */

.customer-id {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-width: 29px;
    height: 27px;
    padding: 0 7px;

    border-radius: 7px;

    background: #f1f4f8;
    color: #667080;

    font-size: 10px;
    font-weight: 600;
}


/* =========================================
   CUSTOMER NAME
========================================= */

.customer-name-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.customer-avatar {
    width: 35px;
    height: 35px;
    min-width: 35px;

    border-radius: 9px;

    background: #eef4ff;
    color: #3867e8;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 12px;
}

.customer-name-cell strong {
    display: block;

    color: #2d3542;
    font-size: 12px;
    font-weight: 600;
}

.customer-name-cell small {
    display: block;

    margin-top: 2px;

    color: #9ba3b0;
    font-size: 9px;
}


/* =========================================
   CUSTOMER PHONE
========================================= */

.customer-phone {
    color: #697281;
    font-size: 11px;
    font-weight: 500;
}


/* =========================================
   CUSTOMER EMAIL
========================================= */

.customer-email {
    color: #697281;
    font-size: 11px;
}


/* =========================================
   CUSTOMER USER ID
========================================= */

.customer-userid {
    display: inline-flex;

    padding: 6px 10px;

    border-radius: 7px;

    background: #f1f4f8;
    color: #667080;

    font-size: 10px;
    font-weight: 600;
}


/* =========================================
   EMPTY
========================================= */

.customer-empty {
    padding: 50px 20px;
    text-align: center;
    color: #929aaa;
    font-size: 13px;
}

.customer-empty i {
    display: block;
    margin-bottom: 10px;
    font-size: 28px;
}


/* =========================================
   MOBILE
========================================= */

@media(max-width:768px) {

    .customer-table {
        min-width: 750px;
    }

}

</style>


<div class="content-wrapper">

    <!-- Content Header -->
    <section class="content-header">

        <div class="container-fluid">

            <div class="row mb-2">

                <div class="col-sm-6">

                    <h1>Customers</h1>

                </div>

                <div class="col-sm-6">

                    <ol class="breadcrumb float-sm-right">

                        <li class="breadcrumb-item">
                            <a href="#">Home</a>
                        </li>

                        <li class="breadcrumb-item active">
                            Customers
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


            <!-- CUSTOMER CARD -->

            <div class="card">

                <div class="card-header">

                    <h3 class="card-title">
                        Customer List
                    </h3>

                </div>


                <div class="card-body">

                    <div class="table-responsive">

                        <div class="customer-table-wrapper">

                            <table class="table customer-table">

                                <thead>

                                    <tr>

                                        <th width="70">
                                            #
                                        </th>

                                        <th>
                                            Customer
                                        </th>

                                        <th>
                                            Phone Number
                                        </th>

                                        <th>
                                            Email
                                        </th>

                                        <th>
                                            User ID
                                        </th>

                                    </tr>

                                </thead>


                                <tbody>

                                    @forelse($customers as $customer)

                                        <tr>

                                            <!-- ID -->

                                            <td>

                                                <span class="customer-id">
                                                    #{{ $loop->iteration }}
                                                </span>

                                            </td>


                                            <!-- NAME -->

                                            <td>

                                                <div class="customer-name-cell">

                                                    <div class="customer-avatar">

                                                        <i class="fas fa-user"></i>

                                                    </div>

                                                    <div>

                                                        <strong>
                                                            {{ $customer->name }}
                                                        </strong>

                                                        <small>
                                                            Customer
                                                        </small>

                                                    </div>

                                                </div>

                                            </td>


                                            <!-- PHONE -->

                                            <td>

                                                <span class="customer-phone">

                                                    <i class="fas fa-phone-alt mr-1"></i>

                                                    {{ $customer->phonenumber }}

                                                </span>

                                            </td>


                                            <!-- EMAIL -->

                                            <td>

                                                <span class="customer-email">

                                                    <i class="fas fa-envelope mr-1"></i>

                                                    {{ $customer->mail }}

                                                </span>

                                            </td>


                                            <!-- USER ID -->

                                            <td>

                                                <span class="customer-userid">

                                                    {{ $customer->userid }}

                                                </span>

                                            </td>

                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="5">

                                                <div class="customer-empty">

                                                    <i class="fas fa-users"></i>

                                                    No customers found.

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

        </div>

    </section>

</div>

@endsection