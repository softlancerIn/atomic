@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'industry';
@endphp

<style>
    .cus_btn_padding {
        padding:0.4345rem 0.5rem;
    }
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Industry</h4>
            </div>
        </div>
        <!-- Borderless Table -->

        <div class="card col-12 col-md-1 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                    <h5 class="fw-bold">Add Industry</h5>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{route('industry_save')}}" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <div class="col-md-6 col-lg-4 col-sm-12">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" aria-label="Enter Name" value="{{old('name')}}" required>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                        <input type="file" name="image" class="form-control" id="image" placeholder="Choose Image" required>
                                    </div>
                                    <div class="col-md-2 col-lg-1 col-sm-12 text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!--- Session flash message -------->
        @if(Session::has('success'))
        <div class="flash-message">
            <p class="alert alert-success">{{ Session::get('success') }}</p>
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
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr no.</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th style="width:10rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['industry'] as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->name}}</td>
                            <td><img src="{{$item->image}}" style="height:100px;"></td>
                            <td>
                            
                                <a href="#" class="btn btn-success cus_btn_padding indistry_edit" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#edit_industry"><i class="bx bx-edit-alt "></i></a>
                                <a href="{{route('global_delete',['type'=>'industry','id'=>$item->id])}}" class="btn btn-primary cus_btn_padding ms-2"><i class="bx bx-trash "></i></a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">There is no data are available!</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
            {{ $data['industry']->links('Admin.pagination')}}
            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
@include('Admin.Modal.modal')
<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000);

    $(document).ready(function(){
        $(".indistry_edit").on("click",function(){
            var industry_id = $(this).data("id");
            $("#industry_id").val(industry_id);
            axios.post("{{route('industry_edit')}}", {
                'id': industry_id,
            }).then(res => {
                console.log(res);
                $('#industry_name').val(res.data.data.name);
            }).catch(error => {
                console.error(error);
            });
        });
    });
</script>
@endsection