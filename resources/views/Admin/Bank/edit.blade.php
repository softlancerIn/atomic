@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'bank';
@endphp
<style>
    .form-control:focus,
    .form-select:focus {
        border-color: #696cff;
        box-shadow: none;
    }

    .jagjivan-form {
        height: 38px;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        cursor: pointer;
    }

    .bg-none {
        background-color: transparent !important;
    }

    .p-6 {
        padding: 6px 12px;
    }

    .form-control.bg-none:focus {
        border-bottom: 1px solid;
        border-color: none !important;
        box-shadow: none;
    }

    .rotate-45 {
        transform: rotate(45deg);
    }

</style>
</head>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Bank /Add </h4>
                </div>
                <div class="col-6 text-end"><a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary ">Go Back</button></a></div>
            </div>


            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif


            <div class="card col-12 col-md-1 col-lg-12">
                <section>
                    <div class="container mt-4 mb-4">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="bg-white">
                                    <form class="row g-3" method="post" action="{{ route('bank_list') }}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$data['bankData']->id}}">
                                        <!---------- Row------------------->
                                        <div class="col-md-12 col-lg-6">
                                            <label>Company</label>
                                            @if(Auth::guard('user')->user()->role == 'warehousemanager')
                                            <select name="company_id" id="" class="form-select form-control">
                                                <option value="{{$data['company']->id}}" selected disabled>{{$data['company']->name}}</option>
                                            </select>
                                            @else
                                            <select name="company_id" id="" class="form-select form-control">
                                                <option value="" selected disabled>select company</option>
                                                @foreach($data['company'] as $key => $value)
                                                <option value="{{$value->id}}" {{$data['bankData']->company_id == $value->id ? 'selected' : ''}}>{{$value->name}}</option>
                                                @endforeach
                                            </select>
                                            @endif
                                        </div>

                                        <div class="col-md-12 col-lg-6">
                                            <label>Payment Type</label>
                                            <select name="payment_type" id="payment_type" class="form-select form-control">
                                                <option value="" selected disabled>select payment type</option>
                                                <option value="1" {{$data['bankData']->payment_type == '1' ? 'selected' : ''}}>UPI</option>
                                                <option value="2" {{$data['bankData']->payment_type == '2' ? 'selected' : ''}}>RTGS</option>
                                                <option value="3" {{$data['bankData']->payment_type == '3' ? 'selected' : ''}}>NEFT</option>
                                                <option value="4" {{$data['bankData']->payment_type == '4' ? 'selected' : ''}}>IMPS</option>
                                            </select>


                                        </div>
                                        <!---------- Row------------------->

                                        <!---------- Row------------------->
                                        <div class="col-md-6 col-lg-4">
                                            <label>Bank Name</label>
                                            <input type="text" class="form-control" name="bank_name" id="bank_name" placeholder="Bank Name" aria-label="Owner Name" value="{{$data['bankData']->bank_name}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Branch Name</label>
                                            <input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name" aria-label="Owner Name" value="{{$data['bankData']->branch_name}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Branch Code</label>
                                            <input type="text" class="form-control" name="branch_code" id="branch_code" placeholder="Branch Code" aria-label="Owner Name" value="{{$data['bankData']->branch_code}}">
                                        </div>
                                        <!---------- Row------------------->

                                        <!---------- Row------------------->
                                        <div class="col-md-6 col-lg-4">
                                            <label>Account Number</label>
                                            <input type="text" class="form-control" name="account_no" id="account_no" placeholder="Account Number" aria-label="Owner Name" value="{{$data['bankData']->account_no}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Account Holder Name</label>
                                            <input type="text" class="form-control" name="account_holderName" id="account_holderName" placeholder="Account Holder Name" aria-label="Owner Name" value="{{$data['bankData']->account_holderName}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>IFSC Code</label>
                                            <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" placeholder="IFSC Code" aria-label="Owner Name" value="{{$data['bankData']->ifsc_code}}">
                                        </div>
                                        <!---------- Row------------------->

                                        <!---------- Row------------------->
                                        <div class="col-md-6 col-lg-4">
                                            <label>Aadhar Number</label>
                                            <input type="text" class="form-control" name="aadhar_no" id="aadhar_no" placeholder="Aadhar Number" aria-label="Owner Name" value="{{$data['bankData']->aadhar_no}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Pincode</label>
                                            <input type="text" class="form-control" name="pincode" id="pincode" placeholder="Pincode" aria-label="Owner Name" value="{{$data['bankData']->pincode}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>City</label>
                                            <input type="text" class="form-control" name="city" id="city" placeholder="City" aria-label="Owner Name" value="{{$data['bankData']->city}}">
                                        </div>
                                        <!---------- Row------------------->

                                        <!---------- Row------------------->
                                        <div class="col-md-6 col-lg-4">
                                            <label>State</label>
                                            <input type="text" class="form-control" name="state" id="state" placeholder="State" aria-label="Owner Name" value="{{$data['bankData']->state}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Country</label>
                                            <input type="text" class="form-control" name="country" id="country" placeholder="Country" aria-label="Owner Name" value="{{$data['bankData']->country}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Bank Address</label>
                                            <input type="text" class="form-control" name="bank_address" id="bank_address" placeholder="Bank Address" aria-label="Owner Name" value="{{$data['bankData']->bank_address}}">
                                        </div>
                                        <!---------- Row------------------->

                                        <!---------- Row------------------->
                                        <div class="col-md-6 col-lg-4">
                                            <label>Mobile</label>
                                            <input type="text" class="form-control" name="mobile_no" id="mobile_no" placeholder="Mobile No" aria-label="Owner Name" value="{{$data['bankData']->mobile_no}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Email</label>
                                            <input type="email" class="form-control" name="email" id="email" placeholder="email" aria-label="Owner Name" value="{{$data['bankData']->email}}">
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                            <label>Account Limit</label>
                                            <input type="text" class="form-control" name="account_limit" id="account_limit" placeholder="Account limit" aria-label="Owner Name" value="{{$data['bankData']->account_limit}}">
                                        </div>
                                        <!---------- Row------------------->

                                        <!---------- Row------------------->

                                        <div class="col-md-6 col-lg-4">
                                            <label>Status</label>
                                            <select class="form-select form-control" name="status">
                                                <option value="" disabled selected>Select Status Type</option>
                                                <option value="1" {{$data['bankData']->status == '1' ? 'selected' : ''}}>Active</option>
                                                <option value="0" {{$data['bankData']->status == '0' ? 'selected' : ''}}>Inactive</option>
                                            </select>
                                        </div>
                                        <!---------- Row------------------->
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">save</button>
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
    {{-- <script>
function set_user_using_category(banner_type,select_agent){
    var banner_name = $(banner_type).val();
    const url = "{{ route('banner-dropdown-data') }}";
    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': '{{ csrf_token() }}'
    }
    });
    $.ajax({
    url:url,
    type: "POST",
    data: {
    banner_name : banner_name,
    },
    dataType: "json",
    success: function(result)
    {
    console.log(result);
    let html_content= '<option selected disabled>Select Shop</option>';
    jQuery.each(result, function(key,value){
    html_content += '<option value="'+ value.id +'">'+ value.shop_name +'</option>';
    });
    $(select_agent).html(html_content);
    }
    });
    }

    $('#banner_type').change( function(){
    set_user_using_category('#banner_type','#select_agent');
    });
    </script> --}}
    @endsection
