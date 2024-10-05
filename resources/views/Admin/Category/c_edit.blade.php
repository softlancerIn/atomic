@extends('Admin.Layout.layout')
@section('content')
@php
if($data['type'] == 'C2'){
    $active = 'c2cateogy';
}
elseif($data['type'] == 'C1'){
    $active = 'c1cateogy';
}
elseif($data['type'] == 'leaf'){
    $active = 'leafcateogy';
}
else{
    $active = '';
}

switch($data['type']){
    case 'C1':
        $type = 'c1';
        break;
    case 'C2':
        $type = 'c2';
        break;
    case 'leaf':
        $type = 'leaf';
        break;
}
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>
                @if(!empty($data['type']))
                    {{$data['type']}}
                @endif
                Category
                </h4>
            </div>
        </div>
        <!-- Borderless Table -->

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

        <div class="card col-12 col-md-1 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                    <h5 class="fw-bold">Edit
                        @if(!empty($data['type']))
                            {{$data['type']}}
                        @endif
                     Category</h5>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{ route('add-category',['type'=>$type]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$data['edit_data']->id}}">
                                    <div class="col-md-6 col-lg-4 col-sm-12 mt-3">
                                        <select class="form-select" id="cat_id" name="cat_id" aria-label="Default select example" required>
                                            <option disabled selected value="">Select Type</option>
                                            @foreach ($data['categories'] as $item)
                                                <option value="{{$item->id}}" {{$data['edit_data']->cat_id == $item->id ? 'selected' :''}}>{{$item->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6 col-lg-4 col-sm-12">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name" aria-label="Enter Name" value="{{$data['edit_data']->name}}" required>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                        <input type="file" name="image" class="form-control" id="image" placeholder="Choose Image">
                                    </div>
                                    <div class="col-md-2 col-lg-1 col-sm-12 text-end">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000)

    $('.editCatrgory').on("click", function() {
        var cat_id = $(this).data("id");
        console.log(cat_id);
        axios.post("{{route('edit-category',['type'=>'all','id'=>'0'])}}", {
            'id': cat_id,
        }).then(res => {
            console.log(res);
            console.log(res.data.data.name);
            $('#cat_id').val(res.data.data.id);
            $('#edit_cat_name').val(res.data.data.name);
            $('#edit_cat_description').val(res.data.data.description);
        }).catch(error => {
            console.error(error);
        });
    });

    $('.delete_cat_btn').on("click", function() {
        var cat_id = $(this).data("id");
        console.log(cat_id);
        $('#delete_id').val(cat_id);
    });

    $('#delete_category_btn').on("click", function() {
        var delete_id = $('#delete_id').val();
        axios.post("{{route('delete-category')}}", {
                'id': delete_id,
            })
            .then(res => {
                console.log(res);
                window.location.reload()
            }).catch(error => {
                console.error(error);
            });
    });
</script>
@endsection