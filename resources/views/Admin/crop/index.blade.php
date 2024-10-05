@extends('Admin.Layout.layout')
@section('content')
<?php
$active = 'crop';
?>
<!------------Styling------------>
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
<!------------Styling------------>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Crops List</h4>
            </div>
            <div class="col-6 text-end"><a href="{{route('crop_add')}}" class="btn btn-primary">Add Crops</a></div>
        </div>
        <!-- Borderless Table -->

        <!--- Session flash message -------->
        @if(Session::has('message'))
        <div class="flash-message">
            <p class="alert alert-success">{{ Session::get('message') }}</p>
        </div>
        @endif
        <!--- Session flash message -------->

        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Crop Name</th>
                            <th>Image</th>
                            <th>Introduction</th>
                            <th>Climate</th>
                            <th>Soil</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($data) && sizeof($data) > 0)
                        @forelse ($data['crops'] as $key=>$item)
                        <tr>
                            <td>{{$key +1}}</td>
                            <td>
                                <strong>{{$item->name}}</strong>
                            </td>
                            <td>
                                @if(!empty($item->image))
                                <img src="{{asset('public/uploads/Crops/'.$item->image)}}" alt="" width="50px" height="50px" />
                                @else
                                <img src="{{'https://jagjiwan.teknikoglobal.in/admin/public/uploads/images.jpg'}}" width="50px" height="50px" alt="" />
                                @endif
                            </td>
                            <td>{!! Str::limit($item->introduction,30) !!}</td>
                            <td>{!! Str::limit($item->climate,30) !!}</td>
                            <td>{!! Str::limit($item->soil,30) !!}</td>
                            <td style="width: 20px;">
                                <a href="{{route('cropPart_list',['id'=>$item->id])}}" class="btn btn-primary text-white">Parts</a>
                                <a href="{{route('crop_edit',['id'=>$item->id])}}" class="btn btn-primary text-white">Edit</a>
                                <a class="btn btn-primary text-white">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">There is no any category are available!</h5>
                            </td>
                        </tr>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
            <div class="d-flex justify-content-center">
                {{ $data['crops']->links('Admin.pagination')}}
            </div>
        <!--/ Borderless Table -->
    </div>
</div>
<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000)

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