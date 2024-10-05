@extends('Admin.Layout.layout')
@section('content')
<?php
$active = 'stock';
?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Stock List</h4>
            </div>
            <div class="col-6 text-end ">
                <a href="{{route('stockSample')}}"><button type="button" class="btn btn-primary">Sample file</button></a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#stock_modal"><button type="button" class="btn btn-success">Import file</button></a>    
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="{{route('stockList')}}" class="d-flex mb-2" role="search" method="POST">
                    @csrf
                    <input class="form-control me-2" type="search" name="search" placeholder="Search By SKU Code" aria-label="Search" id="myInput">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
        </div>
        <!-- Borderless Table -->

        <!--- Session flash message -------->
        @if(Session::has('message'))
        <div class="flash-message">
            <p class="alert alert-success">{{ Session::get('message') }}</p>
        </div>
        @endif
        <!--- Session flash message -------->

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="card p-2">
            {{-- <h5 class="card-header">Borderless Table</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Warehouse Name</th>
                            <th>Warehouse Code</th>
                            <th>Product Sku</th>
                            <th>Model no</th>
                            <th>Artical no</th>
                            <th>Quantity</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['stock'] as $key=>$item)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$item->warehouse_name}}</td>
                                <td>{{$item->warehouse_code}}</td>
                                <td>{{$item->sku}}</td>
                                <td>{{$item->model_no}}</td>
                                <td>{{$item->artical_no}}</td>
                                <td>{{$item->qty}}</td>
                            </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">There is no any category are available!</h5>
                            </td>
                        </tr>
                        @endforelse                        
                    </tbody>
                </table>
            </div>
            <style>
                .inline-flex {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .flex {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                }

                .d-flex nav {
                    display: block !important;
                }

                .w-5 {
                    width: 23px;
                    height: 23px;
                }

                div nav .justify-between {
                    display: none;
                }

                .sm:justify-between div p {
                    display: none;
                }
            </style>
            <div class="d-flex justify-content-center">
            {{ $data['stock']->links('Admin.pagination')}}
            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<!--------------------- Modal ------------------------>
<div class="modal fade" id="stock_modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stock_modal">Upload Csv file</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('stockImport')}}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    <div class="col-md-12 mt-3">
                        <input type="file" class="form-control" id="csv_file" name="csv_file" placeholder="Select Iamge" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!------------------------------ Modal ---------------------------->
<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000);
</script>
@endsection