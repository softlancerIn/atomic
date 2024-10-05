@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'discount_coupon';
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
                Coupon List</h4>
            </div>
            <div class="col-6 text-end"><a href="{{ route('counpon_create') }}"><button type="button" class="btn btn-primary">Add Coupon</button></a></div>
        </div>

        <div class="row">
            <div class="col-6">
                <form class="d-flex mb-2" role="search">
                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-primary" type="submit">Search</button>
                </form>
            </div>
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
                            <th>Description</th>
                            <th>Percentage</th>
                            <th>Max Amount</th>
                            <th>Min Amount</th>
                            <th>Total Discount</th>
                            <th>Valid From</th>
                            <th>Valid To</th>
                            <th class="text-center">action</th>
                        </tr>   
                        @foreach ($data['coupon'] as $key => $item) 
                            <tr>    
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description ?? '--'}}</td>
                                <td>{{ $item->percentage }}</td>
                                <td>{{$item->max_amount}}</td>
                                <td>{{$item->min_amount}}</td>
                                <td>{{$item->total_discount}}</td>
                                <td>{{$item->validate_from}}</td>
                                <td>{{$item->valid_to}}</td>
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
                {!! $data['coupon']->links() !!}
            </div>
        </div>
@endsection