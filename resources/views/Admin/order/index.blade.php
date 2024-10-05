@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'order';
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

    .sm:justify-between div p {
        display: none;
    }

    .btn-label-green {
        color: #01652f;
        border-color: rgba(0, 0, 0, 0);
        background: #01652f42;
    }

    .btn-label-green:hover {
        background: #01652f;
        color: #fff;
    }

    .btn-label-danger {
        color: #ff3e1d;
        border-color: rgba(0, 0, 0, 0);
        background: #ffe0db;
    }

    .btn-label-danger:hover {
        border-color: rgba(0, 0, 0, 0) !important;
        background: #e6381a !important;
        color: #fff !important;
        box-shadow: 0 0.125rem 0.25rem 0 rgba(255, 62, 29, .4) !important;
        transform: translateY(-1px) !important;
    }
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold"><span class="text-muted fw-light">Dashboard /</span>Orders</h4>
            </div>
        </div>
        <!------------- Success Message ----------------->
        <!-- Borderless Table -->
        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr no.</th>
                            <th>Order Id</th>
                            <th>Customer</th>
                            <th>Total Quantity</th>
                            <th>Total Amount</th>
                            <th>Order Status</th>
                            <th>Payment Status</th>
                            <th>Order Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['order'] as $key=>$item)
                        <input type="hidden" id="user_id" value="{{$item->user_id}}">
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->order_id ?? '--'}}</td>
                            <td>{{$item->user_add->first_name ?? '--'}} {{$item->user_add->last_name ?? '--'}}</td>
                            <td>{{$item->totalQty ?? '--'}}</td>
                            <td>{{$item->grand_total ?? '--'}}</td>
                            @if(Auth::guard('user')->user()->role == 'admin' || Auth::guard('user')->user()->role == 'datamanager' || Auth::guard('user')->user()->role == 'warehousemanager')
                            <td>
                                <select name="" id="" class="form-select form-control order_status" data-id="{{$item->id}}">
                                    <option value="" selected disabled>Select</option>
                                    @if(Auth::guard('user')->user()->role == 'admin' || Auth::guard('user')->user()->role == 'warehousemanager' || Auth::guard('user')->user()->role == 'datamanager')
                                        @if($item->order_status != '1')
                                            <option value="0" {{$item->order_status == '0' ? 'selected' : ''}}>Pending</option>
                                        @endif
                                        <option value="1" {{$item->order_status == '1' ? 'selected' : ''}}>Confirmed</option>
                                        <option value="1" {{$item->order_status == '3' ? 'selected' : ''}}>Delivered</option>
                                    @endif
                                    <option value="2" {{$item->order_status == '2' ? 'selected' : ''}}>Cancel</option>
                                </select>
                            </td>
                            @else
                            <td>
                                @switch($item->order_status)
                                    @case('0')
                                        Pending
                                        @break
                                    @case('1')
                                        Confirmed
                                        @break
                                    @case('2')
                                        Cancel
                                        @break
                                    @case('3')
                                        Delivered
                                        @break
                                @endswitch
                            </td>  
                            @endif
                            <td>
                                @switch($item->payment_status)
                                    @case('0')
                                        <span class="badge bg-danger">Failure</span>
                                        @break
                                    @case('1')
                                        <span class="badge bg-success">Success</span>
                                        @break
                                @endswitch
                            </td> 
                            <td>{{$item->created_at->toDateString() ?? '--'}}</td>
                            <td>
                                <div class="d-flex">
                                    <a href="{{route('order_view',['id'=>$item->id])}}" class="btn btn-label-danger delete-order">View</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Data Not Found!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $data['order']->links('Admin.pagination')}}
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
@include('Admin.Modal.modal')
<script>
    $(document).ready(function() {
        $('.order_status').change(function() {
            var selectedStatus = $(this).val();
            var id = $(this).data('id');

            var _token = '{{ csrf_token() }}';
            $.ajax({
                url: "{{ route('order_status') }}",
                type: "POST",
                data: {
                    status: selectedStatus,
                    id: id
                },
                dataType: "json",
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                success: function(resp) {
                    console.log(resp.message);
                    if (resp.status == true) {
                        $('.alert-success_msg').removeClass('d-none');
                        $('.alert-success_msg').addClass('alert-success');
                        $('.alert-success_msg').html(resp.message);
                        setTimeout(() => {
                            window.location.reload();
                        }, 3000);
                        // Handle success if needed
                    } else {
                        // Handle failure if needed
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors if necessary
                }
            });
        });
    });
</script>
@endsection