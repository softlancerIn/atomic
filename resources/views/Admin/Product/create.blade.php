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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Product /Add Product</h4>
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
                                    <form class="row g-3" method="post" action="{{route('product_save')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Item Name" aria-label="Item Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="cat_id" id="cat_id" class="form-control form-select">
                                                <option value="" disabled selected>Select Category</option>
                                                @foreach($data['category'] as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="sub_cat" id="sub_cat" name="sub_cat" class="form-control form-select"></select>
                                        </div>

                                        <div class="col-md-6">
                                            <select class="form-select">
                                                <option value="" selected disabled>Select Brand</option>
                                                <option value="1">ABC</option>
                                                <option value="1">ABC</option>
                                            </select>
                                        </div>


                                        <!------------------- Multiple Image  Field -------------------->
                                        <div class="col-md-6" id="add_more_image_row">
                                            <div class="row" id="">
                                                <div class="col-10">
                                                    <input type="file" class="form-control" name="image" id="image" placeholder="image" required>
                                                </div>
                                                <div class="col-2 text-end">
                                                    <button type="button" class="btn btn-dark" id="add_more_image">+</button>
                                                </div>
                                            </div>

                                        </div>
                                        <!------------------- Multiple Image Field -------------------->

                                        <!------------------- Multiple Features Field -------------------->
                                        <div class="col-md-6" id="add_more_feature_row">
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" class="form-control" name="feature" id="feature" placeholder="Feature" required>
                                                </div>
                                                <div class="col-2 text-end">
                                                    <button type="button" class="btn btn-dark" id="add_more_feature">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!------------------- Multiple Features Field -------------------->
                                        <!------------------- Muliple Input for quantity, MRP, Selling Prize ----------------->
                                        <div class="col-md-12" id="add_more_price_row">
                                            <div class="row justify-content-between">
                                                <div class="col-2">
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Quantity" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="MRP" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Selling price" required>
                                                </div>
                                                <div class="col-1 text-end">
                                                    <button type="button" class="btn btn-dark" id="add_more_price">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-12 ">
                                            <div class="row justify-content-between">
                                                <div class="col-2">
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Quantity" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Unit" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit" placeholder="Unit" required>
                                                </div>
                                                <div class="col-1 text-end">
                                                    <button class="btn btn-danger">x</button>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!------------------- Muliple Input for quantity, MRP, Selling Prize ----------------->

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="delivery_time" id="delivery_time" placeholder="Delivery Time" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="delivery_time" id="delivery_time" placeholder="Delivery Time" required>
                                        </div>
                                        <!------------------------------- Description and Specification input field --------------------->
                                        <div class="col-md-6">
                                            <div id="page_effect" style="display: none">
                                                <textarea id="editor" name="editor"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <textarea class="form-control" name="safty_pricotion" id="safty_pricotion" cols="30" rows="3" placeholder="Specification"></textarea>
                                        </div>
                                        <!------------------------------- Description and Specification input field --------------------->

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
    <!-- <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
    <script>
        CKEDITOR.replace("editor", {

            uiColor: "#888888",
        });

        CKEDITOR.on("instanceReady", function(evt) {
            var instanceName = "editor";
            var editor = CKEDITOR.instances[instanceName];
            //editor.execCommand("maximize");
        });

        // $(document).ready(function() {
        //     $('#page_effect').fadeIn(8000);
        // });
    </script> -->
    <script>
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
                    console.log(data);
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

        /* ------------------------ Add more & remove image field function ---------------------*/
        $("#add_more_image").on("click", function() {
            var i = 1;
            var html = `<div class="row mt-3" id="add_more_image_row${i}">
                        <div class="col-10">
                            <input type="file" class="form-control" name="image" id="image" placeholder="image" required>
                        </div>
                        <div class="col-2 text-end">
                            <button type="button" class="btn btn-danger remove_image_row${i}" onclick="remove_img_row(${i})">x</button>
                        </div>
                    </div>`;
            $('#add_more_image_row').append(html);
            i++;
        });

        function remove_img_row(i) {
            $('#add_more_image_row' + i).remove();
        }
        /* ------------------------ Add more & remove image field function ---------------------*/

        /* ------------------------ Add more & remove features field function ---------------------*/
        $("#add_more_feature").on("click", function() {
            var i = 1;
            var html = `<div class="row mt-3"  id="add_more_feature_row${i}">
                            <div class="col-10">
                                <input type="text" class="form-control" name="feature" id="feature" placeholder="Feature" required>
                            </div>
                            <div class="col-2 text-end">
                                <button type="button" class="btn btn-danger remove_feature_row${i}" onclick="remove_feature_row(${i})">x</button>
                            </div>
                        </div>`;
            $('#add_more_feature_row').append(html);
            i++;
        });

        function remove_feature_row(i) {
            $('#add_more_feature_row' + i).remove();
        }
        /* ------------------------ Add more & remove image field function ---------------------*/

        /* ------------------------ Add more & remove (price & qty) field function ---------------------*/
        $("#add_more_price").on("click", function() {
            var i = 1;
            var html = `<div class="row mt-3 justify-content-between" id="add_more_price_row${i}">
                            <div class="col-2">
                                <input type="text" class="form-control" name="unit" id="unit" placeholder="Quantity" required>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="unit" id="unit" placeholder="MRP" required>
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control" name="unit" id="unit" placeholder="Selling price" required>
                            </div>
                            <div class="col-1 text-end">
                                <button type="button" class="btn btn-danger" onclick="remove_price_row(${i})">x</button>
                            </div>
                        </div>`;
            $('#add_more_price_row').append(html);
            i++;
        });

        function remove_price_row(i) {
            $('#add_more_price_row' + i).remove();
        }
        /* ------------------------ Add more & remove (price & qty) field function ---------------------*/
    </script>
    @endsection