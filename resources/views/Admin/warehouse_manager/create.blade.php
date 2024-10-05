@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'warehouse_manager';
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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / Company Master /</span> Add </h4>
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
                                    <form class="row g-3" method="post" action="{{ route('wareHouManag_add') }}" enctype="multipart/form-data">
                                        @csrf

                                        <div class="col-md-6 col-lg-6 col-sm-12">
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" aria-label="Enter Name" value="{{old('name')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12">
                                            <input type="text" class="form-control" name="comission" id="comission" placeholder="Enter comission" aria-label="Enter Name" value="{{old('comission')}}" required>
                                        </div>

                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email" value="{{old('email')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter Password" value="{{old('password')}}" required>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-12 mt-3">
                                            <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" placeholder="Enter Confirm Password" value="{{old('confirm_password')}}" required>
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
