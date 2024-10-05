@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'video_consultent';
@endphp
<style>
    .inline-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .d-flex nav {
        display: block !important;
    }

    .w-5 {
        width: 23px;
        height: 23px;
    }

    div nav .justify-between {
        display: none;
    }
</style>
<div class="content-wrapper" style="height: 100%;">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>
                    Video Consultent Booking List</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <form class="d-flex mb-2" role="search">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
        @if(Session::has('success'))
        <p class="alert alert-danger">{{Session::get('success')}}</p>
        @endif
        <p class="alert alert-success flash_msg d-none" id="">Booking Confirmed Successfully!</p>
        <!-- Borderless Table -->
        <div class="card p-2" style="height:78%;">
            <div class="table-responsive text-nowrap" style="height:100%">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>
                            <th>Phone No.</th>
                            <th>Disease</th>
                            <th>Call Type</th>
                            <th>Payment Status</th>
                            <th>Booking Confirmation</th>
                            <th class="text-center">action</th>
                        </tr>
                        @foreach ($order_data as $key => $item)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $item->user_id->name }}</td>
                            <td>{{ $item->user_id->phone ?? '--'}}</td>
                            <td>{{$item->disease_id->name ?? '--'}}</td>
                            <td>{{$item->call_type}}</td>
                            <td>{{ $item->payment_status }}</td>
                            <td>
                                <select class="form-select booking_status" data-id="{{$item->id}}">
                                    <option value="" selected disabled>pending</option>
                                    <option value="1" {{$item->booking_status == '1' ? 'selected' : ''}}>Accept</option>
                                    <option value="0" {{$item->booking_status == '2' ? 'selected' : ''}}>Reject</option>
                                </select>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('video_cons_view', ['id'=>$item->id])}}">
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

            <div class="d-flex justify-content-center">
                {!! $order_data->links() !!}
            </div>
        </div>
        <!-------- Reject Modal---------->
        <div class="modal fade" id="reject_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel2">Reject Booking Reason</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('order_booking')}}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                            @csrf
                            <input type="hidden" name="order_status" id="order_status">
                            <input type="hidden" name="order_id" id="order_id">
                            <div class="col-md-12 mt-3">
                                <textarea class="form-control reject_reason" name="reject_reason" id="" cols="30" rows="5" placeholder="Enter Reject Reason"></textarea>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-------- Reject Modal---------->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                $(".booking_status").change(function() {
                    var selectedValue = $(this).val();
                    var id = $(this).data("id");
                    console.log(id);
                    if (selectedValue == '0') {
                        $('#order_status').val(selectedValue);
                        $('#order_id').val(id);
                        $('#reject_modal').modal('show');
                    }
                    if (selectedValue == '1') {
                        axios.post('{{route("order_booking")}}', {
                                order_status: selectedValue,
                                order_id: id,
                            })
                            .then(function(response) {
                                console.log(response);
                                $('.flash_msg').removeClass('d-none');
                                setTimeout(function() {
                                    window.location.reload();
                                }, 2000);
                            })
                            .catch(function(error) {
                                console.log(error);
                            });
                    }
                });
            });
        </script>
        @endsection