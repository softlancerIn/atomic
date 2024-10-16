@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'comission';
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Commission List</h4>
            </div>
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
                            @if(Auth::guard('user')->user()->role == 'admin')
                            <th>Company Name</th>
                            @endif
                            <th>Todays's Transaction</th>
                            <th>Todays's comision</th>
                            <th>Total Transaction</th>
                            <th>Total comission</th>
                            {{-- <th>Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['company'] as $item)
                        <tr>
                            @if(Auth::guard('user')->user()->role == 'admin')
                            <th>{{$item->name}}</th>
                            @endif
                            <td class="d-flex">
                                <strong>{{$item->todayTotalTransection}}</strong>
                            </td>
                            <td>{{$item->todayTransectionData ?? '--'}}</td>
                            <td>{{$item->totalTransection ?? '--'}}</td>
                            <td>{{$item->totalTransectionData ?? '--'}}</td>
                        </tr>

                        @endforeach
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
                {!! $data['company']->links() !!}
            </div>
        </div>
    </div>
</div>
<script>
    function change_user_status(status, id, tableType) {
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
                    alert(resp.message);
                    window.location.reload();
                }

            }
        });
    }

</script>
@endsection
