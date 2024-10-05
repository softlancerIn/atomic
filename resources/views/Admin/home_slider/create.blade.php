@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'home_slider';
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
    .search_list li a div span {
        color: #000;
        cursor: pointer;
    }

    .search_list li {
        cursor: pointer;
    }

    .search_list li:hover span {
        color: #000;
    }

    .search_list li:hover {
        color: #000;
        background-color: #14b58f85;
    }

    .search_list li {
        padding: 10px;
        border-bottom: 1px solid gray;
        color: #000;
        list-style: none;
    }
    .search_suggetion {
        overflow-y: scroll;
        height: 214px;
        position: absolute;
        z-index: 1016;
        width: 47%;
        background-color: #fff;
        color: black;
        /* padding: 10px 15px; */
        border: 1px solid #808080;
    }
</style>
</head>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
                <div class="col-6">
                    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Home Slider /Add Slider</h4>
                </div>
                <div class="col-6 text-end"><a href="{{ url()->previous() }}"><button type="button" class="btn btn-primary ">Go Back</button></a></div>
            </div>

            <!-------------------- Validation Message --------------------->
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <!-------------------- Validation Message --------------------->

            <div class="card">
                <section>
                    <div class="container mt-4 mb-4">
                        <div class="row justify-content-center">
                            <div class="col-12 col-md-8 col-lg-12">
                                <div class="bg-white">
                                    <form class="row g-3" method="post" action="{{route('home_slider_save')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Sider Name" aria-label="Owner Name" value="{{old('name')}}">
                                        </div>
                                        <div class="col-md-6">
                                            <select class="form-control form-select" name="slider_type">
                                                <option value="" selected disabled>Choose Slider Type</option> 
                                                <option value="deal_of_the_day">Deals of the Day slider</option>
                                                <option value="super_special_offer">Super Special Offer Slider</option>
                                                <option value="obsolute_discontinued_item">Obsolute or Discontinued Item Slider</option>
                                                <option value="robot_spares_slider">Robot and Robot Spares Slider</option>
                                                <option value="refurnished_product">Refurbished Product Slider</option>
                                                <option value="highest_selling_product">Highest Selling Product Slider</option>
                                                <option value="engineer_service">Engineering Service Slider</option>
                                                <option value="engineer_drawing_tool">Engineering Drawing and Tools slider</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="search" id="search_product" name="product_name" onkeyup="searchProduct()" placeholder="Search For Products (using artical no)" class="form-control">
                                            <!-- <input type="hidden" id="sel_product_name"> -->
                                            <div class="search_suggetion overlay d-none ">
                                                <ul class="search_list ps-0"></ul>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="image" aria-label="Mobile Number">
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
        function searchProduct() {
            var search_key = $('#search_product').val();
            console.log(search_key.length);
            if (search_key.length >= 5) {
                $('.search_suggetion').removeClass('d-none');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{route('get_product_list')}}",
                    data: {
                        search_key: search_key
                    },
                    dataType: "JSON",
                    method: 'POST',
                    success: function(res) {
                        var successKeysCount = Object.keys(res).length;
//                        console.log(value.name);
                        var html = ``;
                        var value = "";
                        if (successKeysCount > 0) {
                            $.each(res.data, function(key, value) {
                                var name = btoa(value.name);
                                console.log(name);
                                
                                html += `<li id="search_list1">
                                            <a class="d-flex justify-content-between align-items-center" onclick="get_product(${value.id},'${name}')">
                                                <div >
                                                    <div>
                                                        <span class="mediname">${value.name}</span>
                                                    </div>
                                                </div>
                                            </a> 
                                        </li>`;
                            });
                            $('.search_suggetion').removeClass('d-none');
                            $('.search_list').html(html);
                        } else {
                            $('.search_suggetion').addClass('d-none');
                            // $('.search_list').html(html);
                        }

                    }
                });
            } else {
                $('.search_suggetion').addClass('d-none');
            }
        }

        function get_product(id, product_name) {
            var name = atob(product_name);
            $('#search_product').val(name);
            $('#sel_product_name').val(id);
            $('.search_suggetion').addClass('d-none');
        }
    </script>
    @endsection