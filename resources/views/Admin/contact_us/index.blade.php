@extends('Admin.Layout.layout')
@section('content')
<?php
$active = 'contact_us';
?>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>ContactUs List</h4>
            </div>
            {{-- <div class="col-6 text-end"><a href="#"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_catrgory">Add Category</button></a></div> --}}
        </div>
        <!-- Borderless Table -->

        <!--- Session flash message -------->
        @if(Session::has('message'))
        <div class="flash-message">
            <p class="alert alert-success">{{ Session::get('message') }}</p>
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['contact'] as $item)
                        <tr>
                            <td>
                                <strong>{{$item->name}}</strong>
                            </td>
                            <td>{{$item->email}}</td>
                            <td>{{$item->phone}}</td>
                            <td class="text-wrap">{{$item->message}}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4">
                                <h5 class="text-center">There is no any Contact are available!</h5>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
            <div class="d-flex justify-content-center">
            {{ $data['contact']->links('Admin.pagination')}}
            </div>
        <!--/ Borderless Table -->
    </div>
</div>
@endsection