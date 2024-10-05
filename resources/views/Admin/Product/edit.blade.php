@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'product';
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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Product /Edit Product</h4>
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
            <div class="card">
                <section>
                    <div class="container mt-4 mb-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-12">
                                <div class="bg-white">
                                    <form class="row g-3" method="post" action="{{route('product_update')}}" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$data['edit_data']->id}}">
                                        <div class="col-md-6">
                                            <label for="name">Product Name</label>
                                            <input type="text" class="form-control" name="name" id="name" placeholder="Item Name" aria-label="Item Name" value="{{$data['edit_data']->name}}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="brand_name">Brand Name</label>
                                            <select name="brand_name" id="brand_name" class="form-control form-select">
                                                <option value="" selected disabled>Select Brand</option>
                                                @foreach ($data['brand_list'] as $item)
                                                    <option value="{{$item->id}}" {{$data['edit_data']->brand_id == $item->id ? 'selected' : ''}}>{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="image">Main Image</label>
                                            <input type="file" class="form-control" name="image" id="image" placeholder="Item Image" aria-label="Item Name">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="series_name">Series Name</label>
                                            <input type="text" class="form-control" name="series_no" id="series_name" placeholder="Item Series Name" aria-label="Item Name" value="{{$data['edit_data']->series_name}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="series_name">Artical Number</label>
                                            <input type="text" class="form-control" name="artical_no" id="artical_no" placeholder="Item Series Name" aria-label="Item Name" value="{{$data['edit_data']->artical_no}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="model_no">Model Name</label>
                                            <input type="text" class="form-control" name="model_no" id="model_no" placeholder="Item Model Name" aria-label="Item Name" value="{{$data['edit_data']->model_no}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mrp">MRP</label>
                                            <input type="text" class="form-control" name="mrp" id="mrp" placeholder="Item MRP" aria-label="Item Name" value="{{$data['edit_data']->mrp}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="selling_price">Selling Price</label>
                                            <input type="text" class="form-control" name="selling_price" id="selling_price" placeholder="Item Seling Price" aria-label="Item Name" value="{{$data['edit_data']->selling_price}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tax">Tax</label>
                                            <input type="text" class="form-control" name="tax" id="tax" placeholder="Item Tax" aria-label="Item Name" value="{{$data['edit_data']->tax}}" >
                                        </div>
                                        <div class="col-md-6">
                                            <label for="min_quantity">Min Quantity</label>
                                            <input type="text" class="form-control" name="min_quantity" id="min_quantity" placeholder="Item Min Quantity" aria-label="Item Name" value="{{$data['edit_data']->min_quantity}}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="ship_time">Ship Time</label>
                                            <input type="text" class="form-control" name="ship_time" id="ship_time" placeholder="Item Shipping Time" aria-label="Item Name" value="{{$data['edit_data']->ship_time}}" >
                                        </div>
                                        <div class="col-md-12">
                                            <label for="description">Description</label>
                                            <textarea class="form-control" name="description" id="description" placeholder="Description">{{$data['edit_data']->description}}</textarea>
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
    <script>
        getSub_cat();

        function getSub_cat() {
            var selectedCat = $('#cat_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('get_subCatData')}}",
                method: "POST",
                data: {
                    selectedCat: selectedCat
                },
                success: function(data) {
                    console.log(data);
                    if (data.status == true) {
                        if (data.data != '') {

                            $.each(data.data, function(index, item) {
                                console.log(item);
                                $('#sub_cat').append($('<option>', {
                                    value: item.id, // Set the value of the option
                                    text: item.name, // Set the text of the option
                                }));
                            });
                        }
                    } else {
                        console.log(data);
                    }
                }
            });
        }

        $("#cat_id").on("change", function() {
            var selectedCat = $('#cat_id').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('get_subCatData')}}",
                method: "POST",
                data: {
                    selectedCat: selectedCat
                },
                success: function(data) {
                    console.log(data.data);
                    if (data.status == true) {
                        if (data.data != '') {
                            $('#sub_cat').removeClass('d-none');
                            $('#sub_cat').html('');
                            $.each(data.data, function(index, item) {
                                console.log(item);
                                $('#sub_cat').append($('<option>', {
                                    value: item.id, // Set the value of the option
                                    text: item.name, // Set the text of the option
                                }));
                            });
                        } else {
                            $('#sub_cat').addClass('d-none');
                        }
                    } else {
                        console.log(data);
                    }
                }
            });
        });
    </script>
    @endsection