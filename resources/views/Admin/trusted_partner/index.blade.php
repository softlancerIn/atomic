@extends('Admin.Layout.layout')
@section('content')
<?php
$active = 'trusted_partner';
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Trusted Partner List</h4>
            </div>
            <div class="col-6 text-end">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_partner">Add Partner</a>
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

        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($data) && sizeof($data) > 0)
                        @forelse ($data['trusted_partner'] as $key=>$item)
                        <tr>
                            <td>{{$key +1}}</td>
                            <td>
                                <strong>{{$item->name}}</strong>
                            </td>
                            <td>
                                @if(!empty($item->image))
                                <img src="{{$item->image}}" alt="" width="50px" height="50px" />
                                @else
                                <img src="{{'https://jagjiwan.teknikoglobal.in/admin/public/uploads/images.jpg'}}" width="50px" height="50px" alt="" />
                                @endif
                            </td>
                            <td style="width: 20px;">
                                <a class="btn btn-primary text-white edit_partner" data-bs-toggle="modal" data-bs-target="#edit_partner" data-id="{{$item->id}}">Edit</a>
                                <a href="{{route('global_delete',['type'=>'home_slider','id'=>$item->id])}}" class="btn btn-primary text-white">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">Data Not Found!</h5>
                            </td>
                        </tr>
                        @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-center">
            {{ $data['trusted_partner']->links('Admin.pagination')}}
            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
@include('Admin.Modal.modal');
<script>
    $('.edit_partner').on("click", function() {
        var id = $(this).data("id");
        console.log(cat_id);
        axios.post("{{route('trusted_prt_edit')}}", {
            'id': id,
        }).then(res => {
            $('#edit_partner_name').val(res.data.data.edit_data.name);
            $('#partner_edit_id').val(res.data.data.edit_data.id);
        }).catch(error => {
            console.error(error);
        });
    });


    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000);
</script>
@endsection