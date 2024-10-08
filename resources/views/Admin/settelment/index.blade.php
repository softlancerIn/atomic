@extends('Admin.Layout.layout')
@section('content')
@php
$active = 'settelment';
@endphp
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-6">
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Dashboard / </span>Settelment List</h4>
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
                            <th>Company Name</th>
                            <th>Amount</th>
                            <th>TimeStamp</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['settelment'] as $item)
                        <tr>
                            <td class="d-flex">
                                <strong>{{$item->company->name}}</strong>
                            </td>
                            <td>{{$item->amount ?? '--'}}</td>
                            <td>{{$item->created_at ?? '--'}}</td>

                            <td class="d-flex">
                                @if($item->status == '0')
                                <div class="">
                                    <a class="btn btn-sm btn-success" id="" data-id="{{$item->id}}" onclick="change_user_status('1','{{$item->id}}','settelment')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z" />
                                        </svg>
                                        Approved
                                    </a>
                                </div>
                                <div class="mx-1">
                                    <a href="#" class="btn btn-sm btn-danger" onclick="change_user_status('2','{{$item->id}}','settelment')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                        </svg>Reject</a>
                                </div>
                                @else
                                @if($item->status == '1')
                                <span class="badge rounded-pill bg-success">Approved</span>
                                @endif
                                @if($item->status == '2')
                                <span class="badge rounded-pill bg-danger">Reject</span>
                                @endif
                                @endif
                            </td>
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
                {!! $data['settelment']->links() !!}
            </div>
        </div>
    </div>
</div>
<script>
    function change_user_status(status, id, tableType) {
        var _token = '{{ csrf_token() }}';
        $.ajax({
            url: "{{ route('globalStatusUpdate') }}",
            type: "POST",
            data: {
                status: status,
                id: id,
                type: tableType,
            },
            dataType: "JSON",
            headers: {
                'X-CSRF-TOKEN': _token
            },
            success: function(resp) {
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