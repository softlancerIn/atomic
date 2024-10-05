@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'pharmacy_list';
@endphp
    <div class="content-wrapper" style="height: 100%;">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> 
                    Pharmacy Order List</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-6">
                    <form class="d-flex mb-2" role="search">
                        <input class="form-control me-2" type="search" name="search" placeholder="Search"
                            aria-label="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
            @if(Session::has('success'))
            <p class="alert alert-success">{{Session::get('success')}}</p>
            @endif
            <!-- Borderless Table -->
            <div class="card p-2" style="height:78%;" >
                <div class="table-responsive text-nowrap" style="height:100%" >
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User Name</th>
                                <th>Address</th>
                                <th>Payment Status</th>
                                <th>Order Confirmation</th>
                                <th class="text-center">action</th>
                            </tr>   
                            @foreach ($pharmacy_data as $key => $item) 
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->user_data->name }}</td>
                                    <td>{{ $item->address_detail->address ?? '--'}}</td>
                                    <td>{{ $item->payment_status }}</td>
                                    <td>
                                        <select class=form-select>
                                            <option>Accept</option>
                                            <option>Reject</option>
                                            <option>Other</option>
                                        </select>
                                    </td>
                                    <td>
                                    <div class="dropdown">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="bx bx-dots-vertical-rounded"></i>
                                            </button>
                                    <div class="dropdown-menu" style="">
                                            <a class="dropdown-item" href="{{route('ph_order_view', $item->id)}}">
                                            <i class="bx bx-edit-alt me-1"></i>VIew</a>
                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ route('ph_order_delete', $item->id) }}">
                                            <i class="bx bx-trash me-1"></i>Delete</a>
                                       </div>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </thead>
                    </table>

                </div>
                <style>
                    .inline-flex{
                        display: flex;
                        justify-content: space-between;
                        align-items:center;
                    }
                    .flex{
                        display: flex;
                        justify-content: space-between;
                        align-items:center;
                    }
                    .d-flex nav{
                        display: block!important;
                    }
                    .w-5{
                        width: 23px;
                        height: 23px;
                    }
                    div nav .justify-between{
                        display: none;
                    }
                </style>
                <div class="d-flex justify-content-center">
                    {!! $pharmacy_data->links() !!}
                </div>
            </div>
        @endsection
