@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'warehouse';
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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / Warehouse /</span> Add Warehouse</h4>
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
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="bg-white">
                                    <form class="row g-3" method="post" action="{{ route('wareHouse_add') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-md-6 col-lg-6 col-sm-12">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" aria-label="Enter Name" value="{{old('name')}}" required>
                                        </div>


                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter Code" value="{{old('code')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="text" name="address" class="form-control" id="address" placeholder="Enter Address" value="{{old('address')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="text" name="city" class="form-control" id="city" placeholder="Enter City" value="{{old('city')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="text" name="state" class="form-control" id="state" placeholder="Enter State" value="{{old('state')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="text" name="zipcode" class="form-control" id="zipcode" placeholder="Enter Zip Code" value="{{old('zipcode')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12">
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
    @endsection