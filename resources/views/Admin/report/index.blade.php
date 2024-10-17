@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'report';
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
                    Report
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
        @if(Auth::guard('user')->user()->role !== 'user')
        <div class="card col-12 col-md-12 col-sm-6 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="#" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-md-6 col-lg-4 col-sm-12">
                                        <label>Start Time</label>
                                        <input type="date" class="form-control" name="start_date" id="start_time" placeholder="Enter Name" aria-label="Enter Start Time" value="{{old('start_time')}}" required>
                                    </div>
                                    <div class="col-md-6 col-lg-3 col-sm-12 mt-3">
                                        <label>End Time</label>
                                        <input type="date" name="end_time" class="form-control" id="end_time" placeholder="Enter End Time">
                                    </div>
                                    <div class="col-md-2 col-lg-1 col-sm-12 text-end">
                                        <label></label>
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        @endif


        <div class="card col-12 col-md-12 col-sm-6 col-lg-12 mb-2">
            <section>
                <div class="container mt-4 mb-4">
                    <div class="row">
                        <h5 class="fw-bold">Search Report
                        </h5>
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="bg-white">
                                <form class="row g-3" method="post" action="{{route('report')}}" enctype="multipart/form-data">
                                    @csrf

                                    <div class="col-md-6 col-lg-4 col-sm-12">
                                        <input type="text" class="form-control" name="search" placeholder="Search report By transection id" aria-label="Enter Name" required>
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
                            <th>Order Id</th>
                            <th>Transection No</th>
                            <th>Transection Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['report'] as $key=>$item)
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
                                <strong>{{$item->created_at}}</strong>
                            </td>
                            <td>
                                <strong>{{$item->amount}}</strong>
                            </td>
                            <td>
                                @if($item->status == '1')
                                <span class="badge rounded-pill bg-secondary">Initiate</span>
                                @elseif($item->status == '2')
                                <span class="badge rounded-pill bg-success">Approved</span>
                                @else
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
                {!! $data['report']->links() !!}
            </div>
        </div>
        <!--/ Borderless Table -->
    </div>
</div>
<script>
    function change_user_status(status, id, tableType) {
        return confirm('Are You sure to want to change this transetion status!');
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
