@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'crop';
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
</head>

<body>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6"><h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Crops /Edit Crop</h4></div>
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
                                <form class="row g-3" action="{{route('crop_create')}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data['crop_data']->id}}">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" placeholder="Crop Name" aria-label="Owner Name" value="{{$data['crop_data']->name}}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="image"
                                            aria-label="Mobile Number">
                                    </div>
                                    <div class="col-md-6">
                                        <textarea name="introduction" class="form-control" placeholder="Introduction">{{$data['crop_data']->introduction}}</textarea>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <textarea name="climate" class="form-control" placeholder="Climate">{{$data['crop_data']->climate}}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea name="soil" class="form-control" placeholder="Soil">{{$data['crop_data']->soil}}</textarea>
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