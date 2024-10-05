@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'sub_category';
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>
                    Sub Category List
                </h4>
            </div>
            <div class="col-6 text-end"><a href="{{route('addSubCategory',['type'=>'add','id'=>'0'])}}" class="btn btn-primary">Add Sub Category</a></div>
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

        <div class="card p-2">
            {{-- <h5 class="card-header">Borderless Table</h5> --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Sub Category Name</th>
                            <th>Cateory Image</th>
                            <th>Banner Image</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['subcategory'] as $item)
                        <tr>
                            <td>{{$item->category->name}}</td>
                            <td>
                                <strong>{{$item->name}}</strong>
                            </td>
                            <td>
                                @if(!empty($item->image))
                                <img src="{{asset('public/uploads/Category/'.$item->image)}}" alt="" width="50px" height="50px" />
                                @else
                                <img src="{{'https://jagjiwan.teknikoglobal.in/admin/public/uploads/images.jpg'}}" width="50px" height="50px" alt="" />
                                @endif
                            </td>
                            <td>
                                @if(!empty($item->banner_img))
                                <img src="{{asset('public/uploads/Category/'.$item->banner_img)}}" alt="" width="50px" height="50px" />
                                @else
                                --
                                @endif
                            </td>
                            <td>{{$item->description}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item editCatrgory" href="{{route('addSubCategory',['type'=>'edit','id'=>$item->id])}}" data-id="{{$item->id}}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item sub_cat" id="" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#sub_cat" href="javascript:void(0)">
                                            <i class="bx bx-trash me-1"></i>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">There is no any Sub category are available!</h5>
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

            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
@include('Admin.Modal.modal')
<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000)

    $('.editCatrgory').on("click", function() {
        var cat_id = $(this).data("id");
        console.log(cat_id);
        axios.post("{{route('edit-category')}}", {
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

    $('.sub_cat').on("click", function() {
        var cat_id = $(this).data("id");
        $('#sub_catId').val(cat_id);
    });

    $('#sub_cat_delBtn').on("click", function() {
        var delete_id = $('#sub_catId').val();
        var cat_id = $('#cat_id').val();
        axios.post("{{route('delete-sub_category')}}", {
                'id': delete_id,
                'cat_id': cat_id,
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