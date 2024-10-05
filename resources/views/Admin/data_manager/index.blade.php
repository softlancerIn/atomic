@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'data_manager';
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
<div class="content-wrapper" style="height: 100%;">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span> 
                Data Manager List</h4>
            </div>
            <div class="col-6 text-end"><a href="{{ route('dataManag_create') }}"><button type="button" class="btn btn-primary">Add Data Manager</button></a></div>
        </div>
        
        @if(Session::has('success'))
        <p class="alert alert-success">{{Session::get('success')}}</p>
        @elseif(Session::has('error'))
        <p class="alert alert-danger">{{Session::get('error')}}</p>
        @endif
        <!-- Borderless Table -->
        <div class="card p-2" style="height:78%;" >
            <div class="table-responsive text-nowrap" style="height:100%" >
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>Sr no</th>
                            <th>Name</th>
                            <th>EMP Code</th>
                            <th>Email</th>
                            <th>Mobile Number</th>
                            <th>Action</th>
                        </tr>   
                        @foreach ($data['data_manager'] as $key => $item) 
                            <tr>    
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->empcode ?? '--'}}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{$item->phone}}</td>
                                <td>
                                <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                <div class="dropdown-menu" style="">
                                        <a class="dropdown-item" href="{{route('coupon_edit', $item->id)}}">
                                        <i class="bx bx-edit-alt me-1"></i>Edit</a>
                                    <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{ route('global_delete', ['type'=>'coupon','id'=>$item->id]) }}">
                                        <i class="bx bx-trash me-1"></i>Delete</a>
                                    </div>
                                </div>
                                </td>
                            </tr>
                        @endforeach
                    </thead>
                </table>

            </div>
            <div class="d-flex justify-content-center">
                {!! $data['data_manager']->links() !!}
            </div>
        </div>
@endsection