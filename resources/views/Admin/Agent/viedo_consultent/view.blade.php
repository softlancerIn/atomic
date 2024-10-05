@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'video_consultent';
@endphp

<style>
    .forms-parent {
        padding: 15px;
        margin-top: 15px;
        background-color: #fff;
    }

    .prec-img {
        width: 50%;
        height: 50px;
    }
</style>
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row justify-content-center">
                        <div class="col-12 col-md-8 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="update_id" name="update_id" value=" ">
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Name</label>
                                        <div class="col-sm-8">
                                            <h6>{{$data['user']->name}}</h6>
                                            <!-- <input type="text" value="" class="form-control" id="inputEmail3" name="" readonly> -->
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Disease</label>
                                        <div class="col-sm-8">
                                            <h6>{{$data['disease']->name}}</h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Mobile No.</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['user']->phone}}</h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Call Type</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['order']->call_type == 'video_call' ? 'Video Call' : 'Audio Call'}}</h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Booking Date</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['order']->booking_date}}</h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Booking TIme</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['order']->booking_time}}</h6>
                                        </div>
                                    </div>
                                    <!-- <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Booking TIme</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['order']->booking_time}}</h6>
                                        </div>
                                    </div> -->
                                    @if($data['order']->booking_status == '2')
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Reject Reason</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['order']->reject_reason}}</h6>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Booking Confirmation</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>
                                                @if($data['order']->booking_status == '1')
                                                Confirmed
                                                @elseif($data['order']->booking_status == '0')
                                                Pending
                                                @else
                                                Reject
                                                @endif
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Payment Status</label>
                                        <div class="col-sm-8 col-lg-4">
                                            <h6>{{$data['order']->payment_status}}</h6>
                                        </div>
                                    </div>
                                    @if(!empty($data['prescription']->prescription_item))
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Payment Status</label>
                                        <div class="col-sm-8 col-lg-6">
                                            <h6>
                                                @foreach(json_decode($data['prescription']->prescription_item) as $item)
                                                <span>{{$item}},&nbsp;</span>
                                                @endforeach
                                            </h6>
                                        </div>
                                    </div>
                                    @endif
                                    @if(!empty($data['prescription']->prescription_image))
                                    <div class="row mb-3">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Prescription</label>
                                        <div class="col-sm-2 d-flex">
                                            <div class="border border-dark prec-img">
                                                <img src="{{env('ADMIN_IMG').'/prescription/'.$data['prescription']->prescription_image}}" height="50" width="100%">
                                            </div>
                                            <a href="" download><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                                    <path d="m12 16 4-5h-3V4h-2v7H8z"></path>
                                                    <path d="M20 18H4v-7H2v7c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2v-7h-2v7z"></path>
                                                </svg></a>
                                            <a href="" class="ms-3" target="_blank" class="ms-3"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);transform: ;msFilter:;">
                                                    <path d="M12 9a3.02 3.02 0 0 0-3 3c0 1.642 1.358 3 3 3 1.641 0 3-1.358 3-3 0-1.641-1.359-3-3-3z"></path>
                                                    <path d="M12 5c-7.633 0-9.927 6.617-9.948 6.684L1.946 12l.105.316C2.073 12.383 4.367 19 12 19s9.927-6.617 9.948-6.684l.106-.316-.105-.316C21.927 11.617 19.633 5 12 5zm0 12c-5.351 0-7.424-3.846-7.926-5C4.578 10.842 6.652 7 12 7c5.351 0 7.424 3.846 7.926 5-.504 1.158-2.578 5-7.926 5z"></path>
                                                </svg></a>
                                        </div>
                                    </div>
                                    @endif
                                    <!-- <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div> -->
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

@endsection