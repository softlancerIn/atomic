@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'upload_image';
@endphp
<style>
    .inline-flex{
        display: flex;
        justify-content: space-between;
        align-items:center;
    }
    .flex{
        display: flex;
        justify-content: space-between;
        align-items:center;
    }
    .d-flex nav{
        display: block!important;
    }
    .w-5{
        width: 23px;
        height: 23px;
    }
    div nav .justify-between{
        display: none;
    }
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> 
                Image List</h4>
            </div>
            {{-- <div class="col-6 text-end"><a><button type="button" class="btn btn-primary">import Image</button></a></div> --}}
        </div>

        <div class="card col-12 col-md-1 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                    {{-- <h5 class="fw-bold">Add Image</h5> --}}
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{route('upload_image_save')}}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                        <label>Upload Multiple Image</label>
                                        <input type="file" name="image[]" class="form-control" id="image" placeholder="Choose Image" required multiple>
                                    </div>
                                    <div class="col-md-2 col-lg-1 col-sm-12 text-end">
                                        <label></label>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        
        @if(Session::has('success'))
        <p class="alert alert-success">{{Session::get('success')}}</p>
        @elseif(Session::has('error'))
        <p class="alert alert-danger">{{Session::get('error')}}</p>
        @endif
        <!-- Borderless Table -->
        <div class="card p-2" style="height:78%;" >
            <div class="table-responsive " >
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th class="text-nowrap">Sr no</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>   
                        @foreach ($data['image'] as $key => $item) 
                            <tr>    
                                <td>{{ $key+1 }}</td>
                                <td class="text-wrap">{{ $item->image_name }}</td>
                                <td>
                                    <img src="{{$item->doc_path}}" style="height:80px;">
                                </td>
                                <td class="d-flex">
                                    {{-- <a href="{{route('career_edit', $item->id)}}" class="btn btn-success cus_btn_padding"><i class="bx bx-edit-alt "></i></a> --}}
                                    <a onclick="return confirm('Are you sure?')" href="{{route('global_delete',['type'=>'image','id'=>$item->id])}}" class="btn btn-primary cus_btn_padding ms-2"><i class="bx bx-trash "></i></a>
                                
                                </td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
        </div>
            <div class="d-flex justify-content-center">
            {{ $data['image']->links('Admin.pagination')}}
            </div>
@endsection