@extends('Admin.Layout.layout')
@section('content')

@php
$active = 'testing';
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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Product /Add
                        Product</h4>
                </div>
                <div class="col-6 text-end"><a href="{{ url()->previous() }}"><button type="button"
                            class="btn btn-primary ">Go Back</button></a></div>
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
                                    <form class="row g-3" method="post" action="{{route('product_save')}}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Item Name"
                                                aria-label="Item Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="cat_id" id="cat_id" class="form-control form-select">
                                                <option value="" disabled selected>Select Category</option>

                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select name="sub_cat" id="sub_cat" name="sub_cat"
                                                class="form-control form-select"></select>
                                        </div>

                                        <div class="col-md-6">
                                            <select class="form-select">
                                                <option value="" selected disabled>Select Brand</option>
                                                <option value="1">ABC</option>
                                                <option value="1">ABC</option>
                                            </select>
                                        </div>


                                        <!------------------- Multiple Image Field -------------------->
                                        <div class="col-md-6">
                                            <div class="row" id="add_more_image_row">
                                                <div class="col-10">
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        placeholder="image" required>
                                                </div>
                                                <div class="col-2 text-end">
                                                    <button class="btn btn-primary" id="add_more_image">+</button>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-10">
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        placeholder="image" required>
                                                </div>
                                                <div class="col-2 text-end">
                                                    <button class="btn btn-danger">x</button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-10">
                                                    <input type="text" class="form-control" name="feature" id="feature"
                                                        placeholder="Feature" required>
                                                </div>
                                                <div class="col-2 text-end">
                                                    <button class="btn btn-primary">+</button>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-10">
                                                    <input type="text" class="form-control" name="feature" id="feature"
                                                        placeholder="Feature" required>
                                                </div>
                                                <div class="col-2 text-end">
                                                    <button class="btn btn-danger">x</button>
                                                </div>
                                            </div>
                                        </div>

                                        <!------------------- Multiple Image Field -------------------->
                                        <!------------------- Muliple Input for quantity, MRP, Selling Prize ----------------->
                                        <div class="col-md-12">
                                            <div class="row justify-content-between">
                                                <div class="col-2">
                                                    <input type="text" class="form-control" name="unit" id="unit"
                                                        placeholder="Quantity" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit"
                                                        placeholder="Unit" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit"
                                                        placeholder="Unit" required>
                                                </div>
                                                <div class="col-1 text-end">
                                                    <button class="btn btn-primary">+</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row justify-content-between">
                                                <div class="col-2">
                                                    <input type="text" class="form-control" name="unit" id="unit"
                                                        placeholder="Quantity" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit"
                                                        placeholder="Unit" required>
                                                </div>
                                                <div class="col-4">
                                                    <input type="text" class="form-control" name="unit" id="unit"
                                                        placeholder="Unit" required>
                                                </div>
                                                <div class="col-1 text-end">
                                                    <button class="btn btn-danger">x</button>
                                                </div>
                                            </div>
                                        </div>
                                        <!------------------- Muliple Input for quantity, MRP, Selling Prize ----------------->

                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="delivery_time"
                                                id="delivery_time" placeholder="Delivery Time" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="delivery_time"
                                                id="delivery_time" placeholder="Delivery Time" required>
                                        </div>
                                        <!------------------------------- text Editor  input field --------------------->
                                        <div class="col-12">
                                            <div class="" id="main-container">
                                                <div class="editor">
                                                    <textarea class="ckeditor" id="editor1" name="editor1"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <!------------------------------- text Editor  input field --------------------->

                                        <!------------------------------- Description and Specification input field --------------------->
                                        <div class="col-12">
                                            <textarea class="form-control" name="safty_pricotion" id="safty_pricotion"
                                                cols="30" rows="3" placeholder="Specification"></textarea>
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
    <script src="https://cdn.ckeditor.com/4.19.1/standard-all/ckeditor.js"></script>
    <!-- ===================== Editor Script ================= -->
    <script>
        function createNewEditor(targetElement) {
            var editorDiv = document.createElement("div");
            $(editorDiv).addClass("editor");
            var textArea = document.createElement("textarea");
            var deleteBtn = document.createElement("button");

            $(textArea)
                .addClass("ckeditor")
                .appendTo(editorDiv);
            $(deleteBtn)
                .attr("type", "button")
                .addClass("btn btn-success delete-editor my-2")
                .text("Delete Chapter")
                .appendTo(editorDiv);
            $(editorDiv).appendTo(targetElement);

            var newEditor = CKEDITOR.replace(textArea);
            $(textArea).attr("id", newEditor.name);
            console.log(newEditor);
        }

        $(document).ready(function () {
            $(".ckeditor").each(function (_, ckeditor) {
                CKEDITOR.replace(ckeditor);
            });

            $(".chapter-video").each(function (_, chapterVideo) {
                var chapterVideoInput = $(chapterVideo).find(".file-input");
                var chapterFileUploadName = $(chapterVideo).find(".upload-file-name");
                $(chapterVideoInput).on("change", function (e) {
                    var filesLength = e.target.files.length;
                    if (filesLength) {
                        $(chapterFileUploadName)
                            .find("span")
                            .text(e.target.files[0].name);
                    }
                });
            });

        });
    </script>
    <!-- ===================== Editor Script ================= -->

    <script>
        $("#cat_id").on("change", function () {
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
                success: function (data) {
                    console.log(data);
                    if (data.status == true) {
                        if (data.data != '') {
                            $('#sub_cat').removeClass('d-none');
                            $('#sub_cat').html('');
                            $.each(data.data, function (index, item) {
                                console.log(item);
                                $('#sub_cat').append($('<option>', {
                                    value: item
                                    .id, // Set the value of the option
                                    text: item
                                    .name, // Set the text of the option
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

        $("#add_more_image").on("click", function () {
            var i = 1;
            var html = `<div class="row mt-3" id="add_more_image_row${i}">
                        <div class="col-10">
                            <input type="file" class="form-control" name="image" id="image" placeholder="image" required>
                        </div>
                        <div class="col-2 text-end">
                            <button class="btn btn-danger remove_image_row${i}" >x</button>
                        </div>
                    </div>`;
            $('#add_more_image_row').append(html);
        });
    </script>
    @endsection