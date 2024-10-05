@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'career';
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
                Career List</h4>
            </div>
            <div class="col-6 text-end"><a href="{{ route('career_create') }}"><button type="button" class="btn btn-primary">Add Career</button></a></div>
        </div>
        
        @if(Session::has('success'))
        <p class="alert alert-success">{{Session::get('success')}}</p>
        @elseif(Session::has('error'))
        <p class="alert alert-danger">{{Session::get('error')}}</p>
        @endif
        <!-- Borderless Table -->
        <div class="card p-2" style="height:78%;" >
            <div class="table-responsive " style="height:100%" >
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th class="text-nowrap">Sr no</th>
                            <th>Title</th>
                            <th>Skill</th>
                            <th>Location</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>   
                        @foreach ($data['career'] as $key => $item) 
                            <tr>    
                                <td>{{ $key+1 }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->skill ?? '--'}}</td>
                                <td>{{ $item->location }}</td>
                                <td>{{$item->description}}</td>
                                <td class="d-flex">
                                    <a href="{{route('career_edit', $item->id)}}" class="btn btn-success cus_btn_padding"><i class="bx bx-edit-alt "></i></a>
                                    <a onclick="return confirm('Are you sure?')" href="{{route('global_delete',['type'=>'career','id'=>$item->id])}}" class="btn btn-primary cus_btn_padding ms-2"><i class="bx bx-trash "></i></a>
                                
                                </td>
                            </tr>
                        @endforeach
                    </thead>
                </table>
            </div>
            <div class="d-flex justify-content-center">
            {{ $data['career']->links('Admin.pagination')}}
            </div>
        </div>
@endsection