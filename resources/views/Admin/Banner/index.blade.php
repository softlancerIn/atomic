@extends('Admin.Layout.layout')
@section('content')
@php
    $active = 'banner';
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6"><h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Banners</h4></div>
              <div class="col-6 text-end">
                <a href="{{url('banners-create')}}"><button type="button" class="btn btn-primary">Add Banner</button></a>
              </div>
            
           </div>
        
        <!-- Borderless Table -->

        <div class="card p-2"> 
            <div class="table-responsive text-nowrap">
              <table class="table table-borderless">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Web Image</th>
                    <th>Mobile Image</th>
                    <th>Description</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($banner['banner'] as $item)
                        <tr> 
                            <td class="d-flex"> 
                                <strong>{{$item->name}}</strong>
                            </td>
                            <td>{{$item->type}}</td>
                            <td><img src="{{asset("public/uploads/banners/".$item->web_image)}}" alt="" width="50px" height="50px"></td>
                            <td><img src="{{asset("public/uploads/banners/".$item->mobile_image)}}" alt="" width="50px" height="50px"></td>
                            <td><span class="badge bg-label-primary me-1">{{$item->description}}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('edit-banner',$item->id)}}">
                                            <i class="bx bx-edit-alt me-1"></i> Edit</a>
                                        <a class="dropdown-item" onclick="return confirm('Are you sure?')" href="{{route('delete_banner',$item->id)}}">
                                            <i class="bx bx-trash me-1"></i> 
                                            Delete
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    
                    @endforeach
                </tbody>
              </table>
            </div>
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
                .sm:justify-between div p{
                    display: none;
                }
            </style>
            <div class="d-flex justify-content-center">
                {!! $banner['banner']->links() !!}
            </div>
        </div> 
    </div>
</div> 

@endsection
