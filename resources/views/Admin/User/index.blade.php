@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'user';
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Users</h4>
            </div>
            <div class="col-6 text-end">
                <a href="{{route('usercreate')}}"><button type="button" class="btn btn-primary">Add User</button></a>
                {{-- <a href="#" data-bs-target="#testing_import_product" data-bs-toggle="modal"><button type="button" class="btn btn-primary">Import Product</button></a> --}}
            </div>
            
        </div>

        <!-- Borderless Table -->

        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>block_status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($all_user as $item)
                        <tr>
                            <td class="d-flex">
                                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center mx-2">
                                    <li data-bs-toggle="tooltip" data-popup="tooltip-custom" data-bs-placement="top" class="avatar avatar-xs pull-up" title="{{$item->name}}">
                                    @if(!empty($item->image))
                                        <img src="{{'https://jagjiwan.teknikoglobal.in/api/public/uploads/users/'.$item->image}}" alt="{{$item->name}}" class="rounded-circle" />
                                    @else
                                        <img src="{{asset('/public/user.png')}}" alt="{{$item->name}}" class="rounded-circle" />
                                    @endif
                                    </li>
                                </ul>
                                <strong>{{$item->name ?? '--'}}</strong>
                            </td>
                            <td>{{$item->phone ?? '--'}}</td>
                            <td>{{$item->address->address ?? '--'}}</td>
                            <td>
                                <div class="col-6">
                                    <select class="form-select" id="exampleFormControlSelect1" aria-label="Default select example" onchange="change_user_status(this.value,'{{$item->id}}')">
                                        <option selected value="" disabled>Select Type</option>
                                        <option value="block" @if($item->block_status == 'block') selected @endif>Block</option>
                                        <option value="unblock" @if($item->block_status == 'unblock') selected @endif>Unblock</option>
                                    </select>
                                </div>
                            </td>


                            <td>
                                <div class="dropdown">

                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" class="edit_category" href="{{route('editUser',['id'=>$item->id])}}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{route('deleteUser',['id'=>$item->id])}}"><i class="bx bx-trash me-1"></i>Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Data Not Found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            {{ $all_user->links('Admin.pagination')}}
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<div class="modal fade" id="testing_import_product" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_catrgory">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('testing_import_product')}}" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                    @csrf
                    <div class="col-md-12">
                        <label for="csv_file">Csv File</label>
                        <input type="file" class="form-control" name="csv_file" id="csv_file" placeholder="Import Csv" >
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@include('Admin.Modal.modal')
<script>
    function change_user_status(status, id) {
        var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{ route('user-status') }}",
            type: "POST",
            data: {
                status: status,
                id: id
            },
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function(resp) {
                if (resp.success) {

                } else {

                }

            }
        });
    }
</script>
@endsection