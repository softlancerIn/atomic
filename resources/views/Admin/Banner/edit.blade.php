@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'banner';
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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Banner /Edit Banner</h4>
                </div>
                <div class="col-6 text-end"><a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary ">Go Back</button></a></div>
            </div>
            <div class="card col-12 col-md-12 col-lg-12">
                <section>
                    <div class="container mt-4 mb-4">
                        <div class="row">
                            <div class="col-12 col-md-6 col-lg-12">
                                <div class="bg-white">
                                    <form class="row g-3" method="post" action="{{route('updatebanner') }}" enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="update_id" value="{{$data['products']->id}}">

                                        <div class="col-md-12 col-lg-6">
                                            <input type="text" class="form-control" name="sub_cat_name" value="{{$data['products']->name}}" id="banner_name" placeholder="Banner Name" aria-label="Owner Name">
                                        </div>
                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <select class="form-select" name="select_type" aria-label="Default select example">
                                                <option disabled selected>Select Type</option>
                                                <option value="banner1" {{ $data['products']->type == 'banner1' ? 'selected' : '' }}>Banner 1</option>
                                                <option value="banner2" {{ $data['products']->type == 'banner2' ? 'selected' : '' }}>Banner 2</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <label>Banner click url</label>
                                            <input type="text" name="link" class="form-control" id="web_image" placeholder="Enter Url" value="{{$data['products']->link}}">
                                        </div>

                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <label>Upload banner for web view (size : 1400*400 )</label>
                                            <input type="file" name="web_image" class="form-control" id="web_image">
                                        </div>
                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <label>Upload banner for mobile view (size : 850*315 )</label>
                                            <input type="file" name="mobile_image" class="form-control" id="mobile_image">
                                        </div>
                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <textarea name="description" id="description" cols="30" rows="2" class="form-control" placeholder="Description">{{$data['products']->description}}</textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Update</button>
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