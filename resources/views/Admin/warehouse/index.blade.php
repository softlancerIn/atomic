@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'warehouse';
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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>Warehouse</h4>
            </div>
            <div class="col-6 text-end"><a href="{{route('wareHouse_create')}}"><button type="button" class="btn btn-primary">Add Warehouse</button></a></div>
        </div>

        <!-- Borderless Table -->
        <!-------------- Session message ---------------->
        @if (Session::has('success'))
            <div class="alert alert-success">
                <p>{{Session::get('success')}}</p>
            </div>
        @endif
        <!-------------- Session message ---------------->
        <div class="card p-2">
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Address</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['warehouse'] as $key=>$item)
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$item->name ?? '--'}}</td>
                            <td>{{$item->code ?? '--'}}</td>
                            <td>{{$item->address ?? '--'}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" class="edit_category" href="{{route('wareHouse_edit',['id'=>$item->id])}}">
                                            <i class="bx bx-edit-alt me-1"></i>
                                            Edit
                                        </a>
                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{route('global_delete',['type'=>'warehouse','id'=>$item->id])}}"><i class="bx bx-trash me-1"></i>Delete</a>
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
            {{-- {{ $all_user->links('Admin.pagination')}} --}}
        </div>
        <!--/ Borderless Table -->
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