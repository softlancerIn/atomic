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
        @if (Session::has('error'))
        <div class="alert alert-danger">
            <p>{{Session::get('error')}}</p>
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
                            <th>Recived Payment</th>
                            <th>Pending Payment</th>
                            <th>TimeStamp</th>
                            @if(Auth::guard('user')->user()->role != 'user')
                            <th>Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['settelment'] as $item)
                        <tr>
                            <td class="d-flex">
                                <strong>{{$item->company->name}}</strong>
                            </td>
                            <td>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                                    <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z" />
                                </svg>{{$item->amount ?? '--'}}</td>
                            <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                                    <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z" />
                                </svg>{{$item->recived_amount ?? '0'}}</td>
                            <td><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-currency-rupee" viewBox="0 0 16 16">
                                    <path d="M4 3.06h2.726c1.22 0 2.12.575 2.325 1.724H4v1.051h5.051C8.855 7.001 8 7.558 6.788 7.558H4v1.317L8.437 14h2.11L6.095 8.884h.855c2.316-.018 3.465-1.476 3.688-3.049H12V4.784h-1.345c-.08-.778-.357-1.335-.793-1.732H12V2H4z" />
                                </svg>{{$item->amount - $item->recived_amount}}</td>
                            <td>{{$item->created_at ?? '--'}}</td>

                            <td class="d-flex">
                                @if($item->status == '0')
                                @if(Auth::guard('user')->user()->role != 'user')
                                <div class="mx-1">
                                    <a class="btn btn-sm btn-dark partPaymet" data-id="{{$item->id}}" data-bs-toggle="modal" data-bs-target="#partPayments" style="color:white;">
                                        Part Payment
                                    </a>
                                </div>
                                <div class="">
                                    <a class="btn btn-sm btn-success" id="" data-id="{{$item->id}}" onclick="change_user_status('1','{{$item->id}}','settelment')">
                                        Approved
                                    </a>
                                </div>
                                <div class="mx-1">
                                    <a href="#" class="btn btn-sm btn-danger" onclick="change_user_status('2','{{$item->id}}','settelment')">
                                        Reject</a>
                                </div>
                                @endif
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
<!---------------------- Modal ---------------------->
<div class="modal fade" id="partPayments" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="edit_catrgory">Part Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('settelmentPartPayment')}}" method="post" class="needs-validation" enctype="multipart/form-data" novalidate>
                    @csrf
                    <!--- Hidden Category Type ---------->
                    <input type="hidden" name="id" id="transactionId">
                    <div class="col-md-12">
                        <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter Amount" aria-label="Owner Name">
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.partPaymet').on("click", function() {
            var id = $(this).data("id");
            console.log(id);
            $('#transactionId').val(id);
        });
    });

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
