@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'pharmacy_list';
@endphp

<style>
    .forms-parent {
        padding: 15px;
        margin-top: 15px;
        background-color: #fff;
    }

    .prec-img {
        width: 50%;
        height: 50px;
    }
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{route('pharmacy_order_update')}}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="update_id" name="update_id" value="{{$data['orderdetails']->id}}">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Name</label>
                                        <div class="col-sm-8">
                                            <input type="text" value="{{$data['user_details']->name}}" class="form-control" id="inputEmail3" name="" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Address</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="{{$data['address']->address}}" id="inputEmail3" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Mobile No.</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="text" class="form-control" value="{{$data['user_details']->phone}}" id="inputEmail3" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Payment Status</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="text" class="form-control" value="{{$data['orderdetails']->payment_status}}" id="inputEmail3" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Payment Mode</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="text" class="form-control" value="{{$data['orderdetails']->payment_mode}}" id="inputEmail3" readonly>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Order Status</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <select class="form-select" aria-label="Default select example" id="order_status" name="order_status">
                                                <option selected>Open this select menu</option>
                                                <option value="0" {{$data['orderdetails']->order_status == '0' ? 'selected':'' }}>Pending</option>
                                                <option value="1" {{$data['orderdetails']->order_status == '1' ? 'selected':'' }}>Confirmed</option>
                                                <option value="2" {{$data['orderdetails']->order_status == '2' ? 'selected':'' }}>Reject</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3 d-none" id="reject_reason">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Order Reject Reason</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <textarea class="form-control" name="reject_reason"></textarea>
                                            {{-- <input type="datetime-local" value="{{$data['user_details']->created_at}}" class="form-control" id="inputEmail3" readonly> --}}
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Date</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="datetime-local" value="{{$data['user_details']->created_at}}" class="form-control" id="inputEmail3" readonly>
                                        </div>
                                    </div>


                                    {{-- @dd(count(json_decode($data['orderdetails']->medicine_data))) --}}
                                    {{-- @dd(json_decode($data['orderdetails']->medicine_data)); --}}
                                    <span class="addmore_div"></span>
                                    <div class="row mb-3 d-none">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Coupon</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="text" value="{{$data['user_details']->coupon_id}}" class="form-control" id="inputEmail3" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3 ">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Total Item</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="text" value="{{$data['orderdetails']->total_item}}" class="form-control" id="inputEmail3" name="total_item">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Delivery Charges</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="text" value="{{$data['orderdetails']->delivery_charge}}" class="form-control" id="inputEmail3" name="delivery_charge">
                                        </div>
                                    </div>
                                    <div class="row mb-3 ">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Upload Bill</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <input type="file" class="form-control" id="inputEmail3" name="upload_bill">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Prescription</label>
                                        @foreach($data['item'] as $item)
                                        <div class="col-sm-2 d-flex">
                                            <div class="border border-dark prec-img">
                                                <img src="{{'https://jagjiwan.teknikoglobal.in/api/public/uploads/prescriptions/'.$item->doc_path}}" height="50" width="100%">
                                            </div>
                                            <a href="{{'https://jagjiwan.teknikoglobal.in/api/public/uploads/prescriptions/'.$item->doc_path}}" download><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                                    <path d="m12 16 4-5h-3V4h-2v7H8z"></path>
                                                    <path d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z"></path>
                                                </svg></a>
                                            <a href="{{'https://jagjiwan.teknikoglobal.in/api/public/uploads/prescriptions/'.$item->doc_path}}" class="ms-3" target="_blank" class="ms-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                                    <path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path>
                                                    <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path>
                                                </svg></a>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<script>
    //============= Add more field fuction =========//
    var i = 2;
    $('#add_more').on('click', function(e) {
        //count_item(i);
        e.preventDefault();
        $('.addmore_div').append(`<div class="row mb-3" id="addmore_row${i}">
                        <label for="inputEmail3" class="col-sm-4 col-form-label invisible">Available Prescription Item</label>
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-12 col-form-label">Name</label>
                            <input type="text" class="form-control" name="medicine_name[]">
                        </div>
                        <div class="col-sm-3">
                            <label for="inputEmail3" class="col-sm-12 col-form-label rate" onkeyup="amout()">RAte</label>
                            <input type="text" class="form-control price" name="rate[]">
                        </div>
                        <div class="col-sm-2">
                            <label for="inputEmail3" class="col-sm-12 col-form-label invisible">RAte</label>
                            <div class="btn btn-danger" onclick="remove(${i})" id="remove${i}">Close</div>
                        </div> 
                    </div>`);
        i++;
    });
    //============= Add more field fuction =========//

    // =========== remove Add more field ========//
    function remove(i) {
        //var item = $('#availale_item').val();
        //var remain = Number(item)-1;
        //console.log(remain);
        //$('#availale_item').val(remain)
        $('#addmore_row' + i).remove();
    }
    // =========== remove Add more field ========//

    //========== Count total Item =========//
    // function count_item(i){
    //   $('#availale_item').val(i)
    //}
    //========== Count total Item =========//

    //========= reject Order =============//
    $('#order_status').on("change", function() {
        var value = $(this).val();
        if (value == '3') {
            $('#reject_reason').removeClass('d-none');
        } else {

            $('#reject_reason').addClass('d-none');
        }
        console.log(value);
    });
    //========= reject Order =============//

    //========= total amount count ==========//

    function calculateSubtotal(item) {
        const price = parseFloat($(item).find('.price').val());
        const subtotal = quantity * price;
        $(item).find('.subtotal').text('Subtotal: $' + subtotal.toFixed(2));
        return subtotal;
    }

    function calculateTotal() {
        let total = 0;
        $('.rate').each(function() {
            total += calculateSubtotal(this);
        });
        $('#total_amout').val(total.toFixed(2));
    }
    $('.rate').on('input', function() {
        calculateTotal();
    });
    //========= total amount count ==========//
</script>

@endsection