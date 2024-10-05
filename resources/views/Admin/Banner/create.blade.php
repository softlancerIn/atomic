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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Banner /Add Banner</h4>
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
                                    <form class="row g-3" method="post" action="{{ route('addbanner') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-12 col-lg-6">
                                            <label>Select Banner Name</label>
                                            <input type="text" class="form-control" name="banner_name" id="banner_name" placeholder="Banner Name" aria-label="Owner Name" value="{{old('banner_name')}}">
                                        </div>
                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <label>Select Banner Type</label>
                                            <select class="form-select" id="banner_type" name="banner_type" aria-label="Default select example">
                                                <option value="" disabled selected>Select Type</option>
                                                <option value="banner1">Banner 1</option>
                                                <option value="banner2">Banner 2</option>
                                            </select>
                                        </div>

                                        <div class="col-md-12 mt-3 col-lg-6">
                                            <label>Banner click url</label>
                                            <input type="text" name="link" class="form-control" id="web_image" placeholder="Enter Url">
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
                                        <label>Description</label>
                                            <textarea name="description" id="banner_desc" cols="30" rows="2" class="form-control" placeholder="Description">{{old('banner_desc')}}</textarea>
                                        </div>
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