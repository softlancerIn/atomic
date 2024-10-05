@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'sub_category';
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
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Sub Category /Add Subcategory</h4>
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
                                <form class="row g-3" method="post" action="{{route('saveSubCategory')}}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" placeholder="Enter Subcategory Name" aria-label="Mobile Number" required>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="cat_id" id="" class="form-select form-control">
                                            <option value="" disabled selected> Select Category</option>
                                            @foreach($data['category'] as $item)
                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center jagjivan-form rounded">
                                            <label for="file">Sub Category Image</label>
                                            <input type="file" name="image" id="file" required>
                                            <label class="rotate-45" for="inputGroupFile02"><i class="bi bi-paperclip"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-between align-items-center jagjivan-form rounded">
                                            <label for="banner_img">Banner Image</label>
                                            <input type="file" name="banner_img" id="banner_img" required>
                                            <label class="rotate-45" for="inputGroupFile02"><i class="bi bi-paperclip"></i></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <textarea class="form-control" name="discription" placeholder="Discription"></textarea>
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
@endsection