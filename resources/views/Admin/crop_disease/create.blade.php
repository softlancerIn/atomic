@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'crop_disease';
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
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Crops /Add Crop Disease</h4>
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
                                    <form class="row g-3" action="{{route('crop_disease_create')}}" method="post" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6">
                                            <select id="crops" class="form-select form-control" name="crop_id">
                                                <option value="" selected disabled>Select Crop</option>
                                                @foreach($data['crop'] as $item)
                                                <option value="{{$item->id}}">{{$item->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <select id="crop_disease" name="crop_disease_id" class="form-select form-control">

                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Crop Disease Name" aria-label="Owner Name" name="crop_name">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" aria-label="Mobile Number" name="image">
                                        </div>
                                        <div class="row g-3 add_moreRow">
                                            <div class="col-md-6">
                                                <label for="formGroupExampleInput" class="form-label">Crop Slider name (optional)</label>
                                                <input type="text" class="form-control" aria-label="name" name="slider_name[]">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="formGroupExampleInput" class="form-label">Slider Image (Optional)</label>
                                                <input type="file" class="form-control" aria-label="Mobile Number" name="slider_image[]">
                                            </div>
                                            <div class="col-md-2 text-end">
                                                <label for="formGroupExampleInput" class="form-label d-block invisible">Name</label>
                                                <button type="button" class="btn btn-primary add_moreBtn">Add More</button>
                                            </div>
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
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                toolbar: [

                    // This is a Custom Button in a new Toolbar Area
                    ['custom', ['examplePlugin']],

                    // You can also add Interaction to an existing Toolbar Area
                    ['style', ['style', 'examplePlugin']]
                ]
            });
        });

        var $i = 1;
        $('.add_moreBtn').on("click", function() {
            $('.add_moreRow').append(`<div class="row g-3 remove_row${$i} mt-0">
                                        <div class="col-md-6 ">
                                            <label for="formGroupExampleInput" class="form-label">Crop Slider name (optional)</label>
                                            <input type="text" class="form-control" aria-label="name" name="slider_name[]">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="formGroupExampleInput" class="form-label">Slider Image (Optional)</label>
                                            <input type="file" class="form-control" aria-label="Mobile Number" name="slider_image[]">
                                        </div>
                                        <div class="col-md-2 text-end">
                                            <label for="formGroupExampleInput" class="form-label d-block invisible">Name</label>
                                            <button type="button" class="btn btn-danger removeBtn${$i}" onclick="remove(${$i})">Remove</button>
                                        </div>
                                    </div>`);
            $i++;
        });

        function remove(i) {
            $('.remove_row' + i).remove();
        }

        $('#crops').on("change", function() {
            var crop_id = $('#crops').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{route('get_crop_part')}}",
                method: "POST",
                data: {
                    crop_id: crop_id
                },
                success: function(response) {
                    console.log(response.data);
                    if (response.status == true) {
                        $.each(response.data, function(index, value) {
                            console.log(value);
                            $('#crop_disease').append(`
                            <option value="${value.id}">${value.name}</option>
                            `);
                            // alert(index + ": " + value);
                        });
                    } else {
                        console.log(response);
                    }
                }
            });
        });
    </script>


    @endsection