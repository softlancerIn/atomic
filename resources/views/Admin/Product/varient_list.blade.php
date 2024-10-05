@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'product';
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Products Varient List</h4>
            </div>
            <div class="col-6 text-end">
                <a href="#" data-bs-target="#add_varient" data-bs-toggle="modal"><button type="button" class="btn btn-primary">Add Varient</button></a>
            </div>
        </div>

        @if(Session::has('success'))
            <p class="alert alert-success">{{Session::get('success')}}</p>
        @endif
        
        <!-- Borderless Table -->
        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th class="border">Sr no.</th>
                            <th class="border">Qty Range</th>
                            <th class="border">Price Per Piece</th>
                            <th class="border">Status</th>
                            <th class="border">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['product_var'] as $key=>$item)
                        <tr>
                            <td class="border">{{$key+1}}</td>
                            <td class="border">{{$item->qty_range}}</td>
                            <td class="border">{{$item->price_per_pc}}</td>

                            <td class="border">{{($item->status == '1') ? 'Active' : 'Inative'}}</td>
                            <td class="border d-flex">
                                <div class="mx-2">
                                    <a href="#" data-bs-target="#edit_varient" data-id="{{$item->id}}" data-bs-toggle="modal" class="edit_varient"><button type="button" class="btn-sm btn-secondary">Edit</button></a>
                                </div>
                                <div class="">
                                    <a href="#" data-bs-target="#delete_product" data-bs-toggle="modal"><button type="button" class="btn-sm btn-primary">Delete</button></a>
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
            {{ $data['product_var']->links('Admin.pagination')}}
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<!--------------------- Modal -------------------------------->
<div class="modal fade" id="add_varient" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Product Varient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('saveProductVarient')}}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="product_id" value="{{$data['id']}}"> 
                    <div class="col-md-12">
                        <label for="csv_file">Qty Range</label>
                        <input type="text" class="form-control" name="qty_range" id="qty_range" placeholder="Quantity Range" >
                    </div>
                    <div class="col-md-12 mt-2">
                        <label for="csv_file">Price Per Piece</label>
                        <input type="text" class="form-control" name="price_per_pc" id="price_per_pc" placeholder="Quantity Range" >
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_varient" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Edit Product Varient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('saveProductVarient')}}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                    @csrf
                    <input type="hidden" name="varient_id" id="edit_var_id"> 
                    <input type="hidden" name="product_id" value="{{$data['id']}}"> 
                    <div class="col-md-12">
                        <label for="csv_file">Qty Range</label>
                        <input type="text" class="form-control" name="qty_range" id="edit_qty_range" placeholder="Quantity Range" >
                    </div>
                    <div class="col-md-12 mt-2">
                        <label for="csv_file">Price Per Piece</label>
                        <input type="text" class="form-control" name="price_per_pc" id="edit_per_price" placeholder="Quantity Range" >
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
    $(document).ready(function(){
        $(".edit_varient").on("click",function(){
            var var_id = $(this).data("id");
            axios.post("{{route('editProductVarient')}}", {
                'var_id': var_id,
            })
            .then(res => {
                console.log(res.data);
                $("#edit_var_id").val(res.data.data.id);
                $("#edit_qty_range").val(res.data.data.qty_range);
                $("#edit_per_price").val(res.data.data.price_per_pc);
            }).catch(error => {
                console.error(error);
            });
        });
    });
</script>
@endsection