@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'payout';
$data['type'] = "new";
switch($data['type']){
case 'new':
$type = 'New';
$cat_placeholder = 'Select New';
break;
case 'approved':
$type = 'Approved';
$cat_placeholder = 'Select Approved';
break;
case 'reject':
$type = 'Reject';
$cat_placeholder = 'Select Reject';
break;
}


@endphp

<style>
    .cus_btn_padding {
        padding: 0.4345rem 0.5rem;
    }

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
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard /</span>
                    @if(!empty($data['type']))
                    {{$type}}
                    @endif
                    Request
                </h4>
            </div>
        </div>
        <!-- Borderless Table -->
        @if(Session::has('error'))
        <div class="flash-message">
            <p class="alert alert-danger">{{ Session::get('error') }}</p>
        </div>
        @endif
        <!--- Session flash message -------->
        @if($data['type'] == 'new')
        <div class="card col-12 col-md-1 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{ route('exportTransection',['type'=>'payout']) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6 col-lg-4 col-sm-12">
                                        <label>Start Time</label>
                                        <input type="date" class="form-control" name="start_date" id="start_time" placeholder="Enter Name" aria-label="Enter Start Time" value="{{old('start_time')}}" required>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                        <label>End Time</label>
                                        <input type="date" name="end_time" class="form-control" id="end_time" placeholder="Enter End Time">
                                    </div>
                                    <div class="col-md-3 col-lg-1 col-sm-12 text-end">
                                        <label></label>
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </div>
                                    <div class="col-md-3 col-lg-1 col-sm-12 text-end">
                                        <label></label>
                                        <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#import_modal">Import</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @endif

        <div class="card col-12 col-md-1 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                        <h5 class="fw-bold">Search
                            @if(!empty($data['type']))
                            {{$type}}
                            @endif
                            Request
                        </h5>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{ route('refundList',['type'=>$data['type']]) }}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-md-6 col-lg-4 col-sm-12">
                                        <input type="text" class="form-control" name="search" placeholder="Search {{$type}} request By transection id" aria-label="Enter Name" required>
                                    </div>

                                    <div class="col-md-2 col-lg-1 col-sm-12 text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

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
            <div class="table-responsive text-nowrap">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th>SR no</th>
                            <th>Order No</th>
                            <th>Transection No</th>
                            <th>Amount</th>
                            <th>Transection Date</th>
                            <th>Payout Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['category_data'] as $key=>$item)
                        <tr>
                            <td>
                                <strong>{{$key+1}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->order_id}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->ref_no}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->amount}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->transaction_data}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->created_at}}</strong>
                            </td>
                            <td class="d-flex">
                                @if($item->status == '0')
                                <div class="">
                                    <a class="btn btn-sm btn-success" id="" data-id="{{$item->id}}" onclick="change_user_status('1','{{$item->id}}','payout')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                        Approved
                                    </a>
                                </div>
                                <div class="mx-1">
                                    <a href="#" class="btn btn-sm btn-danger" onclick="change_user_status('2','{{$item->id}}','payout')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                        </svg>Reject</a>
                                </div>

                                @elseif($item->status == '1')
                                <span class="badge rounded-pill bg-success">Approved</span>
                                @elseif($item->status == '2')
                                <span class="badge rounded-pill bg-danger">Reject</span>
                                @endif


                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <h5 class="text-center">There is no data are available!</h5>
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
                {!! $data['category_data']->links() !!}
            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="import_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Import Refund file</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3" method="post" action="{{ route('importTransection',['type'=>'refund']) }}" enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12 col-lg-12 col-sm-12">
                        <input type="file" class="form-control" name="csv_file" aria-label="Enter Name" required>
                    </div>

                    <div class="col-md-2 col-lg-1 col-sm-12 text-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function change_user_status(status, id, tableType) {
        var check = confirm('Are You sure to want to change this transetion status!');
        if (!check) {
            return;
        }
        console.log(status);
        console.log(id);
        console.log(tableType);
        var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{ route('globalStatusUpdate') }}"
            , type: "POST"
            , data: {
                status: status
                , id: id
                , type: tableType
            , }
            , dataType: "JSON"
            , headers: {
                'X-CSRF-TOKEN': _token
            }
            , success: function(resp) {
                console.log(resp);
                if (resp.status == true) {
                    window.location.reload();
                } else {
                    alert('Something went wrong!');
                }

            }
        });
    }

</script>

<script>
    setTimeout(function() {
        $('.flash-message').fadeOut('fast');
    }, 2000)

    $('.editCatrgory').on("click", function() {
        var cat_id = $(this).data("id");
        console.log(cat_id);
        axios.post("{{route('edit-category',['type'=>'all','id'=>'0'])}}", {
            'id': cat_id
        , }).then(res => {
            console.log(res);
            console.log(res.data.data.name);
            $('#cat_id').val(res.data.data.id);
            $('#edit_cat_name').val(res.data.data.name);
            $('#edit_cat_description').val(res.data.data.description);
        }).catch(error => {
            console.error(error);
        });
    });

    $('.delete_cat_btn').on("click", function() {
        var cat_id = $(this).data("id");
        console.log(cat_id);
        $('#delete_id').val(cat_id);
    });

    $('#delete_category_btn').on("click", function() {
        var delete_id = $('#delete_id').val();
        axios.post("{{route('delete-category')}}", {
                'id': delete_id
            , })
            .then(res => {
                console.log(res);
                window.location.reload()
            }).catch(error => {
                console.error(error);
            });
    });

</script>
@endsection