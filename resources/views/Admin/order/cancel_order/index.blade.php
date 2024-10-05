@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'cancel_order';
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Users</h4>
            </div>
        </div>
    {{-- @dd($data); --}}
        <!------------- Success Message ----------------->
        <p class="alert alert-success_msg"></p>
        <!-- Borderless Table -->
        <div class="card p-2">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr no.</th>
                            <th>Order Id</th>
                            <th>Customer</th>
                            <th>Image</th>
                            <th class="text-nowrap">Product Name</th>
                            <th class="text-nowrap">SKU Code</th>
                            <th class="text-nowrap">Artical No</th>
                            <th>Total Quantity</th>
                            <th>Total Amount</th>
                            <th class="text-nowrap">Address</th>
                            <th>Order Status</th>
                            <th>Order Date</th>
                            <th>Refund Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['order'] as $key=>$item)
                        <input type="hidden" id="user_id" value="{{$item->user_id}}">
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->order_id ?? '--'}}</td>
                            <td>{{$item->user->name ?? '--'}}</td>
                            <td><img src="{{$item->product->image}}" style="height:100px;"></td>
                            <td>{{$item->product->name ?? '--'}}</td>
                            <td>{{$item->product->sku_code ?? '--'}}</td>
                            <td>{{$item->product->artical_no ?? '--'}}</td>
                            <td>{{$item->totalQty ?? '--'}}</td>
                            <td>{{$item->grand_total ?? '--'}}</td>
                            <td>--</td>
                            <td>Cancel</td>
                            <td>{{$item->created_at->toDateString() ?? '--'}}</td>
                            <td>Not Done</td>
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