@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'product';

$brand = App\Models\Brand::where('status','1')->get();
@endphp
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
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Products</h4>
            </div>
            <div class="col-6 text-end">
                <a href="{{route('export_sample')}}"><button type="button" class="btn btn-warning">Sample Product</button></a>
                <a href="#" data-bs-target="#import_product" data-bs-toggle="modal"><button type="button" class="btn btn-primary">Import Product</button></a>
                {{-- <a href="{{route('export_data')}}"><button type="button" class="btn btn-secondary">Export Product</button></a> --}}
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <form action="{{route('product_list')}}" class="d-flex mb-2" role="search" method="POST">
                    @csrf
                    <input class="form-control me-2" type="search" name="search" placeholder="Search By SKU Code" aria-label="Search" id="myInput">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
            <div class="col-6">
                <form action="{{route('export_data')}}" class="d-flex mb-2" role="search" method="POST">
                    @csrf
                    <select name="brand_id" id="brand_id" class="form-select">
                        <option value="" selected disabled>Choose Brand</option>
                        @foreach ($brand as $brand_data)
                            <option value="{{$brand_data->id}}">{{$brand_data->name}}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-secondary ms-2" type="submit">Export</button>
                </form>
            </div>
        </div>
        @if($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
        @endif
        @if(Session::has('success'))
        <p class="alert alert-success">{{Session::get('success')}}</p>
        @endif

        @if(Session::has('error'))
        <p class="alert alert-danger">{{Session::get('error')}}</p>
        @endif

        <!-- Borderless Table -->
        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th class="border">Sr no.</th>
                            <th class="border">Name</th>
                            <th class="border">Brand</th>
                            <th class="border">Category</th>
                            <th class="border">SKU Code</th>
                            <th class="border">Artical Code</th>
                            <th class="border">Series Code</th>
                            <th class="border">Model Code</th>
                            <th class="border">MRP</th>
                            <th class="border">Status</th>
                            <th class="border">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                        @forelse ($data['product'] as $key=>$item)
                        <tr>
                            <td class="border">{{$key+1}}</td>
                            <td class="border text-wrap">{{$item->name}}</td>
                            <td class="border">{{$item->brand}}</td>
                            <td class="border">{{$item->main_cat}}</td>
                            <td class="border text-wrap">{{$item->sku_code}}</td>
                            <td class="border text-wrap">{{$item->artical_no}}</td>
                            <td class="border text-wrap">{{$item->series_name}}</td>
                            <td class="border text-wrap">{{$item->model_no}}</td>
                            <td class="border">{{$item->mrp}}</td>

                            <td class="border">{{($item->status == '1') ? 'Active' : 'Inative'}}</td>
                            <td class="border d-flex">
                                <div class="mx-2">
                                    <a href="{{route('product_varientList',['id'=>$item->id])}}"><button type="button" class="btn-sm btn-secondary">Add Varient</button></a>
                                </div>
                                <div class="me-2">
                                    <a href="{{route('product_edit',['id'=>$item->id])}}"><button type="button" class="btn-sm btn-success">Edit</button></a>
                                </div>
                                <div class="">
                                    <a href="{{route('global_delete',['type'=> 'product','id'=>$item->id])}}" onclick="confirm('Are You sure want to delete this product!')"><button type="button" class="btn-sm btn-primary">Delete</button></a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="11" class="text-center border">Data Not found!</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $data['product']->links('Admin.pagination')}}
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<!--------------------- Modal -------------------------------->
<div class="modal fade" id="import_product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('import_product')}}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <label for="csv_file">Csv File</label>
                        <input type="file" class="form-control" name="csv_file" id="csv_file" placeholder="Import Csv">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endsection