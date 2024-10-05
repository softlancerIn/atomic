@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'discount_coupon';
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
    .p-6{
        padding: 6px 12px;
    }
    .form-control.bg-none:focus {
        border-bottom: 1px solid;
        border-color: none !important;
        box-shadow: none;
    }
    .rotate-45{
        transform: rotate(45deg);
    }
</style> 
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6"><h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Coupon /Add coupon</h4></div>
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
        <div class="card">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{route('coupon_add')}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" name="name" placeholder="Enter Name" aria-label="Coupon Name" value="{{old('name')}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="description">Description</label>
                                        <input type="text" class="form-control" name="description" placeholder="Enter Description" value="{{old('description')}}"
                                            aria-label="Mobile Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="percentage">Percentage</label>
                                        <input type="text" class="form-control" name="percentage" placeholder="Enter Description" value="{{old('percentage')}}"
                                            aria-label="Mobile Number">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="max_amount">Max Amount</label>
                                        <input type="text" class="form-control" name="max_amount" placeholder="Enter Max Amount" value="{{old('max_amount')}}"
                                            aria-label="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validate_from">Min Amount</label>
                                        <input type="text" class="form-control" name="min_amount" placeholder="Enter Min Amount" value="{{old('min_amount')}}"
                                            aria-label="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validate_from">Total Discount</label>
                                        <input type="text" class="form-control" name="total_discount" placeholder="Enter Total Discount" value="{{old('total_discount')}}"
                                            aria-label="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="validate_from">Validate From</label>
                                        <input type="date" class="form-control" name="validate_from" id="validate_from" placeholder="Validate From" value="{{old('validate_from')}}"
                                            aria-label="">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="valid_to">Valid To</label>
                                        <input type="date" class="form-control" name="valid_to" placeholder="Valid To" value="{{old('valid_to')}}"
                                            aria-label="">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Save</button>
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
@endsection